<div>
    <x-modal :title="__(':name', ['name' => $console?->name])" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">

        <div class="flex gap-4">
            <div class="flex-shrink-0">
                @if($console?->image)
                    <img src="{{ Storage::url($console->image) }}" class="mt-4 w-48 h-48 mb-2" />
                @else
                    <img src="{{ Storage::url('consoles/placeholder.png') }}" class="mt-4 w-48 h-48 mb-2" />
                @endif
            </div>
            <div class="grid grid-cols-3 gap-x-2 flex-1 text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-light">
                <p class="font-bold text-md">@lang('Brand:')</p>
                <p class="col-span-2">{{ $console?->brand->name }}</p>
                <p class="font-bold text-md">@lang('Model:')</p>
                <p class="col-span-2">{{ $console?->model }}</p>
                <div class="col-span-3 py-4">
                    <x-separator line class="py-4" />
                </div>
                <p class="font-bold text-md">@lang('Model Numbers')</p>
                <p class="font-bold text-md">@lang('Release Years')</p>
                <p class="font-bold text-md">@lang('Storage Capacity')</p>
                @foreach($console?->models ?? [] as $model)
                    <p>
                        {{ $model->model ? $model->model : __('N/A') }}
                    </p>
                    <p>
                        {{ $model->release_year ? $model->release_year : __('N/A') }}
                    </p>
                    <p>
                        {{ $model->storage_capacity ? $model->storage_capacity : __('N/A') }}
                    </p>
                @endforeach
            </div>
        </div>
        <div class="py-4">
            <x-separator line />
        </div>
        <h3 class="text-md text-secondary-600 dark:text-dark-300 whitespace-normal font-semibold">Specifications</h3>
        <div class="flex gap-4">
            <div class="grid grid-cols-2 gap-x-2 flex-1">
                @if(!$console?->specifications)
                    <p class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-light">@lang('No specifications available.')</p>
                @else
                    @foreach($console?->specifications ?? [] as $sk=>$sv)
                        <p class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-light">{{ $sk }}:</p>
                        <p class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-light">{{ $sv }}</p>
                    @endforeach
                @endif
            </div>
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
                    wire:click="$dispatch('load::console', { 'console' : '{{ $console?->id }}'})" 
                >
                    {{ __('Edit Console') }}
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
</div>
