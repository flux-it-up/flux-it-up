<div>
    <x-modal :title="__('Update Product: #:id', ['id' => $product?->id])" wire>
        <form id="product-update-{{ $product?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" x-ref="name" wire:model="product.name" required />
            </div>
            <div>
                <x-textarea label="{{ __('Description') }} *" wire:model="product.description" resize-auto />
            </div>
            <div class="grid grid-cols-2 gap-x-2" wire:ignore>
                <x-select.styled label="{{ __('Category') }} *" placeholder="Choose category..." wire:model="product.category_id" search :options="$productCategories" select="label:name|value:id" />
                <x-select.styled label="{{ __('Consoles') }} *" placeholder="Choose consoles..." wire:model="selectedConsoles" search multiple :options="$consoles" select="label:name|value:id" />
            </div>
            <div class="grid grid-cols-3 gap-x-2">
                <x-number label="{{ __('Cost') }} *" prefix="$" wire:model="product.cost" step="0.01" required />
                <x-number label="{{ __('Markup Percent') }}" wire:model="product.cost_markup" step="0.01" />
                <x-number label="{{ __('Price Override') }}" prefix="$" wire:model="product.price_override" step="0.01" />
            </div>
            <div class="grid grid-cols-5 gap-x-2">
                <div class="col-span-1">
                    <x-checkbox label="{{ __('On Sale?') }}" wire:model="product.on_sale" />
                </div>
                <div class="col-span-2">
                    <x-number label="{{ __('Sale Percent') }}" wire:model="product.sale_percent" step="0.01" />
                </div>
                <div class="col-span-2">
                    <x-number label="{{ __('Sale Price Override') }}" prefix="$" wire:model="product.sale_price_override" step="0.01" />
                </div>
            </div>
            <div class="grid grid-cols-3 gap-x-2">
                <x-input label="{{ __('Warranty') }} *" wire:model="product.warranty" required />
                <x-number label="{{ __('Weight') }}" wire:model="product.weight" step="0.01" />
                <x-input label="{{ __('Weight Unit') }}" wire:model="product.weight_unit" />
            </div>
            <div class="grid grid-cols-4 gap-x-2">
                <x-number label="{{ __('Length') }}" wire:model="product.length" step="1" />
                <x-number label="{{ __('Width') }}" wire:model="product.width" step="1" />
                <x-number label="{{ __('Height') }}" wire:model="product.height" step="1" />
                <x-input label="{{ __('Dimension Unit') }}" wire:model="product.dimension_unit" />
            </div>
            <div class="space-y-3">
                <h3 class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">Specifications</h3>
                @foreach ($specifications as $skey=>$spec)
                    <div class="grid grid-cols-5 gap-x-2" wire:key="spec-{{ $skey }}">
                        <div class="col-span-2">
                            <x-input wire:model="specifications.{{ $skey }}.name" label="Name" />
                        </div>
                        <div class="col-span-2">
                            <x-input wire:model="specifications.{{ $skey }}.svalue" label="Value" />
                        </div>
                        <div class="col-span-1">
                            <x-button icon="x-mark" wire:click="removeSpecificationsRow({{ $skey }})" class="mt-6" />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <x-button icon="plus" position="left" wire:click="addSpecificationsRow">Add Specification</x-button>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="product-update-{{ $product?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
