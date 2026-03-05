<x-layouts::app :title="__('Manage Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="space-y-8">
            <livewire:admin.user-list />
        </div>
    </div>
</x-layouts::app>
