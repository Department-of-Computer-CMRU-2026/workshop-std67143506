<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <flux:heading size="xl">Registrations</flux:heading>
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Search user or event..." icon="magnifying-glass" class="max-w-xs" />
    </div>

    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-sm">
            <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Student</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Event</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Registered At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                @forelse($registrations as $reg)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <td class="px-4 py-3 text-zinc-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <flux:avatar :name="$reg->user->name" :initials="$reg->user->initials()" size="sm" />
                            <div>
                                <p class="font-medium text-zinc-800 dark:text-zinc-100">{{ $reg->user->name }}</p>
                                <p class="text-xs text-zinc-500">{{ $reg->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-200 font-medium">{{ $reg->event->title ?? '-' }}</td>
                    <td class="px-4 py-3 text-center text-zinc-500 text-xs">
                        {{ $reg->created_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center text-zinc-400">No registrations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
