<div>
    <x-modal :title="__('Update Console: #:id', ['id' => $console?->id])" wire>
        <form id="console-update-{{ $console?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled wire:model="console.brand" :options="['PlayStation','Xbox','Nintendo']" label="Brand *" placeholder="Choose Brand..." required autofocus autocomplete="brand" />
            </div>
            <div>
                <x-input label="Model *" wire:model="console.model" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="console-update-{{ $console?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
