<div class="space-y-8 flex flex-col items-start w-full">
    {{-- Summary Boxes (Vertical Stack) --}}
    <div class="flex flex-col gap-4 w-full max-w-sm">
        {{-- Total Users --}}
        <div wire:click="toggleSection('users')" class="cursor-pointer group flex items-center gap-4 p-5 glass-panel transition-all hover:-translate-y-1 {{ $activeSection === 'users' ? 'ring-2 ring-blue-500' : '' }}">
            <div class="p-3 rounded-xl bg-blue-100/50">
                <flux:icon name="users" class="size-6 text-blue-600" />
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-zinc-500 font-bold">Total Users</p>
                <p class="text-2xl font-black text-zinc-800">{{ $totalUsers }}</p>
            </div>
        </div>

        {{-- Total Events --}}
        <div wire:click="toggleSection('events')" class="cursor-pointer group flex items-center gap-4 p-5 glass-panel transition-all hover:-translate-y-1 {{ $activeSection === 'events' ? 'ring-2 ring-purple-500' : '' }}">
            <div class="p-3 rounded-xl bg-purple-100/50">
                <flux:icon name="calendar" class="size-6 text-purple-600" />
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-zinc-500 font-bold">Total Events</p>
                <p class="text-2xl font-black text-zinc-800">{{ $totalEvents }}</p>
            </div>
        </div>

        {{-- Total Registrations --}}
        <div wire:click="toggleSection('registrations')" class="cursor-pointer group flex items-center gap-4 p-5 glass-panel transition-all hover:-translate-y-1 {{ $activeSection === 'registrations' ? 'ring-2 ring-green-500' : '' }}">
            <div class="p-3 rounded-xl bg-green-100/50">
                <flux:icon name="clipboard-document-check" class="size-6 text-green-600" />
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-zinc-500 font-bold">Registrations</p>
                <p class="text-2xl font-black text-zinc-800">{{ $totalRegistrations }}</p>
            </div>
        </div>

        {{-- Full Events --}}
        <div wire:click="toggleSection('full')" class="cursor-pointer group flex items-center gap-4 p-5 glass-panel transition-all hover:-translate-y-1 {{ $activeSection === 'full' ? 'ring-2 ring-red-500' : '' }}">
            <div class="p-3 rounded-xl bg-red-100/50">
                <flux:icon name="no-symbol" class="size-6 text-red-600" />
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-zinc-500 font-bold">Full Events</p>
                <p class="text-2xl font-black text-zinc-800">{{ $fullEvents }}</p>
            </div>
        </div>

        {{-- Available Seats --}}
        <div wire:click="toggleSection('available')" class="cursor-pointer group flex items-center gap-4 p-5 glass-panel transition-all hover:-translate-y-1 {{ $activeSection === 'available' ? 'ring-2 ring-blue-500' : '' }}">
            <div class="p-3 rounded-xl bg-blue-100/50">
                <flux:icon name="ticket" class="size-6 text-blue-600" />
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-zinc-500 font-bold">Available Seats</p>
                <p class="text-2xl font-black text-zinc-800">{{ $availableSeats }}</p>
            </div>
        </div>
    </div>

    {{-- Details Sections --}}
    @if($activeSection === 'users')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300 w-full">
        <h3 class="text-xl font-black mb-6 text-zinc-800 flex items-center gap-2">
            <flux:icon name="users" class="size-6" />
            Account List (All Users)
        </h3>
        <div class="glass-panel overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-100/50 text-zinc-500 border-b border-zinc-200/50">
                    <tr>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Name</th>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Email</th>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Role</th>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Joined At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/30">
                    @foreach($usersList as $user)
                    <tr class="text-zinc-700 hover:bg-white/40 transition-colors">
                        <td class="px-6 py-4 font-bold">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-zinc-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $user->isAdmin() ? 'bg-pink-100 text-pink-700' : 'bg-zinc-100 text-zinc-700' }}">
                                {{ $user->isAdmin() ? 'Admin' : 'Student' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-zinc-500 font-medium">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($activeSection === 'events')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300 w-full">
        <h3 class="text-xl font-black mb-6 text-zinc-800 flex items-center gap-2">
            <flux:icon name="calendar" class="size-6" />
            All Events List
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($allEventsList as $event)
            <div class="glass-panel p-6 flex items-stretch gap-4 hover:-translate-y-2 transition-all duration-300 group">
                <div class="flex-1">
                    <div class="mb-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ max(0, $event->total_seats - $event->registrations_count) }} SEATS LEFT
                        </span>
                    </div>
                    <h4 class="text-lg font-bold text-zinc-800 mb-4 line-clamp-2 leading-tight group-hover:text-pink-600 transition-colors">{{ $event->title }}</h4>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-zinc-600 text-sm font-medium">
                            <flux:icon name="user" class="size-4 opacity-50" />
                            <span>{{ $event->speaker }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-zinc-600 text-sm font-medium">
                            <flux:icon name="map-pin" class="size-4 opacity-50" />
                            <span>{{ $event->location }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-zinc-600 text-sm font-bold">
                            <flux:icon name="users" class="size-4 opacity-50" />
                            <span class="{{ $event->registrations_count >= $event->total_seats ? 'text-red-500' : '' }}">
                                {{ $event->registrations_count }} / {{ $event->total_seats }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="w-px bg-zinc-200/50 mx-2"></div>

                <div class="flex flex-col justify-around py-2">
                    <button class="flex flex-col items-center gap-1 group/btn">
                        <flux:icon name="eye" class="size-5 text-blue-500 group-hover/btn:scale-110 transition-transform" />
                        <span class="text-[9px] font-black uppercase text-blue-500">VIEW</span>
                    </button>
                    <button class="flex flex-col items-center gap-1 group/btn">
                        <flux:icon name="pencil-square" class="size-5 text-indigo-500 group-hover/btn:scale-110 transition-transform" />
                        <span class="text-[9px] font-black uppercase text-indigo-500">EDIT</span>
                    </button>
                    <button class="flex flex-col items-center gap-1 group/btn">
                        <flux:icon name="trash" class="size-5 text-red-500 group-hover/btn:scale-110 transition-transform" />
                        <span class="text-[9px] font-black uppercase text-red-500">DEL</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($activeSection === 'available')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300 w-full">
        <h3 class="text-xl font-black mb-6 text-zinc-800 flex items-center gap-2">
            <flux:icon name="ticket" class="size-6" />
            Available Events (Not Full)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($availableEventsList as $event)
            <div class="glass-panel p-6 flex items-stretch gap-4 hover:-translate-y-2 transition-all duration-300 group">
                <div class="flex-1">
                    <div class="mb-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $event->total_seats - $event->registrations_count }} SEATS LEFT
                        </span>
                    </div>
                    <h4 class="text-lg font-bold text-zinc-800 mb-4 line-clamp-1 group-hover:text-pink-600 transition-colors">{{ $event->title }}</h4>
                    
                    <div class="flex items-center gap-2 text-zinc-600 text-sm font-bold">
                        <flux:icon name="users" class="size-4 opacity-50" />
                        <span>{{ $event->registrations_count }} / {{ $event->total_seats }}</span>
                    </div>
                </div>

                <div class="w-px bg-zinc-200/50 mx-2"></div>

                <div class="flex flex-col justify-center gap-4 px-2">
                    <button class="flex flex-col items-center gap-1 group/btn">
                        <flux:icon name="eye" class="size-5 text-blue-500 group-hover/btn:scale-110 transition-transform" />
                    </button>
                    <button class="flex flex-col items-center gap-1 group/btn">
                        <flux:icon name="pencil-square" class="size-5 text-indigo-500 group-hover/btn:scale-110 transition-transform" />
                    </button>
                </div>
            </div>
            @endforeach
            @if(count($availableEventsList) === 0)
            <div class="col-span-full py-12 text-center text-zinc-500 italic glass-panel">
                No available events found.
            </div>
            @endif
        </div>
    </div>
    @endif

    @if($activeSection === 'full')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300 w-full">
        <h3 class="text-xl font-black mb-6 text-zinc-800 flex items-center gap-2">
            <flux:icon name="no-symbol" class="size-6" />
            Full Events List
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($fullEventsList as $event)
            <div class="glass-panel p-6 flex items-stretch gap-4 hover:-translate-y-2 transition-all duration-300 group">
                <div class="flex-1 text-zinc-400 opacity-80">
                    <div class="mb-4">
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            FULLY BOOKED
                        </span>
                    </div>
                    <h4 class="text-lg font-bold text-zinc-500 mb-4 line-clamp-1 italic">{{ $event->title }}</h4>
                    
                    <div class="flex items-center gap-2 text-sm font-bold">
                        <flux:icon name="users" class="size-4 opacity-50" />
                        <span>{{ $event->registrations_count }} / {{ $event->total_seats }}</span>
                    </div>
                </div>

                <div class="w-px bg-zinc-200/50 mx-2"></div>

                <div class="flex flex-col justify-center px-2">
                    <flux:icon name="lock-closed" class="size-6 text-zinc-400" />
                </div>
            </div>
            @endforeach
            @if(count($fullEventsList) === 0)
            <div class="col-span-full py-12 text-center text-zinc-500 italic glass-panel">
                No full events found.
            </div>
            @endif
        </div>
    </div>
    @endif

    @if($activeSection === 'registrations')
    <div class="animate-in fade-in slide-in-from-top-4 duration-300 w-full">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-black text-zinc-800 flex items-center gap-2">
                <flux:icon name="clipboard-document-check" class="size-6" />
                All Event Registrations
            </h3>
            <span class="px-3 py-1 glass-panel text-[10px] font-black text-zinc-500">{{ count($registrationsList) }} RECORDS</span>
        </div>
        <div class="glass-panel overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-100/50 text-zinc-500 border-b border-zinc-200/50">
                    <tr>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Student Name</th>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Event Title</th>
                        <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Registered Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/30">
                    @foreach($registrationsList as $reg)
                    <tr class="text-zinc-700 hover:bg-white/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold">{{ $reg->user?->name ?? 'N/A' }}</div>
                            <div class="text-[10px] text-zinc-500 font-medium">{{ $reg->user?->email }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-pink-600">{{ $reg->event?->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-zinc-500 font-medium">{{ $reg->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                    @if(count($registrationsList) === 0)
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-zinc-500 italic">No registrations found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
