<div>
    <x-modal :title="__('Adjust Inventory: #:id :product', ['id' => $inventory?->id, 'product' => $product,])" wire>
        <form id="inventory-update-{{ $inventory?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-2 gap-x-2">
                <x-number label="{{ __('Quantity') }} *" wire:model="quantity" />
                <x-number label="{{ __('Minimum Quantity') }}" wire:model="inventory.min_quantity" />
            </div>
            <div class="grid grid-cols-2 gap-x-2">
                <x-select.styled label="{{ __('Transaction Type') }} *" placeholder="Choose transaction type..." wire:model="transactionType" :options="[['label' => 'Purchase', 'value' => 'purchase'],['label' => 'Sale', 'value' => 'sale'],['label' => 'Return', 'value' => 'return'],['label' => 'Adjustment', 'value' => 'adjustment'],['label' => 'Damage', 'value' => 'damage'],]" />
                <x-textarea label="{{ __('Reason') }} *" wire:model="notes" resize-auto />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="inventory-update-{{ $inventory?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
