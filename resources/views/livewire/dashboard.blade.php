<div>
    <div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Dashboard
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Welcome back, {{ Auth::user()->name }}!
            </p>
        </div>
        
        <div class="flex space-x-3">
            @hasrole('customer')
                <x-button href="#" color="primary" icon="plus">
                    New Repair Request
                </x-button>
            @endhasrole
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @hasanyrole('super-admin|admin|manager|support|technician')
            <x-stats-card 
                title="Total Orders" 
                :value="$stats['total_orders']" 
                icon="shopping-bag"
                color="blue"
            />
            <x-stats-card 
                title="Pending Orders" 
                :value="$stats['pending_orders']" 
                icon="clock"
                color="yellow"
            />
            <x-stats-card 
                title="Completed Orders" 
                :value="$stats['completed_orders']" 
                icon="check-circle"
                color="green"
            />
            <x-stats-card 
                title="Revenue This Month" 
                value="${{ number_format($stats['revenue_this_month'], 2) }}" 
                icon="currency-dollar"
                color="emerald"
            />
        @else
            <x-stats-card 
                title="My Orders" 
                :value="$stats['my_orders']" 
                icon="shopping-bag"
                color="blue"
            />
            <x-stats-card 
                title="Pending Repairs" 
                :value="$stats['pending_repairs']" 
                icon="wrench-screwdriver"
                color="yellow"
            />
            <x-stats-card 
                title="Completed Repairs" 
                :value="$stats['completed_repairs']" 
                icon="check-circle"
                color="green"
            />
            <x-stats-card 
                title="Total Spent" 
                value="${{ number_format($stats['total_spent'], 2) }}" 
                icon="currency-dollar"
                color="emerald"
            />
        @endhasanyrole
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2">
            <x-card>
                <x-slot:header>
                    <div class="mx-2 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            @hasanyrole('super-admin|admin|manager|support|technician')
                                Recent Orders
                            @else
                                My Recent Orders
                            @endhasanyrole
                        </h3>
                        <x-button 
                            href="#" 
                            color="primary" 
                            size="sm"
                            outline
                            class="my-2"
                        >
                            View All
                        </x-button>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <x-icon 
                                        name="shopping-bag" 
                                        class="w-8 h-8 text-gray-600 dark:text-gray-400"
                                    />
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $order->console->name }} - {{ $order->issue_description }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Order #{{ $order->id }} • {{ $order->created_at->format('M d, Y') }}
                                        @hasanyrole('super-admin|admin|manager|support|technician')
                                            • {{ $order->user->name }}
                                        @endhasanyrole
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <x-badge :color="$this->getStatusColor($order->status)">
                                    {{ ucfirst($order->status) }}
                                </x-badge>
                                <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">
                                    ${{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <x-icon name="inbox" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                            <p class="text-gray-600 dark:text-gray-400">No orders found</p>
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>

        {{-- Quick Actions & Notifications --}}
        <div class="space-y-6">
            {{-- Quick Actions --}}
            <x-card>
                <x-slot:header>
                    <h3 class="mx-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Quick Actions
                    </h3>
                </x-slot:header>

                <div class="space-y-3">
                    @hasanyrole('super-admin|admin|manager|support|technician')
                        <x-button href="#" color="primary" class="w-full" icon="clock">
                            View Pending Orders
                        </x-button>
                        <x-button href="{{ route('users.index') }}" color="secondary" class="w-full" icon="users">
                            Manage Customers
                        </x-button>
                        <x-button href="{{ route('adjustments.index') }}" color="slate" class="w-full" icon="cube">
                            Check Inventory
                        </x-button>
                        <x-button href="#" color="emerald" class="w-full" icon="chart-bar">
                            View Reports
                        </x-button>
                    @else
                        <x-button href="#" color="primary" class="w-full" icon="plus">
                            Request Repair
                        </x-button>
                        <x-button href="#" color="secondary" class="w-full" icon="list-bullet">
                            View All Orders
                        </x-button>
                        <x-button href="#" color="slate" class="w-full" icon="user">
                            Edit Profile
                        </x-button>
                        <x-button href="#" color="amber" class="w-full" icon="chat-bubble-left-right">
                            Contact Support
                        </x-button>
                    @endhasanyrole
                </div>
            </x-card>

            {{-- Notifications --}}
            <x-card>
                <x-slot:header>
                    <h3 class="mx-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Notifications
                    </h3>
                </x-slot:header>

                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <x-icon name="bell" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                {{ $notification }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>

    {{-- Recent Activity (Admin Only) --}}
    @hasanyrole('super-admin|admin|manager|support|technician')
        <x-card>
            <x-slot:header>
                <h3 class="mx-2 text-lg font-semibold text-gray-900 dark:text-white">
                    Recent Activity
                </h3>
            </x-slot:header>

            <div class="space-y-4">
                {{-- This would typically come from an activity log --}}
                <div class="flex items-center space-x-4 p-3 border-l-4 border-green-400 bg-green-50 dark:bg-green-900/20">
                    <x-icon name="check-circle" class="w-5 h-5 text-green-600" />
                    <div>
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            Order #1234 marked as completed
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400">2 minutes ago</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4 p-3 border-l-4 border-blue-400 bg-blue-50 dark:bg-blue-900/20">
                    <x-icon name="plus-circle" class="w-5 h-5 text-blue-600" />
                    <div>
                        <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            New repair request received
                        </p>
                        <p class="text-xs text-blue-600 dark:text-blue-400">15 minutes ago</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4 p-3 border-l-4 border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20">
                    <x-icon name="exclamation-triangle" class="w-5 h-5 text-yellow-600" />
                    <div>
                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Low inventory alert: PS5 controllers
                        </p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-400">1 hour ago</p>
                    </div>
                </div>
            </div>
        </x-card>
    @endhasanyrole
</div>

@script
<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(() => {
        $wire.loadStats();
        $wire.loadRecentOrders();
        $wire.loadNotifications();
    }, 300000);
</script>
@endscript
</div>
