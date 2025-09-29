<div>
    <x-button :text="__('Add New Console Brand')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Add New Console Brand')" wire x-on:open="setTimeout(() => $refs.name.focus(), 450)">
        <form id="brand-create" wire:submit="save" class="space-y-4">
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
            <x-button type="submit" form="brand-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
