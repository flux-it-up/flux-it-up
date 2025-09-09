<div>
    <x-modal :title="__('Update Address: #:id',['id'=> $address?->id])" wire>
        <form id="address-update-{{ $address?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.native :label="__('Type')" wire:model="address.type" :options="[
                    ['label'=>'Shipping', 'value'=>'shipping'],
                    ['label'=>'Billing','value'=>'billing']
                ]" />
            </div>
            <div>
                <x-input label="Label" wire:model="address.label" />
            </div>
            <div>
                <x-input label="Address Line 1" wire:model="address.line1" />
            </div>
            <div>
                
            </div>
            <div>
                <x-input label="Address Line 2" wire:model="address.line2" />
            </div>
            <div>
                <x-input label="City" wire:model="address.city" />
            </div>
            <div>
                <x-select.styled wire:model="address.state" :options="$this->states" label="State" placeholder="Choose State..." required autofocus autocomplete="state" />
            </div>
            <div>
                <x-input label="Postal Code" wire:model="address.postal_code" />
            </div>
            <div>
                <x-input label="Country" wire:model="address.country" />
            </div>
            <div>
                <x-checkbox class="mt-3" label="Default Address" wire:model="address.is_default" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="address-update-{{ $address?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>