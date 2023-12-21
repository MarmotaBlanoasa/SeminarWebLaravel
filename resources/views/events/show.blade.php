{{-- resources/views/events/show.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $event->event_name }}</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Event Description</h5>
                <p class="card-text">{{ $event->event_description }}</p>
                <p class="card-text"><small class="text-muted">Starts on: {{ $event->date_start->format('F d, Y') }}</small></p>
                <p class="card-text"><small class="text-muted">Ends on: {{ $event->date_end->format('F d, Y') }}</small></p>
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
                        <p class="card-text">Speaker: @foreach($speakers as $speaker) {{ $schedule->speaker_id == $speaker->speaker_id ? $speaker->nume : 'TBA' }} @endforeach</p>
                        <p class="card-text">Time: {{ $schedule->start_time->format('g:i A') }} - {{ $schedule->end_time->format('g:i A') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Add more event details as needed --}}
    </div>
@endsection
