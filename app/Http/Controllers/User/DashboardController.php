<?php

// app/Http/Controllers/User/DashboardController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\GoogleCalendarService;
use Exception;

class DashboardController extends Controller
{
    public function __invoke(GoogleCalendarService $calendarService)
    {
        try {
            // Fetch upcoming events
            $optParams = [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c'),
            ];
            $events = $calendarService->getEvents($optParams)->getItems();
        } catch(Exception $e) {
            // Handle exceptions, e.g., token invalidation
            report($e);
            $events = [];
            // Optionally, redirect to re-authenticate
        }

        return view('dashboard', ['events' => $events]);
    }
}