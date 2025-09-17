<div>
    <x-card>
        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_product', $row)
                {{ $row->product->name }}
            @endinteract
            @interact('column_location', $row)
                {{ ucfirst($row->site_location) }}
            @endinteract
            @interact('column_last_restock', $row)
                {{ $row->last_restock_date->toDayDateTimeString() }}
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="arrows-up-down" wire:click="$dispatch('load::inventory', {'id':'{{ $row->id }}','product':'{{ $row->product->name }}'})" /> <!--x-tooltip.raw="Adjust inventory"-->
                    <x-button.circle icon="eye" wire:click="$dispatch('load::transactions', {'id':'{{ $row->product->id }}','product':'{{ $row->product->name }}'})" />
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.inventory.update @updated="$refresh" />
    <livewire:admin.inventory.transaction />
</div>