<div>
    <x-card>
        {{-- <x-alert color="amber" icon="light-bulb">
            @lang('Remember to take a look at the source code to understand how the components in this area were built and are being used.')
        </x-alert> --}}

        <div class="mb-2">
            <livewire:user.update-profile @created="$refresh" />
        </div>
        <div class="mb-2">
            <livewire:user.create-address @created="$refresh" />
        </div>
    
        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_type', $row)
                {{ ucfirst($row->type) }}
            @endinteract
            @interact('column_address', $row)
                <span>
                    {{ $row->line1 }}<br>
                    @if($row->line2)
                        {{ $row->line2 }}<br>
                    @endif
                    {{ $row->city }}, {{ $row->state }} {{ $row->postal_code }}<br>
                    {{ $row->country }}
                </span>
            @endinteract
            @interact('column_is_default', $row)
                @if($row->is_default)
                    <x-badge color="green">True</x-badge>
                @endif
            @endinteract
            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::address', { 'address' : '{{ $row->id }}'})" />
                <livewire:user.delete-address :address="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:user.update-address @updated="$refresh" />
</div>

            