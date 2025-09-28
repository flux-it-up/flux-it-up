<div class="w-full mx-auto p-6">
    <x-card color="primary" bordered>
        <x-slot:header>
            <div class="flex p-4 items-center justify-between">
                <h2 class="text-xl font-semibold">Notification Center</h2>
                
                <div class="flex items-center space-x-4">
                    <!-- Filter Tabs -->
                    <x-select.native 
                        wire:model.live="filter" 
                        :options="[
                            ['label' => 'All', 'value' => 'all'],
                            ['label' => 'Unread', 'value' => 'unread'],
                            ['label' => 'Read', 'value' => 'read']
                        ]"
                        placeholder="Filter messages..."
                    />
                    
                    <!-- Mark All Read Button -->
                    <x-button 
                        wire:click="markAllAsRead"
                        size="sm"
                    >
                        Mark All Read
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="flex items-start space-x-4 p-4 border-t border-b border-primary-600 {{ $notification->read_at ? 'bg-dark-700' : 'bg-dark-800' }}">
                    <!-- Icon -->
                    <x-icon 
                        name="{{ $notification->data['icon'] ?? 'bell' }}" 
                        class="w-8 h-8 text-{{ $notification->data['color'] ?? 'blue' }}-600"
                    />

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-md font-bold text-dark-300">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                <p class="text-sm text-dark-500 mt-1">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-dark-400 mt-2">
                                    {{ $notification->created_at->format('M j, Y g:i A') }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2 ml-4">
                                @if($notification->action_url ?? null)
                                    <x-button 
                                        href="{{ $notification->action_url }}"
                                        size="sm"
                                        color="primary"
                                    >
                                        {{ $notification->action_text ?? 'View' }}
                                    </x-button>
                                @endif

                                @if(!$notification->read_at)
                                    <x-button 
                                        wire:click="markAsRead('{{ $notification->id }}')"
                                        size="sm"
                                        color="gray"
                                    >
                                        Mark Read
                                    </x-button>
                                @endif

                                <x-button 
                                    wire:click="confirmDelete('{{ $notification->id }}')"
                                    size="sm"
                                    color="red"
                                    wireable
                                >
                                    <x-icon name="trash" class="w-5 h-5" />
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <x-icon name="bell-slash" class="w-16 h-16 mx-auto text-dark-300 mb-4" />
                    <h3 class="text-lg font-medium text-dark-400 mb-2">No notifications</h3>
                    <p class="text-dark-500">You're all caught up!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </x-card>
</div>
