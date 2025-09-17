<div>
    <x-modal :title="__('Inventory Transactions for :product', ['product' => $product])" wire>
        <x-separator line />
        @if($transactions)
            @foreach($transactions as $transaction)
                <div class="grid grid-cols-2 gap-2 m-2">
                    <div>ID: {{ $transaction->transaction_id }}</div>
                    <div>Transaction Type: {{ ucfirst($transaction->transaction_type) }}</div>
                    <div>Quantity Before: {{ $transaction->quantity_before }}</div>
                    <div>Quantity After: {{ $transaction->quantity_after }}</div>
                    <div>Reference Id: {{ $transaction->referenceable_id }}</div>
                    <div>Reference Type: {{ $transaction->referenceable_type }}</div>
                    <div>Notes: {{ $transaction->notes }}</div>
                    <div>Created By: {{ $transaction->user->name }}</div>
                </div>
                <x-separator line />
            @endforeach
        @else
            No transactions available.
        @endif
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-button 
                    wire:click="$set('modal', false)" 
                    color="primary-600"
                >
                    Close
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
</div>
