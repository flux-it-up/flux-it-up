<div>
    {{-- Trigger Button --}}
    <x-button 
        :text="__('Add Address')" 
        wire:click="openModal" 
        sm 
        icon="plus"
        class="inline-flex items-center"
    />

    {{-- Modal --}}
    @if($modal)
        <x-modal 
        :title="__('Add Address')" 
        wire:model="modal"
        max-width="4xl"
        x-on:open="setTimeout(() => $refs.label?.focus(), 450)" wire
    >
        <form id="address-create" wire:submit="save" class="space-y-6">
            
            {{-- Address Type and Label Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select.native 
                    :label="__('Address Type')" 
                    wire:model.live="type" 
                    :options="[
                        ['label' => __('Shipping'), 'value' => 'shipping'],
                        ['label' => __('Billing'), 'value' => 'billing'],
                        ['label' => __('Both'), 'value' => 'both']
                    ]" 
                    required
                />
                
                <x-input 
                    :label="__('Label')" 
                    x-ref="label" 
                    wire:model="label" 
                    :placeholder="__('e.g., Home, Office, etc.')"
                    autocomplete="address-label"
                />
            </div>

            {{-- Address Lines --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input 
                    :label="__('Address Line 1')" 
                    wire:model="line1" 
                    :placeholder="__('Street address')"
                    autocomplete="address-line1"
                    required
                />
                
                <x-input 
                    :label="__('Address Line 2')" 
                    wire:model="line2" 
                    :placeholder="__('Apartment, suite, etc. (optional)')"
                    autocomplete="address-line2"
                />
            </div>

            {{-- Postal Code and City --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input 
                        :label="__('Postal Code')" 
                        wire:model.live.debounce.500ms="postal_code" 
                        :hint="__('City, County, and State will populate automatically.')"
                        autocomplete="postal-code"
                        required
                        maxlength="10"
                    />
                    
                    {{-- Loading indicator for postal code lookup --}}
                    <div wire:loading wire:target="updatedPostalCode" class="mt-1">
                        <span class="text-xs text-gray-500 flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('Looking up location...') }}
                        </span>
                    </div>
                </div>
                
                <x-select.styled 
                    :label="__('City')" 
                    wire:model.live="city_id" 
                    :options="$cities" 
                    select="label:name|value:id" 
                    :placeholder="__('Choose City...')" 
                    required 
                    autocomplete="address-level2"
                    :disabled="empty($cities) || $cities->isEmpty()"
                />
            </div>

            {{-- County and State --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select.styled 
                    :label="__('County')" 
                    wire:model.live="county_id" 
                    :options="$counties" 
                    select="label:name|value:id" 
                    :placeholder="__('Choose County...')" 
                    required 
                    autocomplete="address-level3"
                    :disabled="empty($counties) || $counties->isEmpty()"
                />
                
                <x-select.styled 
                    :label="__('State')" 
                    wire:model.live="state_id" 
                    :options="$states" 
                    select="label:name|value:id" 
                    :placeholder="__('Choose State...')" 
                    required 
                    autocomplete="address-level1"
                />
            </div>

            {{-- Country and Options --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input 
                    :label="__('Country')" 
                    wire:model="country" 
                    autocomplete="country-name"
                    readonly
                    class="bg-gray-50"
                />
                
                <div class="space-y-3 pt-6">
                    {{-- Default Address Checkbox --}}
                    @if($this->canSetDefault)
                        <x-checkbox 
                            :label="__('Set as default address')" 
                            wire:model="is_default"
                            :description="__('This will be your primary :type address', ['type' => $type])"
                        />
                    @endif
                    
                    {{-- Billing Same as Shipping --}}
                    @if($type === 'shipping')
                        <x-checkbox 
                            :label="__('Use for billing too')" 
                            wire:model="billing_same_as_shipping"
                            :description="__('Create a billing address with the same information')"
                        />
                    @endif
                </div>
            </div>

            {{-- Address Preview (if filled) --}}
            @if($line1 && $city_id && $state_id)
                <div class="bg-dark-500 rounded-lg p-4 border">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">{{ __('Address Preview') }}</h4>
                    <div class="text-sm text-gray-700 space-y-1">
                        @if($label)
                            <div class="font-medium">{{ $label }}</div>
                        @endif
                        <div>{{ $line1 }}</div>
                        @if($line2)
                            <div>{{ $line2 }}</div>
                        @endif
                        <div>
                            @if($cities->firstWhere('id', $city_id))
                                {{ $cities->firstWhere('id', $city_id)->name }},
                            @endif
                            @if($states->firstWhere('id', $state_id))
                                {{ $states->firstWhere('id', $state_id)->name }}
                            @endif
                            {{ $postal_code }}
                        </div>
                        <div>{{ $country }}</div>
                    </div>
                </div>
            @endif

        </form>

        {{-- Modal Footer --}}
        <x-slot:footer>
            <div class="flex justify-between items-center w-full">
                {{-- Cancel Button --}}
                <x-button 
                    variant="ghost" 
                    wire:click="closeModal"
                >
                    {{ __('Cancel') }}
                </x-button>

                {{-- Save Button --}}
                <x-button 
                    type="submit" 
                    form="address-create"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    icon="check"
                >
                    <span wire:loading.remove wire:target="save">
                        {{ __('Save Address') }}
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Saving...') }}
                    </span>
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    {{-- Inline Styles --}}
    <style>
        /* Custom loading state for disabled selects */
        select:disabled {
            @apply bg-gray-100 text-gray-500 cursor-not-allowed;
        }
        
        /* Smooth transitions for form elements */
        .form-element {
            @apply transition-all duration-200 ease-in-out;
        }
    </style>

    {{-- JavaScript for enhanced UX --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Auto-focus next field when postal code is filled
            Livewire.on('postal-code-updated', () => {
                setTimeout(() => {
                    const citySelect = document.querySelector('[wire\\:model\\.live="city_id"]');
                    if (citySelect && !citySelect.disabled) {
                        citySelect.focus();
                    }
                }, 100);
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                // Escape to close modal
                if (e.key === 'Escape' && @this.modal) {
                    @this.closeModal();
                }
                
                // Ctrl/Cmd + Enter to save
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter' && @this.modal) {
                    e.preventDefault();
                    @this.save();
                }
            });
        });
    </script>
    @endif
    
</div>
