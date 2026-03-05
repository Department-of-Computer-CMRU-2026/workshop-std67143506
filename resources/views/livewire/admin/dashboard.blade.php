<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Total Users --}}
        <div wire:click="toggleSection('users')" class="cursor-pointer group rounded-xl border {{ $activeSection === 'users' ? 'border-blue-500 ring-1 ring-blue-500' : 'border-zinc-200 dark:border-zinc-700' }} bg-white dark:bg-zinc-900 p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 group-hover:scale-110 transition-transform">
                <flux:icon name="users" class="size-6 text-blue-600 dark:text-blue-300" />
            </div>
            <div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Users</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-zinc-800 dark:text-zinc-100">{{ $totalUsers }}</p>
                    <span class="text-xs text-blue-500 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to view</span>
                </div>
            </div>
        </div>

        {{-- Total Events --}}
        <div wire:click="toggleSection('events')" class="cursor-pointer group rounded-xl border {{ $activeSection === 'events' ? 'border-purple-500 ring-1 ring-purple-500' : 'border-zinc-200 dark:border-zinc-700' }} bg-white dark:bg-zinc-900 p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 group-hover:scale-110 transition-transform">
                <flux:icon name="calendar" class="size-6 text-purple-600 dark:text-purple-300" />
            </div>
            <div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Events</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-zinc-800 dark:text-zinc-100">{{ $totalEvents }}</p>
                    <span class="text-xs text-purple-500 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to view all</span>
                </div>
            </div>
        </div>

        {{-- Total Registrations --}}
        <div wire:click="toggleSection('registrations')" class="cursor-pointer group rounded-xl border {{ $activeSection === 'registrations' ? 'border-green-500 ring-1 ring-green-500' : 'border-zinc-200 dark:border-zinc-700' }} bg-white dark:bg-zinc-900 p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 group-hover:scale-110 transition-transform">
                <flux:icon name="clipboard-document-check" class="size-6 text-green-600 dark:text-green-300" />
            </div>
            <div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Registrations</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-zinc-800 dark:text-zinc-100">{{ $totalRegistrations }}</p>
                    <span class="text-xs text-green-500 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to view all</span>
                </div>
            </div>
        </div>

        {{-- Full Events --}}
        <div wire:click="toggleSection('full')" class="cursor-pointer group rounded-xl border {{ $activeSection === 'full' ? 'border-red-500 ring-1 ring-red-500' : 'border-zinc-200 dark:border-zinc-700' }} bg-white dark:bg-zinc-900 p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 group-hover:scale-110 transition-transform">
                <flux:icon name="no-symbol" class="size-6 text-red-600 dark:text-red-300" />
            </div>
            <div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Full Events</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-zinc-800 dark:text-zinc-100">{{ $fullEvents }}</p>
                    <span class="text-xs text-red-500 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to view</span>
                </div>
            </div>
        </div>

        {{-- Available Seats --}}
        <div wire:click="toggleSection('available')" class="cursor-pointer group rounded-xl border {{ $activeSection === 'available' ? 'border-blue-500 ring-1 ring-blue-500' : 'border-zinc-200 dark:border-zinc-700' }} bg-white dark:bg-zinc-900 p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 group-hover:scale-110 transition-transform">
                <flux:icon name="ticket" class="size-6 text-blue-600 dark:text-blue-300" />
            </div>
            <div>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Available Seats</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-zinc-800 dark:text-zinc-100">{{ $availableSeats }}</p>
                    <span class="text-xs text-blue-500 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to view events</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Details Sections --}}
    @if($activeSection === 'users')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Account List (All Users)</h3>
        <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 border-b dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 font-medium">Name</th>
                        <th class="px-6 py-3 font-medium">Email</th>
                        <th class="px-6 py-3 font-medium">Role</th>
                        <th class="px-6 py-3 font-medium">Joined At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($usersList as $user)
                    <tr class="dark:text-gray-200">
                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs {{ $user->isAdmin() ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-700 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                {{ $user->isAdmin() ? 'Admin' : 'Student' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-zinc-500">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($activeSection === 'events')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">All Events List</h3>
        <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 border-b dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 font-medium">Title</th>
                        <th class="px-6 py-3 font-medium">Speaker</th>
                        <th class="px-6 py-3 font-medium">Location</th>
                        <th class="px-6 py-3 font-medium text-center">Registrations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($allEventsList as $event)
                    <tr class="dark:text-gray-200">
                        <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                        <td class="px-6 py-4">{{ $event->speaker }}</td>
                        <td class="px-6 py-4">{{ $event->location }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="{{ $event->registrations_count >= $event->total_seats ? 'text-red-500 font-bold' : 'text-zinc-700 dark:text-zinc-300' }}">
                                {{ $event->registrations_count }} / {{ $event->total_seats }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($activeSection === 'available')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Available Events (Not Full)</h3>
        <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 border-b dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 font-medium">Event Title</th>
                        <th class="px-6 py-3 font-medium text-center">Registrations</th>
                        <th class="px-6 py-3 font-medium text-center">Remaining</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($availableEventsList as $event)
                    <tr class="dark:text-gray-200">
                        <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                        <td class="px-6 py-4 text-center">{{ $event->registrations_count }} / {{ $event->total_seats }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-green-600 dark:text-green-400 font-bold">
                                {{ $event->total_seats - $event->registrations_count }} seats left
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if(count($availableEventsList) === 0)
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">No available events found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($activeSection === 'full')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Full Events List (Maximum Capacity)</h3>
        <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 border-b dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 font-medium">Event Title</th>
                        <th class="px-6 py-3 font-medium text-center">Registrations</th>
                        <th class="px-6 py-3 font-medium text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($fullEventsList as $event)
                    <tr class="dark:text-gray-200">
                        <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                        <td class="px-6 py-4 text-center">{{ $event->registrations_count }} / {{ $event->total_seats }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 font-bold">
                                FULL
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if(count($fullEventsList) === 0)
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">No full events yet.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($activeSection === 'registrations')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold dark:text-white">All Event Registrations</h3>
            <span class="text-sm text-zinc-500">{{ count($registrationsList) }} total records</span>
        </div>
        <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400 border-b dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 font-medium">Student Name</th>
                        <th class="px-6 py-3 font-medium">Event Title</th>
                        <th class="px-6 py-3 font-medium">Registered Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($registrationsList as $reg)
                    <tr class="dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $reg->user?->name ?? 'N/A' }}</div>
                            <div class="text-xs text-zinc-500">{{ $reg->user?->email }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $reg->event?->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-zinc-500">{{ $reg->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                    @if(count($registrationsList) === 0)
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">No registrations found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
