<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:admin.product.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_name', $row)
                <img src="{{ Storage::url($row->primary_image) }}" class="rounded size-20 my-2" />
                <span class="text-primary-600 font-bold">{{ $row->name }}</span>
            @endinteract
            @interact('column_category', $row)
                {{ $row->category->name }}
            @endinteract
            @interact('column_consoles', $row)
                <div class="text-wrap w-30">
                    @foreach($row->consoles as $console)
                        {{ $console->name }},&nbsp;
                    @endforeach
                </div>
            @endinteract
            @interact('column_cost', $row)
            ${{ $row->cost }}
            @endinteract
            @interact('column_price', $row)
                @if($row->price == 0.00)
                    FREE
                @else
                    ${{ $row->price }}
                @endif
            @endinteract
            @interact('column_on_sale', $row)
                @if($row->on_sale)
                    Yes
                @else
                    No
                @endif
            @endinteract
            @interact('column_sale_price', $row)
                @if($row->sale_price)
                    @if($row->sale_price == 0.00)
                        FREE
                    @else
                        ${{ $row->sale_price }}
                    @endif
                @endif
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::product', { 'id' : '{{ $row->id }}'})" />
                <x-button.circle icon="photo" href="{{ route('product.images',['product' => $row]) }}" wire:navigate />
                <livewire:admin.product.delete :product="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.product.update @updated="$refresh" />
</div>
