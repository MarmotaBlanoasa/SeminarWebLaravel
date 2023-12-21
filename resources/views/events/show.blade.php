{{-- resources/views/events/show.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $event->event_name }}</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Event Description</h5>
                <p class="card-text">{{ $event->event_description }}</p>
                <p class="card-text"><small class="text-muted">Starts
                        on: {{ $event->date_start->format('F d, Y') }}</small></p>
                <p class="card-text"><small class="text-muted">Ends on: {{ $event->date_end->format('F d, Y') }}</small>
                </p>
            </div>
        </div>

        <div class="mb-3">
            <h5>Sponsors</h5>
            <ul>
                @foreach ($event->sponsors as $sponsor)
                    <li>{{ $sponsor->nume }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-3">
            <h5>Schedules</h5>
            @foreach ($event->schedules as $schedule)
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title">{{ $schedule->session_name }}</h6>
                        <p class="card-text">{{ $schedule->description }}</p>
                        <p class="card-text">Speaker: @foreach($speakers as $speaker)
                                {{ $schedule->speaker_id == $speaker->speaker_id ? $speaker->nume : ''}}
                            @endforeach</p>
                        <p class="card-text">Time: {{ $schedule->start_time->format('g:i A') }}
                            - {{ $schedule->end_time->format('g:i A') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @if(Auth::user())
        <h3>Buy Tickets</h3>
        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->event_id }}">
            <input type="hidden" name="price" value="{{ $event->event_price }}" id="price">
            <div class="form-group">
                <label for="ticket_type">Ticket Type:</label>
                <select name="ticket_type" id="ticket_type" class="form-control">
                    <option value="general" data-price="{{ $event->price }}">General Admission</option>
                    <option value="vip" data-price="{{ $event->price * 2 }}">VIP</option>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1">
            </div>
            <p id="price_display">Price: $<span>{{ $event->price }}</span></p>
            <button type="submit" class="btn btn-primary">Purchase</button>
        </form>
    </div>
    @else
        <a href="/login">You must be logged in to purchase tickets.</a>
    @endif

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ticketType = document.getElementById('ticket_type');
        var quantityInput = document.getElementById('quantity');
        var priceInput = document.getElementById('price');
        var priceDisplay = document.getElementById('price_display').querySelector('span');

        // Function to update the displayed and hidden price based on selection and quantity
        function updatePrice() {
            var selectedOption = ticketType.options[ticketType.selectedIndex];
            var basePrice = parseFloat(selectedOption.getAttribute('data-price'));
            var quantity = parseInt(quantityInput.value);
            var totalPrice = basePrice * quantity;

            priceInput.value = totalPrice; // Update hidden input for form submission
            priceDisplay.textContent = totalPrice.toFixed(2); // Update display for user
        }

        // Event listeners for dropdown and quantity changes
        ticketType.addEventListener('change', updatePrice);
        quantityInput.addEventListener('input', updatePrice);

        // Initialize price on page load
        updatePrice();
    });
</script>
