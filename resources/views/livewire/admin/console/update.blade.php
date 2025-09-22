<div>
    <x-modal :title="__('Update Console: #:id', ['id' => $console?->id])" wire>
        <form id="console-update-{{ $console?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled label="{{ __('Brand') }} *" wire:model="console.brand_id" :options="$brands"  select="label:name|value:id" placeholder="Choose Brand..." required autofocus autocomplete="brand" />
            </div>
            <div>
                <x-input label="{{ __('Model') }} *" wire:model="console.model" />
            </div>
            <div>
                {{-- Image Upload --}}
                <div class="my-4">
                    <x-upload wire:model="newImage" label="Upload New Image" />
                    @error('newImage') <p class="text-red-500">{{ $message }}</p> @enderror
                    @if($image)
                        <img src="{{ Storage::url($image) }}" class="mt-4 w-24 h-24 mb-2" />
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <h3 class="text-sm text-secondary-600 dark:text-dark-300 whitespace-normal font-medium">Specifications</h3>
                @foreach ($specifications as $skey=>$spec)
                    <div class="grid grid-cols-5 gap-x-2" wire:key="spec-{{ $skey }}">
                        <div class="col-span-2">
                            <x-input wire:model="specifications.{{ $skey }}.name" label="Name" />
                        </div>
                        <div class="col-span-2">
                            <x-input wire:model="specifications.{{ $skey }}.svalue" label="Value" />
                        </div>
                        <div class="col-span-1">
                            <x-button icon="x-mark" wire:click="removeSpecificationsRow({{ $skey }})" class="mt-6" />
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="console-update-{{ $console?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
