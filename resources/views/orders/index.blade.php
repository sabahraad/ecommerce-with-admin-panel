<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('My Orders') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track and manage your purchases</p>
            </div>
            <x-ui.button href="{{ route('products.index') }}" variant="primary">Shop More</x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <x-ui.container>
            @if ($orders->isEmpty())
                <x-ui.empty-state
                    title="No orders yet"
                    description="Start shopping to place your first order."
                    action-href="{{ route('products.index') }}"
                    action-text="Browse Products"
                >
                    <x-slot:icon>
                        <svg class="h-12 w-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </x-slot:icon>
                </x-ui.empty-state>
            @else
                <x-ui.card padding="none" class="animate-fade-in">
                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                            <thead class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order #</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900 dark:text-white">${{ number_format($order->total, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-ui.badge :variant="$order->status === 'cancelled' ? 'danger' : ($order->status === 'pending' ? 'warning' : 'success')">
                                                {{ ucfirst($order->status) }}
                                            </x-ui.badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-ui.badge :variant="$order->payment_status === 'paid' ? 'success' : 'warning'">
                                                {{ $order->payment_method === 'cod' ? 'COD' : 'Stripe' }} — {{ ucfirst($order->payment_status) }}
                                            </x-ui.badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <x-ui.button href="{{ route('orders.show', $order) }}" variant="ghost" size="sm">
                                                View <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </x-ui.button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($orders as $order)
                            <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">#{{ $order->id }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <x-ui.price :amount="$order->total" size="md" />
                                </div>
                                <div class="flex flex-wrap items-center gap-2 mb-4">
                                    <x-ui.badge :variant="$order->status === 'cancelled' ? 'danger' : ($order->status === 'pending' ? 'warning' : 'success')">
                                        {{ ucfirst($order->status) }}
                                    </x-ui.badge>
                                    <x-ui.badge :variant="$order->payment_status === 'paid' ? 'success' : 'warning'">
                                        {{ $order->payment_method === 'cod' ? 'COD' : 'Stripe' }} — {{ ucfirst($order->payment_status) }}
                                    </x-ui.badge>
                                </div>
                                <x-ui.button href="{{ route('orders.show', $order) }}" variant="secondary" class="w-full">View Order</x-ui.button>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                        <x-ui.pagination :paginator="$orders" />
                    </div>
                </x-ui.card>
            @endif
        </x-ui.container>
    </div>
</x-app-layout>
