<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Schedule;
use App\Models\Speaker;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'event_name' => 'required',
            'event_description' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'location' => 'required',
            'max_tickets' => 'required|integer',
            'event_image' => 'required|string',
            'price' => 'required|numeric',
            // Assuming these are arrays of IDs
            'sponsors' => 'sometimes|array',
            'sponsors[*].*' => 'exists:sponsors,sponsor_id',
            'schedules' => 'required|array',

        ]);

        // Begin a transaction in case one of the steps fails
        DB::beginTransaction();
        try {
            $event = Event::create($validated);
            if (isset($validated['sponsors'])) {
                $event->sponsors()->attach($validated['sponsors']);
            }

            foreach ($request->schedules as $scheduleData) {
                $schedule = new Schedule($scheduleData);
                $schedule->event_id = $event->event_id;
                $schedule->speaker_id = $scheduleData['speaker_id'] ?? null; // Assuming speaker_id can be nullable
                $schedule->session_name = $scheduleData['session_name'] ?? null;
                $schedule->description = $scheduleData['description'] ?? null;
                $schedule->start_time = $scheduleData['start_time'] ?? null;
                $schedule->end_time = $scheduleData['end_time'] ?? null;
                $schedule->save();
            }

            DB::commit();

            return redirect()->route('events.index')->with('success', 'Event created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the event: ' . $e->getMessage());

        }
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $speakers = Speaker::all();
        $sponsors = Sponsor::all();
        return view('events.create', compact('speakers', 'sponsors'));
    }

    public function show(Event $event)
    {

        $schedules = Schedule::where('event_id', $event->event_id)->get();
        $speakers = Speaker::all();
        $event->load('sponsors');
        return view('events.show', compact('event', 'schedules', 'speakers'));

    }

    public function edit(Event $event): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $speakers = Speaker::all();
        $sponsors = Sponsor::all();
        $event = Event::find($event->event_id);
        $schedules = $event->schedules()->get();
        return view('events.edit', compact('event', 'speakers', 'sponsors', 'schedules'));
    }

    public function update(Request $request, Event $event): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'event_name' => 'required',
            'event_description' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'location' => 'required',
            'max_tickets' => 'required|integer',
            'price' => 'required|numeric',
            // Assuming these are arrays of IDs
            'sponsors' => 'sometimes|array',
            'sponsors[*].*' => 'exists:sponsors,sponsor_id',
            'schedules' => 'required|array',

        ]);
        $event->update($validated);
        if (isset($validated['sponsors'])) {
            $event->sponsors()->sync($validated['sponsors']);
        } else {
            // If no sponsors are provided, detach all sponsors
            $event->sponsors()->detach();
        }
        foreach ($request->schedules as $index => $scheduleData) {
            if (isset($scheduleData['schedule_id'])) {
                $schedule = Schedule::find($scheduleData['schedule_id']);
                if ($schedule) {
                    $schedule->update([
                        'speaker_id' => $scheduleData['speaker_id'],
                        'session_name' => $scheduleData['session_name'],
                        'description' => $scheduleData['description'],
                        'start_time' => $scheduleData['start_time'],
                        'end_time' => $scheduleData['end_time'],
                    ]);
                }
            }else {
                // Create new schedule
                $newScheduleData = [
                    'speaker_id' => $scheduleData['speaker_id'], // Assuming speaker_id can be nullable
                    'session_name' => $scheduleData['session_name'],
                    'description' => $scheduleData['description'],
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'event_id' => $event->event_id
                ];

                if (!empty($scheduleData['speaker_id'])) {
                    $newScheduleData['speaker_id'] = $scheduleData['speaker_id'];
                }

                $newSchedule = new Schedule($newScheduleData);
                Log::info($newSchedule);
                $newSchedule->save();
            }
        }

        return redirect()->route('events.index');
    }

    public function destroy(Event $event): \Illuminate\Http\RedirectResponse
    {
        $event->delete();
        return redirect()->route('events.index');
    }
}
