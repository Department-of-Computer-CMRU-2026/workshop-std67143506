<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <flux:heading size="xl">Manage Users</flux:heading>
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." icon="magnifying-glass" class="max-w-xs" />
    </div>

    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-sm">
            <thead class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">#</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300">Email</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Role</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Registrations</th>
                    <th class="px-4 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300">Joined</th>
                    <th class="px-4 py-3 text-right font-semibold text-zinc-600 dark:text-zinc-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                @forelse($users as $user)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <td class="px-4 py-3 text-zinc-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <flux:avatar :name="$user->name" :initials="$user->initials()" size="sm" />
                            <span class="font-medium text-zinc-800 dark:text-zinc-100">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }}">
                            {{ $user->role ?? 'student' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300">
                        {{ $user->registrations_count }}
                    </td>
                    <td class="px-4 py-3 text-center text-zinc-500 text-xs">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <flux:button variant="ghost" size="sm" wire:click="edit({{ $user->id }})">Edit</flux:button>
                        <flux:button variant="ghost" size="sm" wire:click="$dispatch('swal:confirm', [{ title: 'Delete User?', text: 'Are you sure you want to delete this user?', action: 'deleteUser', id: {{ $user->id }} }])" class="text-red-500 hover:text-red-600">Delete</flux:button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-zinc-400">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-md shadow-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium mb-4 dark:text-white">Edit User</h3>
            
            <form wire:submit.prevent="save" class="space-y-4">
                <flux:field>
                    <flux:label>Name</flux:label>
                    <flux:input wire:model="name" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>Email</flux:label>
                    <flux:input type="email" wire:model="email" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>Role</flux:label>
                    <flux:select wire:model="role">
                        <flux:select.option value="student">Student</flux:select.option>
                        <flux:select.option value="admin">Admin</flux:select.option>
                    </flux:select>
                    <flux:error name="role" />
                </flux:field>

                <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-100 dark:border-neutral-800 mt-6">
                    <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save Changes</flux:button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
