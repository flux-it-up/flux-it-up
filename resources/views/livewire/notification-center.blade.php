<div class="max-w-4xl mx-auto p-6">
    <x-card>
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
                        outline
                    >
                        Mark All Read
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="flex items-start space-x-4 p-4 rounded-lg border {{ $notification->read_at ? 'bg-white' : 'bg-blue-50 border-blue-200' }}">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-{{ $notification->data['color'] ?? 'blue' }}-100 flex items-center justify-center">
                            <x-icon 
                                name="{{ $notification->data['icon'] ?? 'bell' }}" 
                                class="w-5 h-5 text-{{ $notification->data['color'] ?? 'blue' }}-600"
                            />
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ $notification->created_at->format('M j, Y g:i A') }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2 ml-4">
                                @if($notification->data['action_url'] ?? null)
                                    <x-button 
                                        href="{{ $notification->data['action_url'] }}"
                                        size="sm"
                                        color="primary"
                                        outline
                                    >
                                        {{ $notification->data['action_text'] ?? 'View' }}
                                    </x-button>
                                @endif

                                @if(!$notification->read_at)
                                    <x-button 
                                        wire:click="markAsRead('{{ $notification->id }}')"
                                        size="sm"
                                        color="gray"
                                        outline
                                    >
                                        Mark Read
                                    </x-button>
                                @endif

                                <x-button 
                                    wire:click="deleteNotification('{{ $notification->id }}')"
                                    size="sm"
                                    color="red"
                                    outline
                                    wire:confirm="Are you sure you want to delete this notification?"
                                >
                                    <x-icon name="trash" class="w-4 h-4" />
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <x-icon name="bell-slash" class="w-16 h-16 mx-auto text-gray-300 mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                    <p class="text-gray-600">You're all caught up!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </x-card>
</div>
