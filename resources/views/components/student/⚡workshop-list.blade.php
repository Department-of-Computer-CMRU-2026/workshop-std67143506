<?php

use Livewire\Component;
use App\Models\Workshop;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $workshops = [];
    public $userRegistrations = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->workshops = Workshop::withCount('registrations')->get();
        if (Auth::check()) {
            $this->userRegistrations = Registration::where('user_id', Auth::id())->pluck('workshop_id')->toArray();
        }
    }

    public function register($workshopId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (count($this->userRegistrations) >= 3) {
            session()->flash('error', 'You can only register for a maximum of 3 workshops.');
            return;
        }

        $workshop = Workshop::withCount('registrations')->findOrFail($workshopId);

        if (in_array($workshopId, $this->userRegistrations)) {
            session()->flash('error', 'You are already registered for this workshop.');
            return;
        }

        if ($workshop->registrations_count >= $workshop->capacity) {
            session()->flash('error', 'This workshop is already full.');
            return;
        }

        Registration::create([
            'user_id' => Auth::id(),
            'workshop_id' => $workshopId,
        ]);

        session()->flash('success', 'Successfully registered for ' . $workshop->title . '!');
        $this->loadData();
    }

    public function unregister($workshopId)
    {
        if (!Auth::check()) {
            return;
        }

        Registration::where('user_id', Auth::id())->where('workshop_id', $workshopId)->delete();
        session()->flash('success', 'Successfully unregistered.');
        $this->loadData();
    }
};
?>

<div wire:poll.5s="loadData">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold dark:text-gray-100">Available Workshops</h2>
        <span class="text-sm font-medium px-3 py-1 rounded {{ count($this->userRegistrations) >= 3 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
            My Registrations: {{ count($this->userRegistrations) }} / 3
        </span>
    </div>

    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($workshops as $workshop)
            @php
                $isFull = $workshop->registrations_count >= $workshop->capacity;
                $isRegistered = in_array($workshop->id, $this->userRegistrations);
            @endphp
            <div class="bg-white dark:bg-zinc-900 border {{ $isRegistered ? 'border-green-500' : 'border-neutral-200 dark:border-neutral-700' }} rounded-xl p-6 shadow-sm flex flex-col hidden">
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold dark:text-white">{{ $workshop->title }}</h3>
                        @if($isRegistered)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Registered</span>
                        @elseif($isFull)
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Full</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $workshop->description }}</p>
                    <div class="space-y-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <p><span class="font-medium text-gray-900 dark:text-gray-200">Lecturer:</span> {{ $workshop->lecturer }}</p>
                        <p><span class="font-medium text-gray-900 dark:text-gray-200">Location:</span> {{ $workshop->location }}</p>
                        <p><span class="font-medium text-gray-900 dark:text-gray-200">Seats:</span> {{ $workshop->registrations_count }} / {{ $workshop->capacity }}</p>
                    </div>
                </div>
                
                <div class="mt-auto pt-4 border-t border-neutral-100 dark:border-neutral-800">
                    @if($isRegistered)
                        <button wire:click="unregister({{ $workshop->id }})" wire:confirm="Are you sure you want to unregister?" class="w-full px-4 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 dark:bg-zinc-800 dark:border-red-900 dark:text-red-400 dark:hover:bg-zinc-700 rounded-md text-sm font-medium transition-colors">
                            Cancel Registration
                        </button>
                    @elseif($isFull)
                        <button disabled class="w-full px-4 py-2 bg-gray-100 text-gray-400 dark:bg-zinc-800 dark:text-gray-500 rounded-md text-sm font-medium cursor-not-allowed">
                            Workshop Full
                        </button>
                    @else
                        @if(count($this->userRegistrations) >= 3)
                            <button disabled class="w-full px-4 py-2 bg-gray-100 text-gray-400 dark:bg-zinc-800 dark:text-gray-500 rounded-md text-sm font-medium cursor-not-allowed">
                                Registration Limit Reached (3/3)
                            </button>
                        @else
                            <button wire:click="register({{ $workshop->id }})" class="w-full px-4 py-2 bg-black text-white hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 rounded-md text-sm font-medium transition-colors">
                                Register Now
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach

        @if(count($workshops) === 0)
            <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400">
                No workshops are currently scheduled. Check back later!
            </div>
        @endif
    </div>
</div>