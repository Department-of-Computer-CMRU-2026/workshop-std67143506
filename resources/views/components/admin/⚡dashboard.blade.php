<?php

use Livewire\Component;
use App\Models\Workshop;
use App\Models\Registration;

new class extends Component
{
    public function with()
    {
        $workshops = Workshop::withCount('registrations')->get();
        $totalWorkshops = $workshops->count();
        $totalRegistrations = Registration::count();
        $fullWorkshops = $workshops->filter(fn($w) => $w->registrations_count >= $w->capacity)->count();
        $availableWorkshops = $totalWorkshops - $fullWorkshops;

        return [
            'totalWorkshops' => $totalWorkshops,
            'totalRegistrations' => $totalRegistrations,
            'fullWorkshops' => $fullWorkshops,
            'availableWorkshops' => $availableWorkshops,
        ];
    }
};
?>

<div>
    <h2 class="text-xl font-semibold mb-6 dark:text-gray-100">Admin Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="p-6 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Workshops</h3>
            <p class="text-3xl font-bold mt-2 dark:text-white">{{ $totalWorkshops }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Registrations</h3>
            <p class="text-3xl font-bold mt-2 dark:text-white">{{ $totalRegistrations }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Available Workshops</h3>
            <p class="text-3xl font-bold mt-2 text-green-600">{{ $availableWorkshops }}</p>
        </div>
        <div class="p-6 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Full Workshops</h3>
            <p class="text-3xl font-bold mt-2 text-red-500">{{ $fullWorkshops }}</p>
        </div>
    </div>
</div>