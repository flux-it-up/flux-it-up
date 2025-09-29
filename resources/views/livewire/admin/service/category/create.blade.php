<div>
    <x-button :text="__('Service Category')" icon="plus" wire:click="$toggle('modal')" md />

    <x-modal :title="__('Add New Service Category')" wire x-on:open="setTimeout(() => $refs.name.focus(), 450)">
        <form id="category-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" wire:model="category.name" />
            </div>
            <div>
                <x-input label="{{ __('Description') }} *" wire:model="category.description" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="category-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
