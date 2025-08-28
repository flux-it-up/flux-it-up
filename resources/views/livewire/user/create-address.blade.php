<div>
    <x-button :text="__('Add Address')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Add Address')" wire x-on:open="setTimeout(() => $refs.name.focus(), 450)">
        <form id="address-create" wire:submit="save" class="space-y-4">
            <div>
                <x-select.native :label="__('Type')" wire:model="type" :options="[
                    ['label'=>'Shipping', 'value'=>'shipping'],
                    ['label'=>'Billing','value'=>'billing']
                ]" />
            </div>
            <div>
                <x-input label="Label" wire:model="label" />
            </div>
            <div>
                <x-input label="Address Line 1" wire:model="line1" />
            </div>
            <div>
            </div>
            <div>
                <x-input label="Address Line 2" wire:model="line2" />
            </div>
            <div>
                <x-input label="City" wire:model="city" />
            </div>
            <div>
                <x-select.styled wire:model="state" :options="$this->states" label="State" placeholder="Choose State..." required autofocus autocomplete="state" />
            </div>
            <div>
                <x-input label="Postal Code" wire:model="postal_code" />
            </div>
            <div>
                <x-input label="Country" wire:model="country" />
            </div>
            <div>
                <x-checkbox class="mt-3" label="Default Address" wire:model="is_default" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="address-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>