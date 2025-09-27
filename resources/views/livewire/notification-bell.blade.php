<div class="relative" x-data="{ open: @entangle('showDropdown') }">
    <!-- Bell Icon -->
    <button 
        @click="open = !open"
        class="relative p-2 text-primary-500 cursor-pointer hover:text-dark-700 focus:none square"
    >
        <x-icon name="bell" class="w-6 h-6" />
        
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div 
        x-show="open"
        x-transition
        @click.away="open = false"
        class="absolute right-0 mt-2 w-80 bg-dark-700 rounded-lg shadow-lg border border-dark-600 z-50"
    >
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-dark-600">
            <h3 class="text-lg font-semibold text-primary-600">Notifications</h3>
            @if($unreadCount > 0)
                <button 
                    wire:click="markAllAsRead"
                    class="text-sm text-primary-600 hover:text-dark-900"
                >
                    Mark all read
                </button>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div 
                    class="p-4 border-b border-dark-600 hover:bg-dark-800 {{ !$notification['read_at'] ? 'bg-dark-900' : '' }}"
                    wire:click="markAsRead('{{ $notification['id'] }}')"
                >
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <x-icon 
                                name="{{ $notification['icon'] }}" 
                                class="w-6 h-6 text-{{ $notification['color'] }}-500"
                            />
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-dark-500">
                                    {{ $notification['title'] }}
                                </p>
                                @if(!$notification['read_at'])
                                    <div class="w-2 h-2 bg-{{ $notification['color'] }}-500 rounded-full"></div>
                                @endif
                            </div>
                            
                            <p class="text-sm text-dark-400 mt-1">
                                {{ $notification['message'] }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-dark-500">
                                    {{ $notification['created_at'] }}
                                </span>
                                
                                @if($notification['action_url'])
                                    <a 
                                        href="{{ $notification['action_url'] }}"
                                        class="text-xs text-blue-600 hover:text-blue-800"
                                        @click="open = false"
                                    >
                                        {{ $notification['action_text'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-dark-500">
                    <x-icon name="bell-slash" class="w-12 h-12 mx-auto mb-4 text-gray-300" />
                    <p>No notifications yet</p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        @if(count($notifications) > 0)
            <div class="p-4 border-t border-dark-600">
                <a 
                    href="{{ route('notifications.index') }}"
                    class="block text-center text-sm text-primary-600 hover:text-dark-900"
                    @click="open = false"
                >
                    View all notifications
                </a>
            </div>
        @endif
    </div>
</div>
