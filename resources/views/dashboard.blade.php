<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @if(auth()->user()->isAdmin())
        <div class="space-y-8">
            <livewire:admin.dashboard />
        </div>
    @else
        <div class="space-y-8">
            <livewire:student.event-list />
        </div>
    @endif
    </div>
</x-layouts::app>
