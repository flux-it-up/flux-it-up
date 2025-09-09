<div>
    <x-modal :title="__('Assing User Roles: #:id', ['id' => $user?->id])" wire>
        <form id="user-assign-{{ $user?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled label="{{ __('Role') }} *" placeholder="Choose role..." wire:model="selectedRoles" multiple search :options="$roles" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="user-assign-{{ $user?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>