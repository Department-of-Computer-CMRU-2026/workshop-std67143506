<?php

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $events = [];
    public $userRegistrations = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->events = Event::withCount('registrations')->get();
        if (Auth::check()) {
            $this->userRegistrations = Registration::where('user_id', Auth::id())->pluck('event_id')->toArray();
        }
    }

    #[Livewire\Attributes\On('confirmRegister')]
    public function register($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (count($this->userRegistrations) >= 3) {
            $this->dispatch('swal:success', [
                'title' => 'Limit Reached',
                'text' => 'You can only register for a maximum of 3 events.',
                'icon' => 'error'
            ]);
            return;
        }

        $event = Event::withCount('registrations')->findOrFail($id);

        if (in_array($id, $this->userRegistrations)) {
            $this->dispatch('swal:success', [
                'title' => 'Notice',
                'text' => 'You are already registered for this event.',
                'icon' => 'info'
            ]);
            return;
        }

        if ($event->registrations_count >= $event->total_seats) {
            $this->dispatch('swal:success', [
                'title' => 'Error',
                'text' => 'This event is already full.',
                'icon' => 'error'
            ]);
            return;
        }

        try {
            Registration::create([
                'user_id' => Auth::id(),
                'event_id' => $id,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatch('swal:success', [
                'title' => 'Error',
                'text' => 'You are already registered for this event.',
                'icon' => 'error'
            ]);
            return;
        }

        $this->dispatch('swal:success', [
            'title' => 'Registration Successful!',
            'text' => 'You have joined ' . $event->title,
        ]);
        
        $this->loadData();
    }

    #[Livewire\Attributes\On('confirmUnregister')]
    public function unregister($id)
    {
        if (!Auth::check()) {
            return;
        }

        Registration::where('user_id', Auth::id())->where('event_id', $id)->delete();
        
        $this->dispatch('swal:success', [
            'title' => 'Canceled!',
            'text' => 'Registration has been removed.',
        ]);

        $this->loadData();
    }
};
?>

<div wire:poll.5s="loadData">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold dark:text-gray-100">Available Events</h2>
        <span class="text-sm font-medium px-3 py-1 rounded {{ count($this->userRegistrations) >= 3 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
            My Registrations: {{ count($this->userRegistrations) }} / 3
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            @php
                $isFull = $event->registrations_count >= $event->total_seats;
                $isRegistered = in_array($event->id, $this->userRegistrations);
            @endphp
            <div class="bg-white dark:bg-zinc-900 border {{ $isRegistered ? 'border-green-500' : 'border-neutral-200 dark:border-neutral-700' }} rounded-xl p-6 shadow-sm flex flex-col relative">
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1 mr-2">
                            <h3 class="text-lg font-bold dark:text-white leading-tight cursor-default">{{ $event->title }}</h3>
                        </div>
                        
                        <div class="flex items-center gap-2 shrink-0">
                            @if($isRegistered)
                                <button 
                                    wire:click="$dispatch('swal:confirm', [{ title: 'Unregister?', text: 'Are you sure you want to leave this event?', action: 'confirmUnregister', id: {{ $event->id }}, confirmButtonText: 'Yes, unregister!' }])"
                                    class="px-3 py-1 bg-white border border-red-200 text-red-600 hover:bg-red-50 dark:bg-zinc-800 dark:border-red-900 dark:text-red-400 dark:hover:bg-zinc-700 rounded-md text-xs font-semibold transition-all shadow-sm active:scale-95"
                                >
                                    Cancel
                                </button>
                                <span class="px-3 py-1 bg-white border border-green-200 text-green-600 dark:bg-zinc-800 dark:border-green-900 dark:text-green-400 rounded-md text-xs font-bold shadow-sm">
                                    Registered
                                </span>
                            @elseif($isFull)
                                <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300 uppercase tracking-wider">Full</span>
                            @else
                                @if(count($this->userRegistrations) < 3)
                                    <button 
                                        wire:click="$dispatch('swal:confirm', [{ title: 'Join Event?', text: 'Do you want to register for this event?', action: 'confirmRegister', id: {{ $event->id }}, confirmButtonText: 'Yes, register!' }])"
                                        class="px-3 py-1 bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-md text-xs font-bold shadow-sm transition-all active:scale-95 flex items-center gap-1"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Register
                                    </button>
                                @else
                                    <span class="text-[10px] text-gray-400 font-medium tracking-tight">Limit (3/3)</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $event->description }}</p>
                    
                    <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400 border-t border-neutral-100 dark:border-neutral-800 pt-4 mt-auto">
                        <p><span class="font-medium text-gray-900 dark:text-gray-200">Speaker:</span> {{ $event->speaker }}</p>
                        <p><span class="font-medium text-gray-900 dark:text-gray-200">Location:</span> {{ $event->location }}</p>
                        <p><span class="font-medium text-gray-900 dark:text-gray-200">Seats:</span> {{ $event->registrations_count }} / {{ $event->total_seats }}</p>
                    </div>
                </div>
            </div>
        @endforeach

        @if(count($events) === 0)
            <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400 border-2 border-dashed border-neutral-100 dark:border-neutral-800 rounded-xl">
                No events are currently scheduled. Check back later!
            </div>
        @endif
    </div>
</div>
