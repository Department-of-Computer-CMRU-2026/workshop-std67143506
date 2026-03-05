<?php

use Livewire\Component;
use App\Models\Event;

new class extends Component
{
    public $events = [];
    public $eventId = null;
    public $title = '';
    public $speaker = '';
    public $location = '';
    public $total_seats = '';
    public $description = '';
    public $isEditing = false;
    public $showModal = false;

    public $expandedEvents = [];

    protected $listeners = ['deleteConfirmed' => 'delete'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'speaker' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'total_seats' => 'required|integer|min:1',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Event::with(['registrations.user'])->withCount('registrations')->get();
    }

    public function toggleRegistrations($id)
    {
        if (in_array($id, $this->expandedEvents)) {
            $this->expandedEvents = array_diff($this->expandedEvents, [$id]);
        } else {
            $this->expandedEvents[] = $id;
        }
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['eventId', 'title', 'speaker', 'location', 'total_seats', 'description']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $event = Event::findOrFail($id);
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->speaker = $event->speaker;
        $this->location = $event->location;
        $this->total_seats = $event->total_seats;
        $this->description = $event->description;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing && $this->eventId) {
            $event = Event::find($this->eventId);
            $event->update([
                'title' => $this->title,
                'speaker' => $this->speaker,
                'location' => $this->location,
                'total_seats' => $this->total_seats,
                'description' => $this->description,
            ]);
        } else {
            Event::create([
                'title' => $this->title,
                'speaker' => $this->speaker,
                'location' => $this->location,
                'total_seats' => $this->total_seats,
                'description' => $this->description,
            ]);
        }

        $this->showModal = false;
        $this->loadEvents();
        
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => $this->isEditing ? 'Event updated successfully.' : 'Event created successfully.',
        ]);
    }

    public function delete($id)
    {
        Event::destroy($id);
        $this->loadEvents();

        $this->dispatch('swal:success', [
            'title' => 'Deleted!',
            'text' => 'Event has been deleted successfully.',
        ]);
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold dark:text-gray-100">Event Management</h2>
        <button 
            wire:click="create" 
            type="button"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add New Event
        </button>
    </div>

    <!-- Events Table -->
    <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 font-medium">Title</th>
                    <th class="px-6 py-3 font-medium">Speaker</th>
                    <th class="px-6 py-3 font-medium">Location</th>
                    <th class="px-6 py-3 font-medium">Registrations / Total Seats</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @foreach($events as $event)
                <tr class="dark:text-gray-200 border-t border-neutral-100 dark:border-neutral-800">
                    <td class="px-6 py-4">{{ $event->title }}</td>
                    <td class="px-6 py-4">{{ $event->speaker }}</td>
                    <td class="px-6 py-4">{{ $event->location }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ count($event->registrations) >= $event->total_seats ? 'text-red-500 font-semibold' : 'text-green-600' }}">
                            {{ count($event->registrations) }} / {{ $event->total_seats }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <button wire:click="toggleRegistrations({{ $event->id }})" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200 font-medium">
                            {{ in_array($event->id, $this->expandedEvents) ? 'Hide' : 'View' }}
                        </button>
                        <button wire:click="edit({{ $event->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Edit</button>
                        <button wire:click="$dispatch('swal:confirm', [{ title: 'Delete Event?', text: 'Are you sure you want to delete this event?', action: 'deleteConfirmed', id: {{ $event->id }} }])" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete</button>
                    </td>
                </tr>
                @if(in_array($event->id, $this->expandedEvents))
                <tr class="bg-gray-50/50 dark:bg-zinc-800/30">
                    <td colspan="5" class="px-8 py-4">
                        <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden shadow-sm">
                            <table class="w-full text-xs text-left">
                                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 border-b border-neutral-100 dark:border-neutral-800">
                                    <tr>
                                        <th class="px-4 py-2 font-semibold uppercase tracking-wider">Student Name</th>
                                        <th class="px-4 py-2 font-semibold uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-2 font-semibold uppercase tracking-wider">Registered At</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                                    @forelse($event->registrations as $registration)
                                    <tr class="dark:text-gray-300">
                                        <td class="px-4 py-2 font-medium">{{ $registration->user->name }}</td>
                                        <td class="px-4 py-2">{{ $registration->user->email }}</td>
                                        <td class="px-4 py-2 text-gray-500">{{ $registration->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-zinc-800/50 italic">
                                            No students registered for this event yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
                @if(count($events) === 0)
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No events found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-md shadow-lg border border-neutral-200 dark:border-neutral-700 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-medium mb-4 dark:text-white">{{ $isEditing ? 'Edit Event' : 'New Event' }}</h3>
            
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Title</label>
                    <input type="text" wire:model="title" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Speaker</label>
                    <input type="text" wire:model="speaker" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                    @error('speaker') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-gray-300">Location</label>
                        <input type="text" wire:model="location" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-gray-300">Total Seats</label>
                        <input type="number" wire:model="total_seats" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                        @error('total_seats') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Description</label>
                    <textarea wire:model="description" rows="3" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-100 dark:border-neutral-800 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-zinc-800 transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-sm font-medium shadow-sm transition-colors">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>