<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class TicketController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $tickets = Ticket::with('event')
            ->where('user_id', auth()->id())->orderByDesc('ticket_id')
            ->get();
        $totalAmount = $tickets->where('ticket_type', '!=', 'purchased')->sum('price');
        return view('tickets.index', compact('tickets', 'totalAmount'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'ticket_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $totalPrice = $validated['price'];
        $quantity = $validated['quantity'];
        $pricePerTicket = $totalPrice / $quantity;

        // Create tickets based on quantity
        for ($i = 0; $i < $request->quantity; $i++) {
            Ticket::create([
                'event_id' => $request->event_id,
                'ticket_type' => $request->ticket_type,
                'user_id' => auth()->id(),
                'price' => $pricePerTicket,
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Tickets purchased successfully!');
    }
    public function destroy(Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $ticket->delete();
        return back()->with('success', 'Ticket deleted successfully!');
    }

    public function createCheckoutSession(Request $request): \Illuminate\Http\JsonResponse
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Calculate the total amount again or pass it securely from the front end
        $amount = $request->amount; // This should be in the smallest currency unit

        $checkout_session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Total Ticket Payment',
                    ],
                    'unit_amount' => $amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/cancel'),
        ]);

        return response()->json(['id' => $checkout_session->id]);
    }
    public function paymentSuccess(Request $request): \Illuminate\Http\RedirectResponse
    {

        DB::beginTransaction();
        try {
            // Perform your logic here, e.g., update payment status, send email, etc.
            // Update the ticket status to 'purchased'
            Ticket::where('user_id', auth()->id())
                ->where('ticket_type', '!=' ,'purchased')
                ->update(['ticket_type' => 'purchased']);

            DB::commit();
            return redirect()->route('tickets.index')->with('success', 'Payment successful! Thank you for your purchase.');
        } catch (\Exception $e) {
            DB::rollback();
            // Handle exceptions, perhaps log them and show an error message to the user
            return redirect()->route('tickets.index')->with('error', 'An error occurred during the purchase process.');
        }

    }
    public function paymentCancel(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('tickets.index')->with('error', 'Payment was cancelled.');
    }
}

