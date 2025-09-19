<div>
    <x-card>
        <x-button icon="arrow-long-left" text="Back to States" wire:navigate href="{{ route('taxrates.state')}}" class="mb-2" />
        <h3 class="mb-4 text-2xl text-center w-full text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">County Tax Rates for {{ $state->name }}</h3>
        <x-table :$headers :$sort :rows="$this->rows" striped paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_name', $row)
                <div class="font-bold text-primary-600">{{ $row->name }}</div>
            @endinteract
            @interact('column_tax_rate', $row)
                {{ $row->tax_rate }}%
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="magnifying-glass" wire:navigate href="{{ route('taxrates.city', ['state' => $row->state_id, 'county' => $row->id])}}" /> 
                </div>
            @endinteract
        </x-table>
    </x-card>
</div>
