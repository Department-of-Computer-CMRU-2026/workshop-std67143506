<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @if(auth()->user()->isAdmin())
        <div class="space-y-8">
            <livewire:admin.dashboard />
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <livewire:admin.workshop-manager />
                <livewire:admin.registration-list />
            </div>
        </div>
    @else
        <div class="space-y-8">
            <livewire:student.workshop-list />
        </div>
    @endif
    </div>
</x-layouts::app>
