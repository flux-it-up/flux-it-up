<div>
    <x-card>
        <div class="mb-2 mt-4">
            <livewire:repair-request.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5,25,50,100]">
            @interact('column_user', $row)
                {{ $row->user->name }}
            @endinteract
            @interact('column_order_number', $row)
                {{ $row->order->order_number }}
            @endinteract
            @interact('column_console', $row)
                {{ $row->console->name }}
            @endinteract
            @interact('column_service', $row)
                {{ $row->service->name }}
            @endinteract
            @interact('column_repair_status', $row)
              @php
                  $colors = [
                    'received' => 'yellow',
                    'diagnosed' => 'cyan',
                    'approved' => 'green',
                    'in_progress' => 'primary',
                    'completed' => 'lime',
                    'quality_check' => 'amber',
                    'ready' => 'teal',
                    'shipped' => 'orange',
                    'delivered' => 'sky',
                    'cancelled' => 'red',
                    'refunded' => 'black',
                  ]
              @endphp
              <x-badge :color="$colors[$row->repair_status]" outline sm>
                {{ ucfirst($row->repair_status) }}
              </x-badge>
            @endinteract
            @interact('column_priority', $row)
              @php
                  $colors = [
                    'low' => 'black',
                    'normal' => 'primary',
                    'high' => 'yellow',
                    'urgent' => 'red',
                  ]
              @endphp
              <x-badge :color="$colors[$row->priority]" outline sm>
                {{ ucfirst($row->priority) }}
              </x-badge>
            @endinteract
            @interact('column_technician', $row)
                @if($row->technician)
                    {{ $row->technician->name }}
                @endif
            @endinteract
            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" wire:click="$dispatch('load::repair', { 'repair' : '{{ $row->id }}'})" />
                    <livewire:repair-request.delete :repair="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:repair-request.update @updated="$refresh" />
</div>
