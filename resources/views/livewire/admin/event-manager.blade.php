<div class="space-y-10">
    {{-- Summary Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Total Users --}}
        <div class="glass-panel p-5 flex items-center gap-4 transition-all hover:-translate-y-1">
            <div class="p-3 rounded-xl bg-blue-100/50">
                <flux:icon name="users" class="size-6 text-blue-600" />
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-black">Total Users</p>
                <p class="text-xl font-black text-zinc-800">{{ $stats['totalUsers'] }}</p>
            </div>
        </div>

        {{-- Total Events --}}
        <div class="glass-panel p-5 flex items-center gap-4 transition-all hover:-translate-y-1">
            <div class="p-3 rounded-xl bg-purple-100/50">
                <flux:icon name="calendar" class="size-6 text-purple-600" />
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-black">Total Events</p>
                <p class="text-xl font-black text-zinc-800">{{ $stats['totalEvents'] }}</p>
            </div>
        </div>

        {{-- Total Registrations --}}
        <div class="glass-panel p-5 flex items-center gap-4 transition-all hover:-translate-y-1">
            <div class="p-3 rounded-xl bg-green-100/50">
                <flux:icon name="clipboard-document-check" class="size-6 text-green-600" />
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-black">Registrations</p>
                <p class="text-xl font-black text-zinc-800">{{ $stats['totalRegistrations'] }}</p>
            </div>
        </div>

        {{-- Full Events --}}
        <div class="glass-panel p-5 flex items-center gap-4 transition-all hover:-translate-y-1">
            <div class="p-3 rounded-xl bg-red-100/50">
                <flux:icon name="no-symbol" class="size-6 text-red-600" />
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-black">Full Events</p>
                <p class="text-xl font-black text-zinc-800">{{ $stats['fullEvents'] }}</p>
            </div>
        </div>

        {{-- Available Seats --}}
        <div class="glass-panel p-5 flex items-center gap-4 transition-all hover:-translate-y-1">
            <div class="p-3 rounded-xl bg-cyan-100/50">
                <flux:icon name="ticket" class="size-6 text-cyan-600" />
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-black">Seats Left</p>
                <p class="text-xl font-black text-zinc-800">{{ $stats['availableSeats'] }}</p>
            </div>
        </div>
    </div>

    {{-- Header Content --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-zinc-800 tracking-tight">Events Management</h1>
            <p class="text-zinc-500 font-medium">Create and coordinate your modern workshop events</p>
        </div>
        <flux:button variant="primary" wire:click="openCreate" icon="plus" class="px-6 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-pink-200 transition-all">
            NEW EVENT
        </flux:button>
    </div>

    {{-- Premium Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($events as $event)
        <div class="glass-panel p-0 flex items-stretch overflow-hidden group hover:-translate-y-2 transition-all duration-500 hover:shadow-2xl hover:shadow-pink-100/50">
            {{-- Card Body --}}
            <div class="p-7 flex-1 flex flex-col items-start min-w-0">
                {{-- Seats Left Badge --}}
                <div class="mb-5">
                    <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-green-100">
                        {{ max(0, $event->total_seats - $event->registrations_count) }} SEATS LEFT
                    </span>
                </div>

                {{-- Title --}}
                <h4 class="text-xl font-black text-zinc-800 mb-6 line-clamp-2 leading-tight group-hover:text-pink-600 transition-colors">
                    {{ $event->title }}
                </h4>
                
                {{-- Icon rows --}}
                <div class="space-y-4 w-full">
                    <div class="flex items-center gap-3 text-zinc-600">
                        <div class="p-1.5 rounded-lg bg-zinc-50/80">
                            <flux:icon name="user" class="size-4 text-zinc-500" />
                        </div>
                        <span class="text-sm font-bold truncate">{{ $event->speaker }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3 text-zinc-600">
                        <div class="p-1.5 rounded-lg bg-zinc-50/80">
                            <flux:icon name="map-pin" class="size-4 text-zinc-500" />
                        </div>
                        <span class="text-sm font-bold truncate">{{ $event->location }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="p-1.5 rounded-lg bg-zinc-50/80">
                            <flux:icon name="users" class="size-4 text-zinc-500" />
                        </div>
                        <div class="flex items-center gap-1.5 flex-1">
                            <div class="h-1.5 flex-1 bg-zinc-100 rounded-full overflow-hidden">
                                @php $percent = $event->total_seats > 0 ? ($event->registrations_count / $event->total_seats) * 100 : 0; @endphp
                                <div class="h-full bg-pink-500 transition-all duration-1000" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="text-xs font-black text-zinc-700 whitespace-nowrap">
                                {{ $event->registrations_count }} / {{ $event->total_seats }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Sidebar --}}
            <div class="w-16 bg-zinc-50/30 border-s border-zinc-100/50 flex flex-col justify-around py-4 items-center">
                <button wire:click="openEdit({{ $event->id }})" class="p-2.5 rounded-xl text-indigo-500 hover:bg-indigo-50 transition-all group/action">
                    <flux:icon name="eye" class="size-5 group-hover/action:scale-125 transition-transform" />
                    <span class="text-[8px] font-black uppercase mt-1 block">VIEW</span>
                </button>
                <button wire:click="openEdit({{ $event->id }})" class="p-2.5 rounded-xl text-blue-500 hover:bg-blue-50 transition-all group/action">
                    <flux:icon name="pencil-square" class="size-5 group-hover/action:scale-125 transition-transform" />
                    <span class="text-[8px] font-black uppercase mt-1 block">EDIT</span>
                </button>
                <button wire:click="deleteConfirm({{ $event->id }})" class="p-2.5 rounded-xl text-red-500 hover:bg-red-50 transition-all group/action">
                    <flux:icon name="trash" class="size-5 group-hover/action:scale-125 transition-transform" />
                    <span class="text-[8px] font-black uppercase mt-1 block">DEL</span>
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center glass-panel">
            <flux:icon name="calendar" class="size-12 mx-auto mb-4 text-zinc-300" />
            <p class="text-zinc-500 font-bold uppercase tracking-widest">No events discovered yet</p>
            <flux:button variant="ghost" class="mt-4" wire:click="openCreate">Create your first event</flux:button>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $events->links() }}
    </div>

    {{-- Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/40 backdrop-blur-md animate-in fade-in duration-300">
        <div class="w-full max-w-lg glass-panel p-0 overflow-hidden shadow-3xl animate-in zoom-in-95 duration-300">
            <div class="bg-zinc-50/50 p-6 border-b border-zinc-200/50 flex items-center justify-between">
                <h3 class="text-xl font-black text-zinc-800">{{ $editingId ? 'EDIT EVENT' : 'CREATE NEW EVENT' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 transition-colors">
                    <flux:icon name="x-mark" class="size-6" />
                </button>
            </div>

            <div class="p-8 space-y-6">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-2 block">Event Title</label>
                    <input type="text" wire:model="title" class="w-full bg-white/50 border border-zinc-200 rounded-xl px-4 py-3 text-zinc-800 font-bold focus:ring-2 focus:ring-pink-500 focus:border-red-500 outline-none transition-all" placeholder="Enter session title...">
                    @error('title') <span class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-2 block">Speaker</label>
                        <input type="text" wire:model="speaker" class="w-full bg-white/50 border border-zinc-200 rounded-xl px-4 py-3 text-zinc-800 font-bold focus:ring-2 focus:ring-pink-500 focus:border-red-500 outline-none transition-all">
                        @error('speaker') <span class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-2 block">Venue / Room</label>
                        <input type="text" wire:model="location" class="w-full bg-white/50 border border-zinc-200 rounded-xl px-4 py-3 text-zinc-800 font-bold focus:ring-2 focus:ring-pink-500 focus:border-red-500 outline-none transition-all">
                        @error('location') <span class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-2 block">Total Capacity</label>
                    <input type="number" wire:model="total_seats" class="w-full bg-white/50 border border-zinc-200 rounded-xl px-4 py-3 text-zinc-800 font-bold focus:ring-2 focus:ring-pink-500 focus:border-red-500 outline-none transition-all">
                    @error('total_seats') <span class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="p-8 bg-zinc-50/50 border-t border-zinc-200/50 flex justify-end gap-3">
                <button wire:click="$set('showModal', false)" class="px-6 py-2.5 rounded-xl font-black text-[11px] text-zinc-500 hover:bg-zinc-200 transition-all">
                    CANCEL
                </button>
                <button wire:click="save" class="px-8 py-2.5 bg-zinc-800 text-white rounded-xl font-black text-[11px] hover:bg-zinc-700 shadow-xl transition-all">
                    {{ $editingId ? 'UPDATE EVENT' : 'SAVE EVENT' }}
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
