<div>
    <x-button :text="__('Create New User')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Create New User')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="user-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('First Name') }} *" x-ref="name" wire:model="user.first_name" required />
            </div>
            <div>
                <x-input label="{{ __('Middle Name') }}" wire:model="user.middle_name" />
            </div>
            <div>
                <x-input label="{{ __('Last Name') }} *" wire:model="user.last_name" />
            </div>
            <div>
                <x-input label="{{ __('Email') }} *" wire:model="user.email" required />
            </div>
            <div>
                <x-date label="{{ __('Date of Birth') }} *" wire:model="user.dob" required />
            </div>
            <div>
                <x-input label="{{ __('Phone') }} *" wire:model="user.phone" />
            </div>
            <div>
                <x-password label="{{ __('Password') }} *"
                            wire:model="password"
                            rules
                            generator
                            x-on:generate="$wire.set('password_confirmation', $event.detail.password)"
                            required />
            </div>

            <div>
                <x-password :label="__('Password')" wire:model="password_confirmation" rules required />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="user-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
