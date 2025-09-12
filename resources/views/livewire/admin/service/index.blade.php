<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:admin.service.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" striped paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_description', $row)
                <div class="text-wrap w-60">
                    {{ $row->description }}
                </div>
            @endinteract
            @interact('column_category', $row)
                {{ $row->category->name }}
            @endinteract
            @interact('column_base_price', $row)
                ${{ $row->base_price }}
            @endinteract
            @interact('column_consoles', $row)
                <div class="text-wrap w-80">
                    @foreach($row->consoles as $console)
                        {{ $console->name }},&nbsp;
                    @endforeach
                </div>
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" wire:click="$dispatch('load::service', { 'service' : '{{ $row->id }}'})" />
                    <livewire:admin.service.delete :service="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.service.update @updated="$refresh" />
</div>
