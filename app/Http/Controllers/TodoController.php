<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos()->orderBy('is_completed')->latest()->get();
        return view('todos.index', ['todos' => $todos]);
    }

    public function store(Request $request, GoogleCalendarService $calendarService)
    {
        $request->validate(['task' => 'required|string|max:255']);
        $todo = auth()->user()->todos()->create($request->only('task'));

        if ($request->filled('due_at')) {
            $userTimezone = new \DateTimeZone($request->user_timezone);
            $startTime = new \DateTime($request->due_at, $userTimezone);
            $endTime = (clone $startTime)->add(new \DateInterval('PT1H'));
            $event = $calendarService->createEvent($request->task, $startTime, $endTime);
            $todo->update(['due_at' => $startTime, 'google_event_id' => $event->getId()]);
        }
        return redirect()->route('todos.index');
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', ['todo' => $todo]);
    }

    public function update(Request $request, Todo $todo, GoogleCalendarService $calendarService)
    {
        // Logika untuk checkbox "selesai"
        if ($request->has('is_completed_update')) {
            $isCompleted = $request->boolean('is_completed');
            $todo->update(['is_completed' => $isCompleted]);

            if ($todo->google_event_id) {
                $summary = $todo->task;
                if ($isCompleted) {
                    $summary = "✅ [DONE] " . $summary;
                }
                $calendarService->updateEventSummary($todo->google_event_id, $summary);
            }
            return redirect()->route('todos.index');
        }

        // Logika untuk mengedit task dari form
        $request->validate(['task' => 'required|string|max:255']);
        $todo->update(['task' => $request->task]);

        if ($request->filled('due_at')) {
            $userTimezone = new \DateTimeZone($request->user_timezone);
            $startTime = new \DateTime($request->due_at, $userTimezone);
            $endTime = (clone $startTime)->add(new \DateInterval('PT1H'));
            $summary = $todo->is_completed ? "✅ [DONE] " . $request->task : $request->task;

            if ($todo->google_event_id) {
                $calendarService->updateEvent($todo->google_event_id, $summary, $startTime, $endTime);
            } else {
                $event = $calendarService->createEvent($summary, $startTime, $endTime);
                $todo->google_event_id = $event->getId();
            }
            $todo->due_at = $startTime;
            $todo->save();
        }

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo, GoogleCalendarService $calendarService)
    {
        if ($todo->google_event_id) {
            try {
                $calendarService->deleteEvent($todo->google_event_id);
            } catch (\Exception $e) { /* Abaikan jika event sudah dihapus */ }
        }
        $todo->delete();
        return redirect()->route('todos.index');
    }
}
