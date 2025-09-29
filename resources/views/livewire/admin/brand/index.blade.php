<div>
    <x-card color="primary" bordered>
        <div class="mb-2 mt-4">
            <x-slot:header>
                <div class="p-4 mx-2 flex items-center justify-between">
                    <h3 class="mx-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Brands
                    </h3>
                    <livewire:admin.brand.create @created="$refresh" />
                </div>
            </x-slot:header>
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_logo', $row)
                <img src="{{ $row->logo ? Storage::url($row->logo) : Storage::url('consoles/placeholder.png') }}" class="mt-4 w-18 h-18 mb-2" />
            @endinteract
            @interact('column_name', $row)
                {{ $row->name }}
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::brand', { 'id' : '{{ $row->id }}'})" />
                <livewire:admin.brand.delete :brand="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>
    <livewire:admin.brand.update @updated="$refresh" />
</div>
