<div>
    <div class="space-y-4">
        <x-card color="primary" bordered>
            <x-slot:header>
                <div class="p-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Profile
                    </h3>
                    <livewire:customer.profile.update-profile @created="$refresh" />
                </div>
            </x-slot:header>
            <div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" class="mt-4 w-48 h-48 mb-2" />
                        @else
                            <img src="{{ Storage::url('avatars/profile-avatar-placeholder.png') }}" class="mt-4 w-48 h-48 mb-2" />
                        @endif
                    </div>
                    <div class="w-full">
                        <dl class="divide-y divide-white/10">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-100">Full name</dt>
                                <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->name }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-100">Email address</dt>
                                <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->email }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-100">Phone</dt>
                                <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->phone }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-100">Date of Birth</dt>
                                <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ date("F j, Y",strtotime($user->dob)) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
    <div class="mt-4 space-y-4">
        <x-card color="primary" bordered>
            <x-slot:header>
                <div class="p-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Addresses
                    </h3>
                    <livewire:customer.profile.create-address @addressCreated="$refresh" />
                </div>
            </x-slot:header>
        
            <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
                @interact('column_type', $row)
                    {{ ucfirst($row->type) }}
                @endinteract
                @interact('column_address', $row)
                    <span>
                        {{ $row->line1 }}<br>
                        @if($row->line2)
                            {{ $row->line2 }}<br>
                        @endif
                        {{ $row->city->name }}, {{ $row->state->name }} {{ $row->postal_code }}<br>
                        {{ $row->country }}
                    </span>
                @endinteract
                @interact('column_is_default', $row)
                    @if($row->is_default)
                        <x-badge color="green">True</x-badge>
                    @endif
                @endinteract
                @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" wire:click="$dispatch('load::address', {addressId: {{ $row->id }} })" />
                    <livewire:customer.profile.delete-address :address="$row" :key="uniqid('', true)" @addressDeleted="$refresh" />
                </div>
                @endinteract
            </x-table>
        </x-card>
    </div>

    <livewire:customer.profile.update-address @addressUpdated="$refresh" />
</div>

            