<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class UserList extends Component
{
    public string $search = "";
    public bool $showModal = false;
    public ?int $userId = null;
    public string $name = "";
    public string $email = "";
    public string $role = "";

    protected function rules()
    {
        return [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $this->userId,
            "role" => "required|in:admin,student",
        ];
    }

    public function edit($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role ?? "student";
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->update([
            "name" => $this->name,
            "email" => $this->email,
            "role" => $this->role,
        ]);

        $this->showModal = false;
        
        $this->dispatch("swal:success", [
            "title" => "Updated!",
            "text" => "User information has been updated.",
        ]);
    }

    #[On("deleteUser")]
    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            $this->dispatch("swal:success", [
                "title" => "Error",
                "text" => "You cannot delete yourself.",
                "icon" => "error"
            ]);
            return;
        }

        $user->delete();

        $this->dispatch("swal:success", [
            "title" => "Deleted!",
            "text" => "User has been removed successfully.",
        ]);
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where("name", "like", "%{$this->search}%")
                ->orWhere("email", "like", "%{$this->search}%"))
            ->withCount("registrations")
            ->latest()
            ->get();

        return view("livewire.admin.user-list", compact("users"));
    }
}
