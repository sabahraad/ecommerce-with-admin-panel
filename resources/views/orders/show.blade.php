<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Order #:id', ['id' => $order->id]) }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Placed on {{ $order->created_at->format('M d, Y') }}</p>
            </div>
            <x-ui.button href="{{ route('orders.index') }}" variant="ghost">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Orders
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <x-ui.container>
            <x-ui.card padding="none" class="max-w-5xl mx-auto">
                <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui.badge :variant="$order->status === 'cancelled' ? 'danger' : ($order->status === 'pending' ? 'warning' : 'success')">
                                {{ ucfirst($order->status) }}
                            </x-ui.badge>
                            <x-ui.badge :variant="$order->payment_status === 'paid' ? 'success' : 'warning'">
                                {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Stripe' }}: {{ ucfirst($order->payment_status) }}
                            </x-ui.badge>
                        </div>
                        <x-ui.price :amount="$order->total" size="xl" />
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Items</h3>
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($order->items as $item)
                            <div class="py-5 flex flex-col sm:flex-row gap-5">
                                <div class="h-24 w-24 bg-gray-50 dark:bg-gray-800 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if ($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xs text-gray-400">No Image</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $item->product->category->name }}</p>
                                        </div>
                                        <x-ui.price :amount="$item->quantity * $item->price" size="md" />
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-ui.card class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800/50" padding="normal">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Shipping Address
                            </h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $order->shipping_name }}</p>
                                <p>{{ $order->shipping_address }}</p>
                                <p>{{ $order->shipping_city }}</p>
                                <p>Phone: {{ $order->shipping_phone }}</p>
                                <p>Email: {{ $order->shipping_email }}</p>
                            </div>
                        </x-ui.card>

                        <x-ui.card class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800/50" padding="normal">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Order Summary
                            </h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($order->total, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Shipping</span>
                                    <span class="font-medium text-green-600 dark:text-green-400">Free</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-2 flex justify-between text-base font-semibold text-gray-900 dark:text-white">
                                    <span>Total</span>
                                    <span>${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </x-ui.card>
                    </div>
                </div>
            </x-ui.card>
        </x-ui.container>
    </div>
</x-app-layout>
