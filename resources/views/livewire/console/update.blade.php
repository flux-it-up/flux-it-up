<div>
    <x-modal :title="__('Update Console: #:id', ['id' => $console?->id])" wire>
        <form id="console-update-{{ $console?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled wire:model="console.brand" :options="['PlayStation','Xbox','Nintendo']" label="Brand *" placeholder="Choose Brand..." required autofocus autocomplete="brand" />
            </div>
            <div>
                <x-input label="{{ __('Model') }} *" wire:model="console.model" />
            </div>
            <div>
                <x-input label="{{ __('Model Number') }}" wire:model="console.model_number" />
            </div>
            <div>
                <x-select.styled label="{{ __('Release Year') }}" wire:model="console.release_year" placeholder="Select release year..." :options="$years" />
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
        </form>
        <x-slot:footer>
            <x-button type="submit" form="console-update-{{ $console?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
