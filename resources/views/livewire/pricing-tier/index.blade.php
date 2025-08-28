<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:pricing-tier.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_price', $row)
            ${{ $row->price }}
            @endinteract
            @interact('column_services', $row)
                @foreach($row->services as $service)
                    <x-badge class="my-0.5">{{ $service->name }}</x-badge><br>
                @endforeach
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::pricing-tier', { 'pricing_tier' : '{{ $row->id }}'})" />
                {{-- <livewire:pricing-tier.delete :service="$row" :key="uniqid('', true)" @deleted="$refresh" /> --}}
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:pricing-tier.update @updated="$refresh" />
</div>
