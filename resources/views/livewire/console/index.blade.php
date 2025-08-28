<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:console.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::console', { 'console' : '{{ $row->id }}'})" />
                <livewire:console.delete :console="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>
    <livewire:console.update @updated="$refresh" />
</div>
