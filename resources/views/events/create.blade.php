{{-- resources/views/events/create.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Event</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" class="form-control" id="event_name" name="event_name" required>
            </div>

            <div class="form-group">
                <label for="event_description">Event Description:</label>
                <input type="text" class="form-control" id="event_description" name="event_description" required>
            </div>

            <div class="form-group">
                <label for="date_start">Start Date:</label>
                <input type="date" class="form-control" id="date_start" name="date_start" required>
            </div>

            <div class="form-group">
                <label for="date_end">End Date:</label>
                <input type="date" class="form-control" id="date_end" name="date_end" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <div class="form-group">
                <label for="max_tickets">Max Tickets:</label>
                <input type="number" class="form-control" id="max_tickets" name="max_tickets" required>
            </div>
            <input type="hidden" value="no_img" name="event_image" id="event_image">
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            @foreach($sponsors as $sponsor)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sponsors[]" value="{{ $sponsor->sponsor_id }}" id="sponsor_{{ $sponsor->sponsor_id }}">
                    <label class="form-check-label" for="sponsor_{{ $sponsor->sponsor_id }}">
                        {{ $sponsor->nume }}
                    </label>
                </div>
            @endforeach


            <div class="form-group">
                <div id="schedule-wrapper">
                    <div class="single-schedule">
                        <p class="fw-bold">Schedule #1</p>
                        <input type="text" name="schedules[0][session_name]" placeholder="Session Name"
                               class="form-control">
                        <input type="datetime-local" name="schedules[0][start_time]" placeholder="Start Time"
                               class="form-control">
                        <input type="datetime-local" name="schedules[0][end_time]" placeholder="End Time"
                               class="form-control">
                        <textarea name="schedules[0][description]" placeholder="Description"
                                  class="form-control"></textarea>
                        <select name="schedules[0][speaker_id]" class="form-control">
                            @foreach($speakers as $speaker)
                                <option value="{{ $speaker->speaker_id }}">{{ $speaker->nume }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" id="addSchedule" class="btn btn-secondary">Add Another Schedule</button>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        let speakerOptions = `@foreach($speakers as $speaker)
                                <option value="{{ $speaker->speaker_id }}">{{ $speaker->nume }}</option>
                          @endforeach`;
        // Using jQuery for simplicity
        $(document).ready(function () {
            let scheduleIndex = 1;
            $('#addSchedule').on('click', function () {
                const scheduleHtml = `
                <div class="single-schedule">
                    <p class="fw-bold">Schedule #${scheduleIndex + 1}</p>
                    <input type="text" name="schedules[${scheduleIndex}][session_name]" placeholder="Session Name" class="form-control">
                    <input type="datetime-local" name="schedules[${scheduleIndex}][start_time]" placeholder="Start Time" class="form-control">
                    <input type="datetime-local" name="schedules[${scheduleIndex}][end_time]" placeholder="End Time" class="form-control">
                    <textarea name="schedules[${scheduleIndex}][description]" placeholder="Description" class="form-control"></textarea>
                    <select name="schedules[${scheduleIndex}][speaker_id]" class="form-control">
                        ${speakerOptions}
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
