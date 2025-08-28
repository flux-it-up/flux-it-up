<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:order.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_user_id', $row)
                {{ ucfirst($row->user->name) }}
            @endinteract
            @interact('column_order_type', $row)
                {{ ucfirst($row->order_type) }}
            @endinteract
            @interact('column_order_status', $row)
              @php
                  $colors = [
                    'pending' => 'yellow',
                    'confirmed' => 'cyan',
                    'processing' => 'primary',
                    'shipped' => 'green',
                    'delivered' => 'sky',
                    'cancelled' => 'red',
                    'refunded' => 'black',
                  ]
              @endphp
              <x-badge :color="$colors[$row->order_status]" outline sm>
                {{ ucfirst($row->order_status) }}
              </x-badge>
            @endinteract
            @interact('column_payment_status', $row)
                @php
                  $colors = [
                    'pending' => 'yellow',
                    'paid' => 'cyan',
                    'partial' => 'primary',
                    'failed' => 'red',
                    'refunded' => 'black',
                  ]
              @endphp
              <x-badge :color="$colors[$row->payment_status]" outline sm>
                {{ ucfirst($row->payment_status) }}
              </x-badge>
            @endinteract
            @interact('column_subtotal', $row)
                ${{ $row->subtotal }}
            @endinteract
            @interact('column_tax_amount', $row)
                ${{ $row->tax_amount }}
            @endinteract
            @interact('column_shipping_amount', $row)
                ${{ $row->shipping_amount }}
            @endinteract
            @interact('column_discount_amount', $row)
                ${{ $row->discount_amount }}
            @endinteract
            @interact('column_paid_amount', $row)
                ${{ $row->paid_amount }}
            @endinteract
            @interact('column_total_amount', $row)
                ${{ $row->total_amount }}
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" wire:click="$dispatch('load::order', {'order':'{{ $row->id }}'})" />
                    {{-- <livewire:order.delete :product="$row" :key="uniqid('', true)" @deleted="$refresh" /> --}}
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:order.update @updated="$refresh" />
</div>
