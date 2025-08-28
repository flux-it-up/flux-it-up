<div>
    <x-button :text="__('Create New Pricing Tier')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Create New Pricing Tier')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="pricing-tier-create" wire:submit="save" class="space-y-4">
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
            <x-button type="submit" form="pricing-tier-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
