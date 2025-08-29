<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:product.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_name', $row)
                <img src="{{ Storage::url($row->primary_image) }}" class="rounded size-20 my-2" />
                {{ $row->name }}
            @endinteract
            @interact('column_category', $row)
                {{ $row->category->name }}
            @endinteract
            @interact('column_consoles', $row)
                @foreach($row->consoles as $console)
                    <x-badge class="my-0.5">{{ $console->name }}</x-badge><br>
                @endforeach
            @endinteract
            @interact('column_price', $row)
            ${{ $row->price }}
            @endinteract
            @interact('column_cost', $row)
            ${{ $row->cost }}
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::product', {'product':'{{ $row->id }}'})" />
                <x-button.circle icon="photo" href="{{ route('product.images',['product' => $row]) }}" wire:navigate />
                <livewire:product.delete :product="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:product.update @updated="$refresh" />
</div>
