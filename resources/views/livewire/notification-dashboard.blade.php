<div>
    <x-card color="blue" bordered>
        <x-slot:header>
            <div class="p-4 mx-2 flex items-center justify-between">
                <h3 class="mx-2 text-lg font-semibold text-gray-900 dark:text-white">
                    Notifications
                </h3>
                <x-button 
                    href="{{ route('notifications.index') }}" 
                    color="primary" 
                    size="sm"
                    wire:navigate
                >
                    View All
                </x-button>
            </div>
        </x-slot:header>

        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div class="flex items-start space-x-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <x-icon name="bell" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        {{ $notification->title }}
                    </p>
                </div>
            @empty
                <div class="text-center py-12">
                    <x-icon name="bell-slash" class="w-16 h-16 mx-auto text-dark-300 mb-4" />
                    <h3 class="text-lg font-medium text-dark-400 mb-2">No notifications</h3>
                    <p class="text-dark-500">You're all caught up!</p>
                </div>
            @endforelse
        </div>
    </x-card>
</div>
