<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalUsers = 0;
    public int $totalEvents = 0;
    public int $totalRegistrations = 0;
    public int $fullEvents = 0;
    public int $availableSeats = 0;

    public $usersList = [];
    public $availableEventsList = [];
    public $allEventsList = [];
    public $fullEventsList = [];
    public $registrationsList = [];
    public $activeSection = null; // 'users', 'available', 'events', 'full', 'registrations'

    public function mount(): void
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->totalEvents = Event::count();
        $this->totalRegistrations = Registration::count();

        $events = Event::withCount('registrations')->get();

        $this->fullEvents = $events->filter(fn($event) => $event->registrations_count >= $event->total_seats)->count();
        $this->availableSeats = $events->sum(fn($event) => max(0, $event->total_seats - $event->registrations_count));
    }

    public function toggleSection($section)
    {
        if ($this->activeSection === $section) {
            $this->activeSection = null;
        }
        else {
            $this->activeSection = $section;
            if ($section === 'users') {
                $this->usersList = User::all();
            }
            elseif ($section === 'available') {
                $this->availableEventsList = Event::withCount('registrations')
                    ->get()
                    ->filter(fn($event) => $event->registrations_count < $event->total_seats);
            }
            elseif ($section === 'events') {
                $this->allEventsList = Event::withCount('registrations')->get();
            }
            elseif ($section === 'full') {
                $this->fullEventsList = Event::withCount('registrations')
                    ->get()
                    ->filter(fn($event) => $event->registrations_count >= $event->total_seats);
            }
            elseif ($section === 'registrations') {
                $this->registrationsList = \App\Models\Registration::with(['user', 'event'])->latest()->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
