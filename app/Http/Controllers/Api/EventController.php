<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request, GoogleCalendarService $calendarService)
    {
        // Ambil event berdasarkan rentang tanggal yang diminta oleh FullCalendar
        $optParams = [
            'timeMin' => (new \DateTime($request->start))->format(\DateTime::RFC3339),
            'timeMax' => (new \DateTime($request->end))->format(\DateTime::RFC3339),
            'singleEvents' => true,
            'orderBy' => 'startTime',
        ];

        $events = $calendarService->getEvents($optParams)->getItems();

        // Format data agar sesuai dengan yang dibutuhkan FullCalendar
        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->getId(),
                'title' => $event->getSummary(),
                'start' => $event->getStart()->getDateTime(),
                'end' => $event->getEnd()->getDateTime(),
            ];
        }

        return response()->json($formattedEvents);
    }

    public function store(Request $request, GoogleCalendarService $calendarService)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $event = $calendarService->createEvent(
            $request->title,
            new \DateTime($request->start),
            new \DateTime($request->end)
        );

        return response()->json([
            'id' => $event->getId(),
            'title' => $event->getSummary(),
            'start' => $event->getStart()->getDateTime(),
            'end' => $event->getEnd()->getDateTime(),
        ]);
    }

    public function update(Request $request, $eventId, GoogleCalendarService $calendarService)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $calendarService->updateEvent(
            $eventId,
            $request->title,
            new \DateTime($request->start),
            new \DateTime($request->end)
        );

        return response()->json(['message' => 'Event updated successfully.']);
    }

    public function destroy($eventId, GoogleCalendarService $calendarService)
    {
        $calendarService->deleteEvent($eventId);
        return response()->json(['message' => 'Event deleted successfully.']);
    }
}
