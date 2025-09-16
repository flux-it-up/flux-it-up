<div>
    <x-modal :title="__('Update Service: #:id', ['id' => $service?->id])" wire>
        <form id="service-update-{{ $service?->id }}" wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-2 gap-x-2">
                <x-input label="{{ __('Name') }} *" x-ref="name" wire:model="service.name" required />
                <x-input label="{{ __('Description') }} *" wire:model="service.description" required />
            </div>
            <div class="grid grid-cols-1 gap-x-2">
                <x-select.styled label="{{ __('Category') }} *" placeholder="Choose category..." wire:model="service.category_id" search :options="$serviceCategories" select="label:name|value:id" />
            </div>
            <div class="grid grid-cols-2 gap-x-2">
                <x-input label="{{ __('Base Price') }} *" prefix="$" wire:model="service.base_price" required/>
                <x-input label="{{ __('Estimated Time') }} *" wire:model="service.estimated_time" required />
            </div>
            <div class="grid grid-cols-2 gap-x-2">
                <x-textarea label="{{ __('Requirements') }}" wire:model="service.requirements" resize-auto />
                <x-textarea label="{{ __('What`s Included') }}" wire:model="service.what_included" resize-auto />
            </div>
            <div class="grid grid-cols-2 gap-x-2">
                <x-checkbox label="{{ __('Requires Diagnostics?') }}" wire:model="service.requires_diagnostics" />
                <x-input label="{{ __('Diagnostic Fee') }}" prefix="$" wire:model="service.diagnostic_fee" />
            </div>
            <div>
                <h3 class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">Choose a Console(s)</h3>
                @foreach($consoles as $console)
                    <div class="flex items-center space-x-4 m-2 p-3 border rounded-lg">
                        <x-checkbox wire:model.live="selectedConsoles.{{ $console->id}}.selected" color="red" value="{{ $console->id }}" label="{{ $console->name }} ({{ $console->code }})" />
                        @if(data_get($selectedConsoles, $console['id'].'.selected'))
                            <x-number wire:model="priceAdjustments.{{ $console->id }}.price_adjustment" label="{{ __('Price Adjustment ($)')  }}" step="5" class="w-32" />
                        @endif
                    </div>
                @endforeach
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="service-update-{{ $service?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
