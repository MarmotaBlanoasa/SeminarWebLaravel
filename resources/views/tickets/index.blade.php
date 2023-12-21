@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h1>My Tickets</h1>
        <div class="card">
            <div class="card-body">
                <h5>Total to Pay: ${{ number_format($totalAmount, 2) }}</h5>
                <button id="checkout-button" class="btn btn-primary">Pay with Stripe</button>
            </div>
        </div>
        @foreach ($tickets as $ticket)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket->event->event_name }} - {{ ucfirst($ticket->ticket_type) }}
                        Ticket</h5>
                    <p class="card-text">
                        Event Date: {{ $ticket->event->date_start->format('F d, Y g:i A') }} -
                        {{ $ticket->event->date_end->format('F d, Y g:i A') }}
                    </p>
                    <p class="card-text">
                        Ticket Price: ${{ number_format($ticket->price, 2) }}
                    </p>
                    <p class="card-text">
                        Purchased At: {{ $ticket->created_at->format('F d, Y g:i A') }}
                    </p>
                    @if($ticket->ticket_type != 'purchased')
                        <form action="{{ route('tickets.destroy', $ticket->ticket_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this ticket?');">Remove
                            </button>
                        </form>
                    @else
                        <p class="card-text">
                            <strong>Payment Status: </strong> {{ ucfirst($ticket->ticket_type) }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <script>
        // Create an instance of the Stripe object with your publishable API key
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");

        var checkoutButton = document.getElementById('checkout-button');
        checkoutButton.addEventListener('click', function () {
            // Create a new Checkout Session using the server-side endpoint you
            // created in step 3.
            fetch('/create-checkout-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({amount: '{{ $totalAmount }}'})
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (session) {
                    return stripe.redirectToCheckout({sessionId: session.id});
                })
                .then(function (result) {
                    // If `redirectToCheckout` fails due to a browser or network
                    // error, display the localized error message to your customer.
                    if (result.error) {
                        alert(result.error.message);
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
