<div>
    <!-- Modal -->
    <div 
        x-data="{ show: @entangle('showModal') }"
        x-show="show"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <!-- Background overlay -->
        <div 
            class="fixed inset-0 bg-transparent bg-opacity-20"
            x-on:click="$wire.closeModal()"
        ></div>

        <!-- Modal content -->
        <div class="flex items-center justify-center min-h-screen px-4">
            <div 
                class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6"
                x-on:click.stop
            >
                <!-- Close button -->
                <button 
                    wire:click="closeModal"
                    class="absolute top-4 right-4 text-black hover:text-dark-600"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal header -->
                <h3 class="text-lg font-medium text-dark-900 mb-4">
                    Get a Quote
                </h3>

                <!-- Modal body -->
                <div>
                    <!-- Your form content here -->
                    <form wire:submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600">Name</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border px-3 py-2">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-600">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-lg border px-3 py-2">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-600">Console Type</label>
                    <input type="text" wire:model="console_type" class="w-full rounded-lg border px-3 py-2">
                    @error('console_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-dark-600">Issue</label>
                    <textarea wire:model="issue" rows="4" class="w-full rounded-lg border px-3 py-2"></textarea>
                    @error('issue') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button 
                                type="button"
                                wire:click="closeModal"
                                class="m-4 px-4 py-2 text-sm font-medium text-dark-700 bg-dark-200 rounded-md hover:bg-dark-300"
                            >
                                Cancel
                            </button>
                    <button type="submit" class="m-4 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700">
                        Submit
                    </button>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
