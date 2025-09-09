<div>
    <x-modal :title="__('Update Order: #:id', ['id' => $order?->id])" wire>
        <form id="order-update-{{ $order?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled label="{{ __('User') }} *" placeholder="Choose user..." wire:model="order.user_id" searchable :options="$users" select="label:name|value:id" />
            </div>
            <div>
                <x-select.styled label="{{ __('Order Type') }} *" placeholder="Choose order type..." wire:model="order.order_type" :options="[['label' => 'Repair', 'value' => 'repair'],['label' => 'Product', 'value' => 'product'],['label' => 'Mixed', 'value' => 'mixed'],]" />
            </div>
            <div>
                <x-select.styled label="{{ __('Order Status') }} *" placeholder="Choose order status..." wire:model="order.order_status" :options="[['label' => 'Pending', 'value' => 'pending'],['label' => 'Confirmed', 'value' => 'confirmed'],['label' => 'Processing', 'value' => 'processing'],['label' => 'Shipped', 'value' => 'shipped'],['label' => 'Delivered', 'value' => 'delivered'],['label' => 'Cancelled', 'value' => 'cancelled'],['label' => 'Refunded', 'value' => 'refunded'],]" />
            </div>
            <div>
                <x-select.styled label="{{ __('Payment Status') }} *" placeholder="Choose payment status..." wire:model="order.payment_status" :options="[['label' => 'Pending', 'value' => 'pending'],['label' => 'Paid', 'value' => 'paid'],['label' => 'Failed', 'value' => 'failed'],['label' => 'Refunded', 'value' => 'refunded'],['label' => 'Partial', 'value' => 'partial'],]" />
            </div>
            
            <div class="space-y-3">
                <label class="dark:text-dark-400 mb-1 block text-sm font-semibold text-gray-600">
                    Products
                    <span class="font-bold text-red-500 not-italic">*</span>
                </label>
                @foreach ($products as $index => $product)
                    <div class="flex space-x-2 items-center">
                        <select wire:model="products.{{ $index }}.id" class="dark:text-dark-300 dark:bg-dark-800 dark:focus:ring-primary-600 dark:disabled:bg-dark-600 dark:ring-dark-600 flex w-full cursor-pointer items-center gap-x-2 rounded-md border-0 bg-white py-1.5 text-sm ring-1 ring-gray-300 disabled:bg-gray-100 disabled:text-gray-500 disabled:ring-gray-300 focus:ring-primary-600 text-gray-600 focus:outline-hidden focus:ring-2">
                            <option value="">-- Select Product --</option>
                            @foreach ($allProducts as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (${{ $p->price }})</option>
                            @endforeach
                        </select>

                        <input type="number" min="1" wire:model="products.{{ $index }}.quantity" class="dark:text-dark-300 dark:bg-dark-800 dark:focus:ring-primary-600 dark:disabled:bg-dark-600 dark:ring-dark-600 flex w-full cursor-pointer items-center gap-x-2 rounded-md border-0 bg-white py-1.5 text-sm ring-1 ring-gray-300 disabled:bg-gray-100 disabled:text-gray-500 disabled:ring-gray-300 focus:ring-primary-600 text-gray-600 focus:outline-hidden focus:ring-2">

                        <button type="button" wire:click="removeProductRow({{ $index }})" class="bg-red-500 text-white px-2 py-1 rounded">x</button>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="button" wire:click="addProductRow" class="bg-blue-500 text-white px-3 py-1 rounded">
                    + Add Product
                </button>
            </div>
            
            <div>
                <x-input label="{{ __('Currency') }} *" x-ref="name" wire:model="order.currency" required />
            </div>
            <div>
                <x-textarea label="{{ __('Notes') }} *" wire:model="order.notes" resize-auto />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="order-update-{{ $order?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
