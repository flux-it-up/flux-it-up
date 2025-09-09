<div @updated="$dispatch('user-profile-updated', { name: $event.detail.name })">

<div class="flex flex-cols">
    <div>
        <livewire:user.create-address @created="$refresh" />
    </div>
    <div class="col-span-2 px-5">
        <h3 class="text-md font-semibold mb-2">Your Addresses</h3>
        <div class="mb-4">
            <div class="py-5 sm:py-5">
                <div class="mx-auto max-w-7xl">
                    <dl class="grid grid-cols-2 gap-x-8 gap-y-5 lg:grid-cols-2">
                        @foreach ($addresses as $address)
                            <div class="border p-2 rounded mb-2 flex flex-col justify-between">
                                <strong>{{ ucfirst($address->type) }} Address</strong>
                                <div class="">
                                    <div>
                                        {{ $address->label }} - 
                                        @if($address->is_default)
                                            <span class="text-green-600 font-bold">Default</span>
                                        @endif<br>
                                        {{ $address->line1 }}<br>
                                        @if($address->line2)
                                            {{ $address->line2 }}<br>
                                        @endif
                                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                                        {{ $address->country }}
                                    </div>
                                </div>
                                <div class="mt-2 items-center">
                                    <x-button sm wire:click="delete({{ $address->id }})" class="bg-red-600 text-white">
                                        Delete
                                    </x-button>
                                </div>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
