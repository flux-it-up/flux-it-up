<div>
    <x-card color="primary" bordered>
        <div class="mb-2 mt-4">
            <x-slot:header>
                <div class="p-4 mx-2 flex items-center justify-between">
                    <h3 class="mx-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Models
                    </h3>
                    <livewire:admin.model.create @created="$refresh" />
                </div>
            </x-slot:header>
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate filter loading :quantity="[5,25,50,100]">
            @interact('column_console', $row)
                {{ $row->console->name }}
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                {{-- <x-button.circle icon="eye" wire:click="$dispatch('view::model', {id: {{ $row->id }} })" /> --}}
                <x-button.circle icon="pencil" wire:click="$dispatch('load::model', { 'id' : '{{ $row->id }}'})" />
                <livewire:admin.model.delete :model="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>
    <livewire:admin.model.view />
    <livewire:admin.model.update @updated="$refresh" />
</div>
