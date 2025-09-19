<div>
    <x-card>
        <h3 class="mb-4 text-2xl text-center w-full text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">State Tax Rates and Thresholds</h3>
        <x-table :$headers :$sort :rows="$this->rows" striped paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_name', $row)
                {{ $row->name }}
            @endinteract
            @interact('column_code', $row)
                <div class="font-bold text-primary-600">{{ $row->code }}</div>
            @endinteract
            @interact('column_tax_rate', $row)
                {{ $row->tax_rate }}%
            @endinteract
            @interact('column_sales_threshold', $row)
                @if($row->thresholds && !empty($row->thresholds->sales_threshold))
                    {{ Number::currency($row->thresholds->sales_threshold) }}
                @else
                    None
                @endif
            @endinteract
            @interact('column_transaction_threshold', $row)
                @if($row->thresholds && !empty($row->thresholds->transaction_threshold))
                    {{ $row->thresholds->transaction_threshold }} Transactions
                @else
                    None
                @endif
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="magnifying-glass" wire:navigate href="{{ route('taxrates.county', ['state' => $row->id])}}" /> 
                </div>
            @endinteract
        </x-table>
    </x-card>
</div>
