<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public $showModal = false;
    public $userId = null;
    public $name = '';
    public $email = '';
    public $role = '';

    protected $listeners = ['deleteUserConfirmed' => 'delete'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|in:admin,student',
    ];

    public function with()
    {
        return [
            'users' => User::orderBy('created_at', 'desc')->get()
        ];
    }

    public function edit($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role ?? 'student';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->showModal = false;
        
        $this->dispatch('swal:success', [
            'title' => 'Updated!',
            'text' => 'User information has been updated.',
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            $this->dispatch('swal:success', [
                'title' => 'Error',
                'text' => 'You cannot delete yourself.',
                'icon' => 'error'
            ]);
            return;
        }

        $user->delete();

        $this->dispatch('swal:success', [
            'title' => 'Deleted!',
            'text' => 'User has been removed successfully.',
        ]);
    }
};
?>

<div>
    <h2 class="text-xl font-semibold mb-6 dark:text-gray-100">User List</h2>

    <div class="overflow-x-auto bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 font-medium">ID</th>
                    <th class="px-6 py-3 font-medium">Name</th>
                    <th class="px-6 py-3 font-medium">Email</th>
                    <th class="px-6 py-3 font-medium">Role</th>
                    <th class="px-6 py-3 font-medium">Registered Date</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @foreach($users as $user)
                <tr class="dark:text-gray-200">
                    <td class="px-6 py-4">{{ $user->id }}</td>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' }}">
                            {{ ucfirst($user->role ?? 'student') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $user->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>
                        <button wire:click="$dispatch('swal:confirm', [{ title: 'Delete User?', text: 'Are you sure you want to delete this user?', action: 'deleteUserConfirmed', id: {{ $user->id }} }])" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                    </td>
                </tr>
                @endforeach
                @if(count($users) === 0)
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No users found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 w-full max-w-md shadow-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium mb-4 dark:text-white">Edit User</h3>
            
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Name</label>
                    <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Role</label>
                    <select wire:model="role" class="w-full rounded-md border-gray-300 dark:border-neutral-700 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-black focus:ring-black dark:focus:ring-white">
                        <option value="student">Student</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-neutral-100 dark:border-neutral-800 mt-6">
                    <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-zinc-800 transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-sm font-medium shadow-sm transition-colors">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>