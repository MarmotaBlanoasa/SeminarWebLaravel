<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; // Assuming you have a Ticket model

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    public function cart()
    {
        return view('cart'); // Assuming you have a 'cart' view
    }

    public function addToCart($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            abort(404);
        }

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $ticket->name,
                    "quantity" => 1,
                    "price" => $ticket->price,
                    // Add other relevant fields as needed
                ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Ticket added successfully to the cart!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Ticket added successfully to the cart!');
        }

        $cart[$id] = [
            "name" => $ticket->name,
            "quantity" => 1,
            "price" => $ticket->price,
            // Add other relevant fields as needed
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Ticket added successfully to the cart!');
    }

    public function update(Request $request)
    {
        if ($request->id and $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Ticket removed successfully from the cart!');
        }
    }
}
