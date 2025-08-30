<div>
    <x-modal :title="__('Update Repair Request: #:id', ['id' => $repair?->id])" wire>
        <form id="repair-request-update-{{ $repair?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled label="{{ __('User') }} *" placeholder="Choose user..." wire:model="repair.user_id" searchable :options="$users" select="label:name|value:id" />
            </div>
            <div>
                <x-select.styled label="{{ __('Console') }} *" placeholder="Choose console..." wire:model.live="selectedConsole" search :options="$consoles" select="label:name|value:id" />
            </div>
            <div>
                <x-select.styled label="{{ __('Service') }} *" placeholder="Choose service..." wire:model.live="selectedService" search :options="$services" select="label:name|value:id" />
            </div>
            <div>
                <x-input label="{{ __('Console Serial Number') }} *" wire:model="repair.console_serial_number" required />
            </div>
            <div>
                <x-textarea label="{{ __('Issue Description') }} *" wire:model="repair.issue_description" resize-auto required />
            </div>
            <div>
                <x-textarea label="{{ __('Customer Notes') }}" wire:model="repair.customer_notes" resize-auto />
            </div>
            <div>
                <x-select.styled label="{{ __('Status') }} *" placeholder="Choose status..." wire:model="repair.repair_status" :options="[['label' => 'Received', 'value' => 'received'],['label' => 'Diagnosed', 'value' => 'diagnosed'],['label' => 'Approved', 'value' => 'approved'],['label' => 'In Progress', 'value' => 'in_progress'],['label' => 'Completed', 'value' => 'completed'],['label' => 'Quality Check', 'value' => 'quality_check'],['label' => 'Ready', 'value' => 'ready'],['label' => 'Shipped', 'value' => 'shipped'],['label' => 'Delivered', 'value' => 'delivered'],['label' => 'Cancelled', 'value' => 'cancelled'],]" />
            </div>
            <div>
                <x-select.styled label="{{ __('Priority') }} *" placeholder="Choose priority..." wire:model="repair.priority" :options="[['label' => 'Low', 'value' => 'low'],['label' => 'Normal', 'value' => 'normal'],['label' => 'High', 'value' => 'high'],['label' => 'Urgent', 'value' => 'urgent'],]" />
            </div>
            <div>
                <x-date label="{{ __('Estimated Completion Date') }}" :min-date="now()->subWeek()" wire:model="repair.estimated_completion" />
            </div>
            <div>
                <x-select.styled label="{{ __('Assign Technician') }}" placeholder="Choose technician..." wire:model="repair.technician_id" searchable :options="$users" select="label:name|value:id" />
            </div>
            <div>
                <x-date label="{{ __('Warranty Expiration Date') }}" :min-date="now()->subWeek()" wire:model="repair.warranty_expires" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="repair-request-update-{{ $repair?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
