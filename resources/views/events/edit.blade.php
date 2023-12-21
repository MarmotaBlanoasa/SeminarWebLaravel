@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Event</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.update', $event->event_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" class="form-control" id="event_name" name="event_name"
                       value="{{ $event->event_name }}" required>
            </div>

            <div class="form-group">
                <label for="event_description">Event Description:</label>
                <input type="text" class="form-control" id="event_description" name="event_description"
                       value="{{ $event->event_description }}" required>
            </div>

            <div class="form-group">
                <label for="date_start">Start Date:</label>
                <input type="date" class="form-control" id="date_start" name="date_start"
                       value="{{ $event->date_start->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="date_end">End Date:</label>
                <input type="date" class="form-control" id="date_end" name="date_end"
                       value="{{ $event->date_end->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}"
                       required>
            </div>

            <div class="form-group">
                <label for="max_tickets">Max Tickets:</label>
                <input type="number" class="form-control" id="max_tickets" name="max_tickets"
                       value="{{ $event->max_tickets }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $event->price }}" required>
            </div>

            @foreach($sponsors as $sponsor)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sponsors[]" value="{{ $sponsor->sponsor_id }}"
                           id="sponsor_{{ $sponsor->sponsor_id }}"
                        {{ $event->sponsors->contains('sponsor_id', $sponsor->sponsor_id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="sponsor_{{ $sponsor->sponsor_id }}">
                        {{ $sponsor->nume }}
                    </label>
                </div>
            @endforeach

            <div class="form-group">
                <div id="schedule-wrapper">
                    @foreach($event->schedules as $index => $schedule)
                        <input type="hidden" name="schedules[{{$index}}][schedule_id]" value="{{ $schedule->schedule_id }}">
                        <div class="single-schedule">
                            <p class="fw-bold">Schedule #1</p>
                            <input type="text" name="schedules[{{ $index }}][session_name]"
                                   value="{{ $schedule->session_name }}" placeholder="Session Name"
                                   class="form-control">
                            <input type="time" name="schedules[{{ $index }}][start_time]"
                                   value="{{ $schedule->start_time->format('H:i') }}" placeholder="Start Time"
                                   class="form-control">
                            <input type="time" name="schedules[{{ $index }}][end_time]"
                                   value="{{ $schedule->end_time->format('H:i') }}" placeholder="End Time"
                                   class="form-control">
                            <textarea name="schedules[{{ $index }}][description]" placeholder="Description"
                                      class="form-control">{{ $schedule->description }}</textarea>
                            <select name="schedules[{{ $index }}][speaker_id]" class="form-control">
                                @foreach($speakers as $speaker)
                                    <option
                                        value="{{ $speaker->speaker_id }}" {{ $schedule->speaker_id == $speaker->speaker_id ? 'selected' : '' }}>
                                        {{ $speaker->nume }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="removeSchedule btn btn-danger">Remove</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="addSchedule" class="btn btn-secondary">Add Another Schedule</button>
            </div>

            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            let scheduleIndex = {{ $event->schedules->count() }};
            $('#addSchedule').on('click', function () {
                const scheduleHtml = `
                <div class="single-schedule">
                    <p class="fw-bold">Schedule #${scheduleIndex}</p>
                    <input type="text" name="schedules[${scheduleIndex}][session_name]" placeholder="Session Name" class="form-control">
                    <input type="datetime-local" name="schedules[${scheduleIndex}][start_time]" placeholder="Start Time" class="form-control">
                    <input type="datetime-local" name="schedules[${scheduleIndex}][end_time]" placeholder="End Time" class="form-control">
                    <textarea name="schedules[${scheduleIndex}][description]" placeholder="Description" class="form-control"></textarea>
                    <select name="schedules[${scheduleIndex}][speaker_id]" class="form-control">
                        @foreach($speakers as $speaker)
                            <option value="{{ $speaker->speaker_id }}">{{ $speaker->nume }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="removeSchedule btn btn-danger">Remove</button>
                </div>
`;
                $('#schedule-wrapper').append(scheduleHtml);
                scheduleIndex++;
            });

            $('#schedule-wrapper').on('click', '.removeSchedule', function () {
                $(this).closest('.single-schedule').remove();
            });
        });
    </script>
@endsection
