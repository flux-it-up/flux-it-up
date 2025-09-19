<div>
    <x-card>
        <x-button icon="arrow-long-left" text="Back to States" wire:navigate href="{{ route('taxrates.state')}}" class="mb-2" /><x-button icon="arrow-long-left" text="Back to Counties" wire:navigate href="{{ route('taxrates.county', ['state' => $state->id])}}" class="mb-2" />
        <h3 class="mb-4 text-2xl text-center w-full text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">City Tax Rates for {{ $county->name }} County</h3>
        <x-table :$headers :$sort :rows="$this->rows" striped paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_name', $row)
                <div class="font-bold text-primary-600">{{ $row->name }}</div>
            @endinteract
            @interact('column_tax_rate', $row)
                {{ $row->tax_rate }}%
            @endinteract
        </x-table>
    </x-card>
</div>
