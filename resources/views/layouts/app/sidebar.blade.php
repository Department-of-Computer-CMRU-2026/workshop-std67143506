<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-soft-pink-gradient text-zinc-900 transition-colors duration-300">
        <!-- Glowing Blobs -->
        <div class="soft-blob soft-blob-1"></div>
        <div class="soft-blob soft-blob-2"></div>
        <flux:sidebar sticky collapsible="mobile" class="border-e border-white/60 glass-panel shadow-xl">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    
                    @if(auth()->user()->isAdmin())
                    <flux:sidebar.item icon="calendar" :href="route('admin.events')" :current="request()->routeIs('admin.events')" wire:navigate>
                        {{ __('Manage Events') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('admin.users')" :current="request()->routeIs('admin.users')" wire:navigate>
                        {{ __('Manage Users') }}
                    </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        <script>
            // Helper to get data from Livewire detail (can be array or object)
            const getDetailData = (detail) => {
                if (Array.isArray(detail)) return detail[0];
                return detail;
            };

            window.addEventListener('swal:success', event => {
                const data = getDetailData(event.detail);
                if (!data) return;

                Swal.fire({
                    title: data.title || 'Success!',
                    text: data.text || '',
                    icon: data.icon || 'success',
                    timer: data.timer || 2000,
                    showConfirmButton: false,
                    position: 'center'
                });
            });

            window.addEventListener('swal:confirm', event => {
                const data = getDetailData(event.detail);
                if (!data) return;

                Swal.fire({
                    title: data.title || 'Are you sure?',
                    text: data.text || '',
                    icon: data.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb', // blue-600
                    cancelButtonColor: '#d33',
                    confirmButtonText: data.confirmButtonText || 'Yes, proceed!',
                    cancelButtonText: data.cancelButtonText || 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        try {
                            if (window.Livewire) {
                                window.Livewire.dispatch(data.action, { id: data.id });
                            } else {
                                console.error('Livewire not found');
                            }
                        } catch (e) {
                            console.error('Error dispatching to Livewire:', e);
                        }
                    }
                });
            });
        </script>
    </body>
</html>
