<div>
    <x-modal :title="__('Upload Image')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="image-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Alt Text') }} *" wire:model="image.alt_text" required />
            </div>
            <div class="my-4">
                <x-upload label="Upload New Image" wire:model.live="image.image_url" />
                @error('image') <p class="text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-input label="{{ __('Sort Order') }} *" wire:model="image.sort_order" required />
            </div>
            <div>
                <x-checkbox class="mt-3" label="Primary" wire:model="image.is_primary" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="image-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
