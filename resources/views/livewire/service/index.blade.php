<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:service.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_base_price', $row)
            ${{ $row->base_price }}
            @endinteract
            @interact('column_consoles', $row)
                @foreach($row->consoles as $console)
                    <x-badge class="my-0.5">{{ $console->name }}</x-badge><br>
                @endforeach
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::service', { 'service' : '{{ $row->id }}'})" />
                <livewire:service.delete :service="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:service.update @updated="$refresh" />
</div>
