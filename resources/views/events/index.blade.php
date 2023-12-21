@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Events</h1>
        @if(Auth::user() && Auth::user()->role == 'admin')
            <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Start date</th>
                <th>Finish date</th>
                <th>Location</th>
                <th>Max tickets</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->event_name }}</td>
                    <td>{{ $event->event_description }}</td>
                    <td>{{ $event->date_start->format('Y-m-d') }}</td>
                    <td>{{ $event->date_end->format('Y-m-d') }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->max_tickets }}</td>
                    <td>{{ $event->price }}</td>
                    <td>
                        <a href="{{ route('events.show', $event->event_id) }}" class="btn btn-primary">View Details</a>
                        @if(Auth::user() && Auth::user()->role == 'admin')
                            <a href="{{ route('events.edit', $event->event_id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('events.destroy', $event->event_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
