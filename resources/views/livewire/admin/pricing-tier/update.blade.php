<div>
    <x-modal :title="__('Update Pricing Tier: #:id', ['id' => $pricing_tier?->id])" wire>
        <form id="pricing-tier-update" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" x-ref="name" wire:model="pricing_tier.name" required />
            </div>
            <div>
                <x-select.styled name="service_ids" label="{{ __('Select Services') }}" placeholder="Choose services..." wire:model="service_ids" multiple search :options="$selectedServices" select="label:name|value:id" />
            </div>
            <div>
                <x-input label="{{ __('Price') }}" prefix="$" wire:model="pricing_tier.price" required/>
            </div>
            <div>
                <x-input label="{{ __('Warranty') }} *" wire:model="pricing_tier.warranty" required />
            </div>
            <div>
                <x-input label="{{ __('Estimated Time') }} *" wire:model="pricing_tier.estimated_time" required />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="pricing-tier-update">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
