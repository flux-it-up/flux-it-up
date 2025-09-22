<div>
    <x-modal :title="__(':name', ['name' => $service?->name])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">

        <div class="grid grid-cols-2 gap-x-2 flex-1 text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-light">
            <p class="font-bold text-md">@lang('Service Name:')</p>
            <p>{{ $service?->name }}</p>
            <p class="font-bold text-md">@lang('Category:')</p>
            <p>{{ $service?->category?->name ?? __('Uncategorized') }}</p>
            <p class="font-bold text-md">@lang('Description:')</p>
            <p>{{ $service?->description }}</p>
            <p class="font-bold text-md">@lang('Base Price:')</p>
            <p>{{ $service?->base_price ? '$' . number_format($service->base_price, 2) : __('Free') }}</p>
            <p class="font-bold text-md">@lang('Estimated Duration:')</p>
            <p>{{ $service?->estimated_time ? $service->estimated_time : __('N/A') }}</p>
            <p class="font-bold text-md">@lang('Service SKU:')</p>
            <p>{{ $service?->sku ? $service->sku : __('N/A') }}</p>
            <p class="font-bold text-md">@lang('Requirements:')</p>
            <p>{{ $service?->requirements ? $service->requirements : __('N/A') }}</p>
            <p class="font-bold text-md">@lang('What`s Included:')</p>
            <p>{{ $service?->what_included ? $service->what_included : __('N/A') }}</p>
            <p class="font-bold text-md">@lang('Requires Diagnostics:')</p>
            <p>{{ $service?->requires_diagnostics ? __('Yes') : __('No') }}</p>
            @if($service?->requires_diagnostics)
                <p class="font-bold text-md">@lang('Diagnostic Fee:')</p>
                <p>{{ $service?->diagnostic_fee ? '$' . number_format($service->diagnostic_fee, 2) : __('N/A') }}</p>
            @endif
        </div>
        <div class="py-4">
            <x-separator line />
        </div>
        <div class="grid grid-cols-3 gap-x-2 flex-1 text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-light"> 
            <p class="font-bold text-md">@lang('Compatible Consoles')</p>
            <p class="font-bold text-md">@lang('Additional Cost')</p>
            <p class="font-bold text-md">@lang('Console SKU')</p>
            @foreach($service?->consoles ?? [] as $console)
                <p>{{ $console->name ? $console->name : __('No compatible consoles') }}</p>
                <p>{{ $console->pivot->price_adjustment ? '$' . number_format($console->pivot->price_adjustment, 2) : __('No additional cost') }}</p>
                <p>{{ $console->pivot->sku ? $console->pivot->sku : __('N/A') }}</p>
            @endforeach
        </div>
        
        <x-slot:footer>
            <div class="flex justify-between items-center w-full">
                {{-- Cancel Button --}}
                <x-button 
                    variant="ghost" 
                    x-on:click="show = false"
                >
                    {{ __('Cancel') }}
                </x-button>

                <x-button 
                    icon="pencil" 
                    x-on:click="show = false"
                    wire:click="$dispatch('load::service', { 'service' : '{{ $service?->id }}'})" 
                >
                    {{ __('Edit') }}
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
</div>