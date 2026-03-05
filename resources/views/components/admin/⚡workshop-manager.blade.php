<?php

use Livewire\Component;
use App\Models\Workshop;

new class extends Component
{
    public $workshops = [];
    public $workshopId = null;
    public $title = '';
    public $lecturer = '';
    public $location = '';
    public $capacity = '';
    public $description = '';
    public $isEditing = false;
    public $showModal = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'lecturer' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadWorkshops();
    }

    public function loadWorkshops()
    {
        $this->workshops = Workshop::withCount('registrations')->get();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['workshopId', 'title', 'lecturer', 'location', 'capacity', 'description']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $workshop = Workshop::findOrFail($id);
        $this->workshopId = $workshop->id;
        $this->title = $workshop->title;
        $this->lecturer = $workshop->lecturer;
        $this->location = $workshop->location;
        $this->capacity = $workshop->capacity;
        $this->description = $workshop->description;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing && $this->workshopId) {
            $workshop = Workshop::find($this->workshopId);
            $workshop->update([
                'title' => $this->title,
                'lecturer' => $this->lecturer,
                'location' => $this->location,
                'capacity' => $this->capacity,
                'description' => $this->description,
            ]);
        } else {
            Workshop::create([
                'title' => $this->title,
                'lecturer' => $this->lecturer,
                'location' => $this->location,
                'capacity' => $this->capacity,
                'description' => $this->description,
            ]);
        }

        $this->showModal = false;
        $this->loadWorkshops();
    }

    public function delete($id)
    {
        Workshop::destroy($id);
        $this->loadWorkshops();
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold dark:text-gray-100">Workshop Management</h2>
        <button wire:click="create" class="px-4 py-2 bg-black text-white dark:bg-white dark:text-black rounded-md text-sm font-medium">Add Workshop</button>
    </div>

    <!-- Workshops Table -->
    <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 font-medium">Title</th>
                    <th class="px-6 py-3 font-medium">Lecturer</th>
                    <th class="px-6 py-3 font-medium">Location</th>
                    <th class="px-6 py-3 font-medium">Registrations / Capacity</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @foreach($workshops as $workshop)
                <tr class="dark:text-gray-200">
                    <td class="px-6 py-4">{{ $workshop->title }}</td>
                    <td class="px-6 py-4">{{ $workshop->lecturer }}</td>
                    <td class="px-6 py-4">{{ $workshop->location }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $workshop->registrations_count >= $workshop->capacity ? 'text-red-500 font-semibold' : 'text-green-600' }}">
                            {{ $workshop->registrations_count }} / {{ $workshop->capacity }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button wire:click="edit({{ $workshop->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>
                        <button wire:click="delete({{ $workshop->id }})" wire:confirm="Are you sure you want to delete this workshop?" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                    </td>
                </tr>
                @endforeach
                @if(count($workshops) === 0)
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No workshops found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-md shadow-lg border border-neutral-200 dark:border-neutral-700 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-medium mb-4 dark:text-white">{{ $isEditing ? 'Edit Workshop' : 'New Workshop' }}</h3>
            
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Title</label>
                    <input type="text" wire:model="title" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Lecturer</label>
                    <input type="text" wire:model="lecturer" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                    @error('lecturer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-gray-300">Location</label>
                        <input type="text" wire:model="location" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-gray-300">Total Capacity</label>
                        <input type="number" wire:model="capacity" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                        @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Description</label>
                    <textarea wire:model="description" rows="3" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-neutral-200 dark:border-neutral-700 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-800">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-black text-white dark:bg-white dark:text-black rounded-md text-sm font-medium">Save</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>