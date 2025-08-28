<div>
    <x-button :text="__('Add New Console')" wire:click="$toggle('modal')" sm />

    <x-modal :title="__('Add New Console')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="console-create" wire:submit="save" class="space-y-4">
            <div>
                <x-select.styled wire:model="console.brand" :options="['PlayStation','Xbox','Nintendo']" label="Brand *" placeholder="Choose Brand..." required autofocus autocomplete="brand" />
            </div>
            <div>
                <x-input label="Model *" wire:model="console.model" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="console-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
