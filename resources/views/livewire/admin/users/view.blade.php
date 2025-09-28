<div>
    <x-modal :title="__(':name', ['name' => $user?->name])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">

        <div class="flex gap-4">
            <div class="flex-shrink-0">
                @if($user?->avatar)
                    <img src="{{ Storage::url($user?->avatar) }}" class="mt-4 w-48 h-48 mb-2" />
                @else
                    <img src="{{ Storage::url('avatars/profile_avatar_placeholder.png') }}" class="mt-4 w-48 h-48 mb-2" />
                @endif
            </div>
            <div class="w-full">
                <dl class="divide-y divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-100">Full name</dt>
                        <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user?->name }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-100">Email address</dt>
                        <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user?->email }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-100">Phone</dt>
                        <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user?->phone }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-100">Date of Birth</dt>
                        <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ date("F j, Y",strtotime($user?->dob)) }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <x-slot:footer>
            <div class="flex justify-between items-center w-full">
                {{-- Cancel Button --}}
                <x-button 
                    variant="ghost" 
                    x-on:click="show = false"
                >
                    {{ __('Cancel') }}
                </x-button>

                <x-button 
                    icon="pencil" 
                    x-on:click="show = false"
                    wire:click="$dispatch('load::user', { 'user' : '{{ $user?->id }}'})" 
                >
                    {{ __('Edit User') }}
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
</div>
