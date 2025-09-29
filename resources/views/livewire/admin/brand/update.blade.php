<div>
    <x-modal :title="__('Update Console Brand: #:id', ['id' => $brand?->id])" wire >
        <form id="brand-update-{{ $brand?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Name') }} *" wire:model="brand.name" x-ref="brand" />
            </div>
            <div>
                {{-- Image Upload --}}
                <div class="my-4">
                    <x-upload wire:model="newImage" label="Upload New Image" />
                    @error('newImage') <p class="text-red-500">{{ $message }}</p> @enderror
                    @if($image)
                        <img src="{{ Storage::url($image) }}" class="mt-4 w-24 h-24 rounded-full mb-2" />
                    @endif
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="brand-update-{{ $brand?->id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
