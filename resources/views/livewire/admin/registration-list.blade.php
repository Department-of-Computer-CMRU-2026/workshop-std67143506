<div class="space-y-6">
    <div class="flex items-center justify-between gap-4 mb-6">
        <h2 class="text-3xl font-black text-zinc-800 tracking-tight">Registrations</h2>
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Search user or event..." icon="magnifying-glass" class="max-w-xs glass-panel" />
    </div>

    <div class="glass-panel overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-100/50 text-zinc-500 border-b border-zinc-200/50">
                <tr>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Student</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Event</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-center">Registered At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200/30">
                @forelse($registrations as $reg)
                <tr class="text-zinc-700 hover:bg-white/40 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <flux:avatar :name="$reg->user->name" :initials="$reg->user->initials()" size="sm" class="shadow-sm" />
                            <div>
                                <p class="font-bold">{{ $reg->user->name }}</p>
                                <p class="text-[10px] font-medium text-zinc-500">{{ $reg->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-pink-600">{{ $reg->event->title ?? '-' }}</td>
                    <td class="px-6 py-4 text-center text-zinc-500 font-medium">
                        {{ $reg->created_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-zinc-400 font-bold uppercase tracking-widest italic">No registrations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
