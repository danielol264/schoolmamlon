<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>  

    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                @if (auth()->user()->ROL==='M')
                    <flux:navlist.group :heading="__('Moviementos')" class="grid">
                        <flux:navlist.item icon="home" :href="route('maestro.dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Menu') }}</flux:navlist.item>
                        <flux:navlist.item icon="clipboard-document-list" :href="route('examenes.index')" :current="request()->routeIs('examenes.*')" wire:navigate>{{ __('Examenes') }}</flux:navlist.item>
                        <flux:navlist.item icon="check-badge" :href="route('calificaciones.index')" :current="request()->routeIs('calificaciones.*')" wire:navigate>{{ __('Calificaciones') }}</flux:navlist.item>
                    </flux:navlist.group>
                   
                @elseif (auth()->user()->ROL==='A')
                    <flux:navlist.group :heading="__('Operaciones')" class="grid">
                    <flux:navlist.item icon="home" :href="route('alumno.dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Informacion personal') }}</flux:navlist.item>
                    <flux:navlist.item icon="clipboard-document-list" :href="route('alumno.examen')" :current="request()->routeIs('examenes.*')" wire:navigate>{{ __('Examenes') }}</flux:navlist.item>
                    <flux:navlist.item icon="check-badge" :href="route('alumno.calificaciones')" :current="request()->routeIs('calificaciones.*')" wire:navigate>{{ __('Calificaciones') }}</flux:navlist.item>
                    </flux:navlist.group>
                @else
                    <flux:navlist.group :heading="('Operaciones')" class="grid">
                    <flux:navlist.item icon="home" :href="route('administracion.dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Menu') }}</flux:navlist.item>
                    <flux:navlist.item icon="home" :href="route('administracion.alumnos.index')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Alumnos') }}</flux:navlist.item>
                    <flux:navlist.item icon="home" :href="route('administracion.maestros.index')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Maestros') }}</flux:navlist.item>
                    <flux:navlist.item icon="home" :href="route('administracion.grupos.index')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Grupos') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />


            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
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
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</html>
