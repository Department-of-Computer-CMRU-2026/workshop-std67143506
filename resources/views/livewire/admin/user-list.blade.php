<div class="space-y-6">
    <div class="flex items-center justify-between gap-4 mb-6">
        <h2 class="text-3xl font-black text-zinc-800 tracking-tight">Manage Users</h2>
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." icon="magnifying-glass" class="max-w-xs glass-panel" />
    </div>

    <div class="glass-panel overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-100/50 text-zinc-500 border-b border-zinc-200/50">
                <tr>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Name</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px]">Email</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-center">Role</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-center">Registrations</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-center">Joined</th>
                    <th class="px-6 py-4 font-black uppercase tracking-widest text-[10px] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200/30">
                @forelse($users as $user)
                <tr class="text-zinc-700 hover:bg-white/40 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <flux:avatar :name="$user->name" :initials="$user->initials()" size="sm" class="shadow-sm" />
                            <span class="font-bold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-zinc-600 font-medium">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                            {{ $user->role === 'admin' ? 'bg-pink-100 text-pink-700' : 'bg-zinc-100 text-zinc-700' }}">
                            {{ $user->role ?? 'student' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-zinc-600">
                        {{ $user->registrations_count }}
                    </td>
                    <td class="px-6 py-4 text-center text-zinc-500 font-medium">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <flux:button variant="ghost" size="sm" wire:click="edit({{ $user->id }})" class="font-black text-[10px]">EDIT</flux:button>
                            <flux:button variant="ghost" size="sm" wire:click="$dispatch('swal:confirm', [{ title: 'Delete User?', text: 'Are you sure you want to delete this user?', action: 'deleteUser', id: {{ $user->id }} }])" class="text-red-500 hover:text-red-600 font-black text-[10px]">DELETE</flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-zinc-400 font-bold uppercase tracking-widest italic">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 backdrop-blur-md animate-in fade-in duration-300">
        <div class="glass-panel p-0 overflow-hidden w-full max-w-md shadow-3xl animate-in zoom-in-95">
            <div class="bg-zinc-50/50 p-6 border-b border-zinc-200/50 flex items-center justify-between">
                <h3 class="text-xl font-black text-zinc-800 tracking-tight">EDIT USER</h3>
                <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600">
                    <flux:icon name="x-mark" class="size-6" />
                </button>
            </div>
            
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
