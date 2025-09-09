<div>
    <x-button :text="__('Update Profile')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Update Profile')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="update-profile" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('First Name') }} *" wire:model="user.first_name" required />
            </div>
            <div>
                <x-input label="{{ __('Middle Name') }}" wire:model="user.middle_name" />
            </div>
            <div>
                <x-input label="{{ __('Last Name') }} *" wire:model="user.last_name" required />
            </div>
            <div>
                <x-input label="{{ __('Email') }} *" value="{{ $user->email }}" disabled />
            </div>
            <div>
                <x-date label="{{ __('Date of Birth') }} *" wire:model="user.dob" required />
            </div>
            <div>
                <x-input label="{{ __('Phone') }} *" wire:model="user.phone" />
            </div>
            <div>
                <x-password :label="__('Current password')" wire:model="current_password" />
            </div>
            <div>
                <x-password :label="__('New Password')"
                            :hint="__('The password will only be updated if you set the value of this field')"
                            wire:model="password"
                            rules
                            generator
                            x-on:generate="$wire.set('password_confirmation', $event.detail.password)" />
            </div>
            <div>
                <x-password :label="__('Confirm password')" wire:model="password_confirmation" rules />
            </div>
            <div>
                {{-- Avatar Upload --}}
                <div class="my-4">
                    <x-upload wire:model="newAvatar" label="Upload New Avatar" />
                    @error('newAvatar') <p class="text-red-500">{{ $message }}</p> @enderror
                    @if($avatar)
                        <img src="{{ Storage::url($avatar) }}" class="mt-4 w-24 h-24 rounded-full mb-2" />
                    @endif
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="update-profile">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>





