<div>
    <x-modal :title="__('Update Console Model: #:id', ['id'=>$model?->id])" wire>
        <form id="model-update-{{ $model?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled label="{{__('Console') }} *" x-ref="console" wire:model="model.console_id" :options="$consoles" searchable select="label:name|value:id" placeholder="Choose Console..." required autofocus autocomplete="console" />
            </div>
            <div>
                <x-input label="{{ __('Model Number') }} *" wire:model="model.model" />
            </div>
            <div>
                <x-select.styled label="{{ __('Release Year') }}" wire:model="model.release_year" placeholder="Select release year..." :options="$years" />
            </div>
            <div>
                <x-input label="{{ __('Storage Capacity') }}" wire:model="model.storage_capacity" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="model-update-{{ $model?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
