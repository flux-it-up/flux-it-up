<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=asap:100,300,500&display=swap" rel="stylesheet" />

    {{-- Vite CSS/JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- TallStackUI Scripts --}}
    <tallstackui:script />
</head>
<body class="font-sans antialiased"
      x-cloak
      x-on:name-updated.window="name = $event.detail.name"
      x-bind:class="{ 'dark bg-dark-800': darkTheme, 'bg-gray-100': !darkTheme }">

    {{-- Header / Navigation --}}
    <header class="absolute inset-x-0 top-0 z-50 bg-dark-950">
        <nav class="flex items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="{{ route('welcome') }}" class="-m-1.5 p-1.5">
                    <span class="sr-only">Flux It Up</span>
                    <img src="{{ asset('/assets/images/fluxituplogosmall.png') }}" alt="" class="h-15 w-auto" />
                </a>
            </div>

            {{-- Desktop Links --}}
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="{{ route('welcome') }}" class="text-sm font-semibold text-white">Home</a>
                <a href="{{ route('about') }}" class="text-sm font-semibold text-white">About</a>
                <a href="{{ route('services') }}" class="text-sm font-semibold text-white">Services</a>
            </div>

            {{-- User Links --}}
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                @hasrole('admin|super-admin')
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-white">Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-white">Log in →</a>
                @endhasrole
            </div>

            {{-- Mobile menu button --}}
            <div class="flex lg:hidden">
                <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-200">
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Mobile menu --}}
        <el-dialog>
            <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
                <div tabindex="0" class="fixed inset-0 focus:outline-none">
                    <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('welcome') }}" class="-m-1.5 p-1.5">
                                <span class="sr-only">Flux It Up</span>
                                <img src="{{ asset('/assets/images/fluxituplogosmall.png') }}" alt="" class="h-8 w-auto" />
                            </a>
                            <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-200">
                                <span class="sr-only">Close menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-6 flow-root">
                            <div class="-my-6 divide-y divide-white/10">
                                <div class="space-y-2 py-6">
                                    <a href="{{ route('welcome') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Home</a>
                                    <a href="{{ route('about') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">About</a>
                                    <a href="{{ route('services') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Services</a>
                                </div>
                                <div class="py-6">
                                    @hasrole('admin|super-admin')
                                        <a href="{{ route('dashboard') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold text-white hover:bg-white/5">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold text-white hover:bg-white/5">Log in</a>
                                    @endhasrole
                                </div>
                            </div>
                        </div>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
    </header>

    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-10 bg-dark-950 px-8 pt-12">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center gap-8 md:justify-between">
                <div class="text-center md:text-left">
                    <a href="/" wire:navigate class="block text-xl font-semibold text-white mb-4">Flux It Up</a>
                    <p class="text-base text-white mb-12 font-normal">We flux wit it.</p>
                    <ul class="flex flex-wrap items-center justify-center md:justify-start gap-x-3">
                        <li><a href="{{ route('welcome') }}" wire:navigate class="text-base text-white font-medium py-1">Home</a></li>
                        <li><a href="{{ route('about') }}" wire:navigate class="text-base text-white font-medium py-1">About</a></li>
                        <li><a href="{{ route('services') }}" wire:navigate class="text-base text-white font-medium py-1">Services</a></li>
                    </ul>
                </div>
                <div class="mt-8 w-full md:mt-0 md:w-auto">
                    <img class="h-50" src="{{ asset('/assets/images/fluxituplogowslogan.png') }}" />
                </div>
            </div>
            <div class="mt-16 flex flex-wrap items-center justify-center gap-y-4 gap-x-8 border-t border-gray-700 py-7 md:justify-between">
                <p class="text-base text-white text-center font-normal opacity-75">© 2025 Flux It Up. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Livewire Scripts --}}
    @livewireScripts
</body>
</html>
