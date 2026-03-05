    <div class="flex items-center justify-between pb-4 border-b border-zinc-200 dark:border-zinc-700">
        <div>
            <flux:heading size="xl" level="1">Manage Events</flux:heading>
            <flux:subheading>Create and manage your workshop events</flux:subheading>
        </div>
        <flux:button variant="primary" wire:click="openCreate" icon="plus">
            Add Event
        </flux:button>
    </div>

    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-sm">
            <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Title</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Speaker</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Location</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Seats</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Registered</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                @forelse($events as $event)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <td class="px-4 py-3 text-zinc-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">{{ $event->title }}</td>
                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">{{ $event->speaker }}</td>
                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">{{ $event->location }}</td>
                    <td class="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300">{{ $event->total_seats }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $event->registrations_count >= $event->total_seats ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' }}">
                            {{ $event->registrations_count }} / {{ $event->total_seats }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button size="sm" variant="ghost" icon="pencil" wire:click="openEdit({{ $event->id }})">
                                Edit
                            </flux:button>
                            <flux:button size="sm" variant="danger" icon="trash" wire:click="deleteConfirm({{ $event->id }})">
                                Delete
                            </flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-zinc-400">No events found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-2xl p-6 space-y-5">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">{{ $editingId ? 'Edit Event' : 'Create Event' }}</flux:heading>
                <flux:button variant="ghost" icon="x-mark" wire:click="$set('showModal', false)" />
            </div>

            <div class="space-y-4">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model="title" placeholder="Event title" />
                    @error('title') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Speaker</flux:label>
                    <flux:input wire:model="speaker" placeholder="Speaker name" />
                    @error('speaker') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Location</flux:label>
                    <flux:input wire:model="location" placeholder="Venue / Room" />
                    @error('location') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>Total Seats</flux:label>
                    <flux:input type="number" wire:model="total_seats" min="1" />
                    @error('total_seats') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancel</flux:button>
                <flux:button variant="primary" wire:click="save">
                    {{ $editingId ? 'Update' : 'Create' }}
                </flux:button>
            </div>
        </div>
    </div>
    @endif
</div>
