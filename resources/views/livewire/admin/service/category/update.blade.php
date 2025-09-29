<div>
    <x-modal :title="__('Update Service Category: #:id', ['id'=>$category?->id])" wire>
        <form id="category-update-{{ $category?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" wire:model="category.name" />
            </div>
            <div>
                <x-input label="{{ __('Description') }} *" wire:model="category.description" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="category-update-{{ $category?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
