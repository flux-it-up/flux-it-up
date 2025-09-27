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
        @auth
            <meta name="user-id" content="{{ auth()->id() }}">
        @endauth
    </head>
    <body class="font-sans antialiased"
          x-cloak
          x-data="{ name: @js(auth()->user()->name) }"
          x-on:name-updated.window="name = $event.detail.name"
          x-bind:class="{ 'dark bg-dark-800': darkTheme, 'bg-gray-100': !darkTheme }">
    <x-layout>
        <x-slot:top>
            <x-dialog />
            <x-toast />
        </x-slot:top>
        <x-slot:header>
            <x-layout.header>
                <x-slot:left>
                    <x-theme-switch />
                </x-slot:left>
                <x-slot:middle>
                    <img src="{{ asset(auth()->user()->avatar_url) }}" class="inline rounded-full size-10 mx-3 " /><span class="text-base font-semibold text-dark-300" x-text="name"></span>
                </x-slot:middle>
                <x-slot:right>
                    <!-- Notification Bell Component -->
                    @auth
                        <livewire:notification-bell />
                    @endauth
                    <x-dropdown>
                        <x-slot:action>
                            @can('manage profile')
                            <div>
                                <button class="text-primary-500 cursor-pointer" x-on:click="show = !show">
                                    <x-icon class="h-6 w-6" name="cog">
                                        <x-slot:right>
                                            Settings
                                        </x-slot:right>
                                    </x-icon>
                                </button>
                            </div>
                            @endcan
                        </x-slot:action>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown.items :text="__('Profile')" :href="route('profile.index')" />
                            <x-dropdown.items :text="__('Logout')" onclick="event.preventDefault(); this.closest('form').submit();" separator />
                        </form>
                    </x-dropdown>
                </x-slot:right>
            </x-layout.header>
        </x-slot:header>
        <x-slot:menu>
            <x-side-bar smart collapsible>
                <x-slot:brand>
                    <div class="mt-8 flex items-center justify-center">
                        <img src="{{ asset('/assets/images/fluxituplogosmall.png') }}" width="40" height="40" />
                    </div>
                </x-slot:brand>
                <x-side-bar.separator text="{{ __('General') }}" line />
                @hasrole('customer')
                    <x-side-bar.item text="{{ __('Home Page') }}" icon="arrow-uturn-left" :route="route('welcome')" />
                    @can('view dashboard')
                        <x-side-bar.item text="{{ __('Dashboard') }}" icon="home" :route="route('dashboard')" />
                    @endcan
                @endhasrole
                @hasrole('technician|support|manager|admin|super-admin')
                    <x-side-bar.separator text="{{ __('Administration') }}" line />
                    @can('view users')
                        <x-side-bar.item text="{{ __('User Management') }}" icon="users" :route="route('users.index')" />
                    @endcan

                        <x-side-bar.item text="{{ __('Tax Rates') }}" icon="scale" :route="route('taxrates.state')" />

                    @can('manage site')
                        <x-side-bar.item text="{{ __('Consoles') }}" icon="server" :route="route('consoles.index')" />
                        <x-side-bar.item text="{{ __('Services') }}" icon="clipboard" :route="route('services.index')" />
                    @endcan
                    {{-- @can('view dashboard')
                        <x-side-bar.item text="{{ __('Pricing Tiers') }}" icon="tag" :route="route('pricing-tiers.index')" /> 
                    @endcan--}}
                    @can('manage inventory')
                        <x-side-bar.item text="{{ __('Inventory Management') }}" icon="table-cells" >
                            @can('view products')
                                <x-side-bar.item text="{{ __('Products') }}" :route="route('products.index')" />
                            @endcan
                            @can('view products')
                                <x-side-bar.item text="{{ __('Adjustments') }}" :route="route('adjustments.index')" />
                            @endcan
                        </x-side-bar.item>
                    @endcan
                    @can('view orders')
                        <x-side-bar.item text="{{ __('Order Management') }}" icon="clipboard-document-list" >
                            <x-side-bar.item text="{{ __('Product Orders') }}" :route="route('orders.index')" />
                            <x-side-bar.item text="{{ __('Repair Orders') }}" :route="route('repairs.index')" />
                        </x-side-bar.item>
                    @endcan
                @endhasrole
            </x-side-bar>
        </x-slot:menu>
        {{ $slot }}
    </x-layout>
    @livewireScripts(['url' => '/livewire/update'])
    </body>
</html>
