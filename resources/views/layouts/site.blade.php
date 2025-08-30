<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=asap:100,300,500&display=swap" rel="stylesheet" />

        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased"
          x-cloak
          x-on:name-updated.window="name = $event.detail.name"
          x-bind:class="{ 'dark bg-dark-800': darkTheme, 'bg-gray-100': !darkTheme }">
    
        <header class="absolute inset-x-0 top-0 z-50">
            <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
                <div class="flex lg:flex-1">
                    <a href="{{ route('welcome') }}" class="-m-1.5 p-1.5">
                    <span class="sr-only">Flux It UP</span>
                    <img src="{{ asset('/assets/images/fluxituplogosmall.png') }}" alt="" class="h-15 w-auto" />
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-200">
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="{{ route('welcome') }}" class="text-sm/6 font-semibold text-white">Home</a>
                    <a href="#" class="text-sm/6 font-semibold text-white">Features</a>
                    <a href="#" class="text-sm/6 font-semibold text-white">Marketplace</a>
                    <a href="#" class="text-sm/6 font-semibold text-white">Company</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-white">Log in <span aria-hidden="true">&rarr;</span></a>
                </div>
            </nav>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    </div>
                    <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-white/10">
                        <div class="space-y-2 py-6">
                        <a href="{{ route('welcome') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Home</a>
                        <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Features</a>
                        <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Marketplace</a>
                        <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Company</a>
                        </div>
                        <div class="py-6">
                        <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                        </div>
                    </div>
                    </div>
                </el-dialog-panel>
                </div>
            </dialog>
            </el-dialog>
        </header>

        {{ $slot }}

        <footer class="mt-10 bg-[#0f0f0f] px-8 pt-12">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center gap-8 md:justify-between">
                <div class="text-center md:text-left">
                    <a href="/" wire:navigate
                        class="block antialiased tracking-normal font-sans text-xl font-semibold leading-snug text-white mb-4">Flux It Up</a>
                    <p class="block antialiased font-sans text-base leading-relaxed text-white mb-12 font-normal">We flux wit it.</p>
                    <ul class="flex flex-wrap items-center justify-center md:justify-start">
                        <li>
                            <a href="/" wire:navigate
                                class="block antialiased font-sans text-base leading-relaxed text-white py-1 font-medium transition-colors pr-3">Home</a>
                        </li>
                        <li>
                            <a href="/about" wire:navigate
                                class="block antialiased font-sans text-base leading-relaxed text-white py-1 font-medium transition-colors px-3">About</a>
                        </li>
                        <li>
                            <a href="/services" wire:navigate
                                class="block antialiased font-sans text-base leading-relaxed text-white py-1 font-medium transition-colors px-3">Services</a>
                        </li>
                    </ul>
                </div>
                <div class="mt-8 w-full md:mt-0 md:w-auto">
                    <img class="h-50" src="{{ asset('/assets/images/fluxituplogowslogan.png') }}" />
                </div>
            </div>
            <div
                class="mt-16 flex flex-wrap items-center justify-center gap-y-4 gap-x-8 border-t border-gray-700 py-7 md:justify-between">
                <p
                    class="block antialiased font-sans text-base leading-relaxed text-white text-center font-normal opacity-75">
                    © <!-- -->2025<!-- --> Flux It Up. All rights reserved.
                </p>
                <div class="flex gap-2">
                    
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    </body>
</html>
