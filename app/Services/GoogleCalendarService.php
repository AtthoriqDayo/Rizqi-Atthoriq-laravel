<?php
// app/Services/GoogleCalendarService.php
namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarService
{
    protected $client;
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->client = $this->setupClient();
    }

    /**
     * Sets up the Google API client, including token refresh.
     */
    private function setupClient(): GoogleClient
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->setScopes(Calendar::CALENDAR);
        $client->setAccessToken($this->user->google_token);

        // Refresh the token if it's expired
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($this->user->google_refresh_token);
            $this->user->update([
                'google_token' => $client->getAccessToken(),
            ]);
        }

        return $client;
    }

    /**
     * Get the configured Calendar service.
     */
    public function getService(): Calendar
    {
        return new Calendar($this->client);
    }

    /**
     * Fetch events from the user's primary calendar.
     */
    public function getEvents(array $options = [])
    {
        $service = $this->getService();
        $calendarId = 'primary';
        return $service->events->listEvents($calendarId, $options);
    }

    // Add methods for createEvent, updateEvent, deleteEvent as needed
    // Example:
    /*
    public function createEvent(array $data)
    {
        $service = $this->getService();
        $event = new \Google\Service\Calendar\Event($data);
        return $service->events->insert('primary', $event);
    }
    */


    /**
     * Create a new event in the user's primary calendar.
     */
    public function createEvent($summary, \DateTime $startTime, \DateTime $endTime)
    {
        $service = $this->getService();
        $event = new \Google\Service\Calendar\Event([
            'summary' => $summary,
            'start' => ['dateTime' => $startTime->format(\DateTime::RFC3339)],
            'end' => ['dateTime' => $endTime->format(\DateTime::RFC3339)],
        ]);

        return $service->events->insert('primary', $event);
    }

    /**
     * Delete an event from the user's primary calendar.
     */
    public function deleteEvent(string $eventId)
    {
        $service = $this->getService();
        // Return value is empty on success, so we don't need to return it
        $service->events->delete('primary', $eventId);
    }

        public function updateEvent(string $eventId, string $summary, \DateTime $startTime, \DateTime $endTime)
    {
        $service = $this->getService();
        $event = $service->events->get('primary', $eventId);

        $event->setSummary($summary);
        $event->getStart()->setDateTime($startTime->format(\DateTime::RFC3339));
        $event->getEnd()->setDateTime($endTime->format(\DateTime::RFC3339));

        return $service->events->update('primary', $eventId, $event);
    }

    // Tambahkan juga method ini untuk hanya mengubah judulnya
    public function updateEventSummary(string $eventId, string $summary)
    {
        $service = $this->getService();
        $event = $service->events->get('primary', $eventId);
        $event->setSummary($summary);
        return $service->events->update('primary', $eventId, $event);
    }
}
