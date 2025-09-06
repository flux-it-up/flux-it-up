<div>
    <x-button :text="__('Add New Console')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Add New Console')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="console-create" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled wire:model="console.brand" :options="['PlayStation','Xbox','Nintendo']" label="{{__('Brand') }} *" placeholder="Choose Brand..." required autofocus autocomplete="brand" />
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
                        <img src="{{ Storage::url($image) }}" class="mt-4 w-24 h-24 rounded-full mb-2" />
                    @endif
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="console-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
