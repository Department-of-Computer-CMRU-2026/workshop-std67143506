<?php

namespace App\Livewire\Admin;

use App\Models\Registration;
use Livewire\Component;

class RegistrationList extends Component
{
    public string $search = '';

    public function render()
    {
        $registrations = Registration::query()
            ->with(['user', 'event'])
            ->when($this->search, function ($q) {
            $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"))
                ->orWhereHas('event', fn($e) => $e->where('title', 'like', "%{$this->search}%"));
        })
            ->latest()
            ->get();

        return view('livewire.admin.registration-list', compact('registrations'));
    }
}
