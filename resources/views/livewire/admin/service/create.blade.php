<div>
    <x-button :text="__('Create New Service')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Create New Service')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="service-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" x-ref="name" wire:model="service.name" required />
            </div>
            <div>
                <x-input label="{{ __('Description') }} *" wire:model="service.description" required />
            </div>
            <div>
                <x-select.styled label="{{ __('Category') }} *" placeholder="Choose category..." wire:model="service.category_id" search :options="$serviceCategories" select="label:name|value:id" />
            </div>
            <div>
                <x-input label="{{ __('Service Code') }} *" placeholder="e.g. SCR, HDR, BTR..." wire:model="service.code" required />
            </div>
            <div>
                <x-input label="{{ __('Base Price') }} *" prefix="$" wire:model="service.base_price" required/>
            </div>
            <div>
                <x-input label="{{ __('Estimated Time') }} *" wire:model="service.estimated_time" required />
            </div>
            <div>
                <h3 class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">Choose a Console(s)</h3>
                @foreach($consoles as $console)
                    <div class="flex items-center space-x-4 m-2 p-3 border rounded-lg">
                        <x-checkbox wire:model.live="selectedConsoles" color="red" value="{{ $console->id }}" label="{{ $console->name }} ({{ $console->code }})" />
                        @if(in_array($console->id, $selectedConsoles))
                            <x-number wire:model="priceAdjustments.{{ $console->id }}" label="Price Adjustment ($)" step="5" class="w-32" />
                        @endif
                    </div>
                @endforeach
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="service-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
