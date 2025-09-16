<div>
    <x-button :text="__('Create New Order')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Create New Order')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="order-create" wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-2 gap-x-2">
                <div>
                    <x-select.styled label="{{ __('User') }} *" placeholder="Choose user..." wire:model="order.user_id" search searchable :options="$users" select="label:name|value:id" />
                </div>
                <div>
                    <x-select.styled label="{{ __('Order Type') }} *" placeholder="Choose order type..." wire:model="order.order_type" :options="[['label' => 'Repair', 'value' => 'repair'],['label' => 'Product', 'value' => 'product'],['label' => 'Mixed', 'value' => 'mixed'],]" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-x-2">
                <div>
                    <x-select.styled label="{{ __('Order Status') }} *" placeholder="Choose order status..." wire:model="order.order_status" :options="[['label' => 'Pending', 'value' => 'pending'],['label' => 'Confirmed', 'value' => 'confirmed'],['label' => 'Processing', 'value' => 'processing'],['label' => 'Shipped', 'value' => 'shipped'],['label' => 'Delivered', 'value' => 'delivered'],['label' => 'Cancelled', 'value' => 'cancelled'],['label' => 'Refunded', 'value' => 'refunded'],]" />
                </div>
                <div>
                    <x-select.styled label="{{ __('Payment Status') }} *" placeholder="Choose payment status..." wire:model="order.payment_status" :options="[['label' => 'Pending', 'value' => 'pending'],['label' => 'Paid', 'value' => 'paid'],['label' => 'Failed', 'value' => 'failed'],['label' => 'Refunded', 'value' => 'refunded'],['label' => 'Partial', 'value' => 'partial'],]" />
                </div>
            </div>
            <div class="space-y-3">
                <h3 class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">Choose a Product(s)</h3>
                <x-separator line />
                @foreach ($products as $index => $product)
                    <div class="grid grid-cols-5 gap-x-2 items-end" wire:key="product-{{ $index }}">
                        <div class="col-span-3">
                            <x-select.styled 
                                label="{{ __('Product') }}"
                                wire:model="products.{{ $index }}.id"
                                placeholder="-- Select Product --"
                                :options="$allProducts"
                                select="label:name|value:id"
                                option-label="name"
                                option-value="id"
                                search searchable
                            />
                        </div>
                        <div class="col-span-1">
                            <x-number min="1" wire:model="products.{{ $index }}.quantity" label="{{ __('Quantity') }}" />
                        </div>
                        <div class="col-span-1">
                            <x-button icon="x-mark" wire:click="removeProductRow({{ $index }})" />
                        </div>
                    </div>
                    <x-separator line />
                @endforeach
            </div>

            <div class="mt-3">
                <x-button icon="plus" position="left" wire:click="addProductRow">Add Product</x-button>
            </div>
            
            <div class="grid grid-cols-2 gap-x-2">
                <div>
                    <x-input label="{{ __('Currency') }} *" wire:model="order.currency" required />
                </div>
                <div>
                    <x-input label="{{ __('Discount Code') }}" wire:model="order.discount_code" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-x-2">
                <div>
                    <x-textarea label="{{ __('Notes') }}" wire:model="order.notes" resize-auto />
                </div>
                <div>
                    <x-textarea label="{{ __('Admin Notes') }}" wire:model="order.admin_notes" resize-auto />
                </div>
            </div>
            <div class="grid grid-cols-5 gap-x-2">
                <div>
                    <x-checkbox label="{{ __('Is Gift?') }}" wire:model="order.is_gift" />
                </div>
                <div class="col-span-4">
                    <x-textarea label="{{ __('Gift Message') }}" wire:model="order.gift_message" resize-auto />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="order-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
