<?php

use Livewire\Component;
use App\Models\Workshop;

new class extends Component
{
    public $workshops = [];
    public $selectedWorkshopId = null;

    public function mount()
    {
        $this->workshops = Workshop::with(['registrations.user'])->get();
        if ($this->workshops->count() > 0) {
            $this->selectedWorkshopId = $this->workshops->first()->id;
        }
    }

    public function getSelectedWorkshopProperty()
    {
        if (!$this->selectedWorkshopId) return null;
        return $this->workshops->firstWhere('id', $this->selectedWorkshopId);
    }
};
?>

<div>
    <div class="mb-6 flex space-x-4 items-center">
        <h2 class="text-xl font-semibold dark:text-gray-100">Registrations</h2>
        <select wire:model.live="selectedWorkshopId" class="rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black">
            @foreach($workshops as $workshop)
                <option value="{{ $workshop->id }}">{{ $workshop->title }}</option>
            @endforeach
        </select>
    </div>

    @if($this->selectedWorkshop)
    <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 font-medium">Name</th>
                    <th class="px-6 py-3 font-medium">Email</th>
                    <th class="px-6 py-3 font-medium">Registered At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @foreach($this->selectedWorkshop->registrations as $registration)
                <tr class="dark:text-gray-200">
                    <td class="px-6 py-4">{{ $registration->user->name }}</td>
                    <td class="px-6 py-4">{{ $registration->user->email }}</td>
                    <td class="px-6 py-4">{{ $registration->created_at->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
                @if($this->selectedWorkshop->registrations->count() === 0)
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No registrations yet.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 dark:text-gray-400">No workshops available.</p>
    @endif
</div>