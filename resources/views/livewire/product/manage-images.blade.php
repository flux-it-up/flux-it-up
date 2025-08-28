<div>
    <x-card>
        <div class="mb-4">
            <h3 class="text-lg text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">Images for #{{ $product->id }} - {{ $product->name }}</h3>
        </div>
        <div class="mb-4 mt-4">
            <x-button :text="__('Upload Image')" wire:click="$dispatch('modal', { id: {{ $product->id }}})" sm />
        </div>
        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_image_url', $row)
                <img src="{{ Storage::url($row->image_url) }}" class="mt-4 w-24 h-24 rounded-full mb-2" />
            @endinteract
            @interact('column_is_primary', $row)
                @if($row->is_primary)
                    <x-badge color="green" text="True" />
                @endif
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <livewire:product.delete-image :image="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>
    
    <livewire:product.create-image @created="$refresh" />
    
</div>
