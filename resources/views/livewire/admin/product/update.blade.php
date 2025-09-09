<div>
    <x-modal :title="__('Update Product: #:id :name', ['id' => $product?->id, 'name' => $product?->name])" wire>
        <form id="product-update-{{ $product?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" x-ref="name" wire:model="product.name" required />
            </div>
            <div>
                <x-input label="{{ __('Product Code') }} *" placeholder="e.g. SCR, HDR, BTR..." wire:model="product.code" required />
            </div>
            <div>
                <x-textarea label="{{ __('Description') }} *" wire:model="product.description" resize-auto />
            </div>
            <div>
                <x-select.styled label="{{ __('Category') }} *" placeholder="Choose category..." wire:model="product.category_id" search :options="$productCategories" select="label:name|value:id" />
            </div>
            <div>
                <x-select.styled label="{{ __('Consoles') }} *" placeholder="Choose consoles..." wire:model="selectedConsoles" search multiple :options="$consoles" select="label:name|value:id" />
            </div>
            <div>
                <x-number label="{{ __('Price') }} *" prefix="$" wire:model="product.price" step="0.01" required/>
            </div>
            <div>
                <x-number label="{{ __('Cost') }} *" prefix="$" wire:model="product.cost" step="0.01" required />
            </div>
            <div>
                <x-number label="{{ __('Quantity') }} *" wire:model="product.quantity" step="1" required />
            </div>
            <div>
                <x-number label="{{ __('Minimum Quantity') }} *" wire:model="product.min_quantity" step="1" required />
            </div>
            <div>
                <x-number label="{{ __('Weight') }}" wire:model="product.weight" step="0.01" />
            </div>
            <div>
                <x-input label="{{ __('Dimensions') }}" placeholder="e.g. 1in x 1in" wire:model="product.dimensions" />
            </div>
            <div>
                <x-input label="{{ __('Warranty') }} *" wire:model="product.warranty" required />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="product-update-{{ $product?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
