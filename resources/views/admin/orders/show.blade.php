<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order #:id', ['id' => $order->id]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($order->status === 'processing' || $order->status === 'completed')
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @elseif ($order->status === 'cancelled')
                                        bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @else
                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @endif
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($order->payment_status === 'paid')
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @else
                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @endif
                                ">
                                    {{ $order->payment_method === 'cod' ? 'COD' : 'Stripe' }}: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Order Status</h3>
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-4">
                                @csrf
                                @method('PUT')
                                <select name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <x-primary-button type="submit">Update Status</x-primary-button>
                            </form>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Payment Status</h3>
                            <form method="POST" action="{{ route('admin.orders.payment', $order) }}" class="flex gap-4">
                                @csrf
                                @method('PUT')
                                <select name="payment_status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                <x-primary-button type="submit">Update Payment</x-primary-button>
                            </form>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Order Items</h3>
                    <div class="space-y-4 mb-8">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <p class="font-medium text-gray-900 dark:text-white">${{ number_format($item->quantity * $item->price, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Shipping Information</h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $order->shipping_name }}</p>
                                <p>{{ $order->shipping_address }}</p>
                                <p>{{ $order->shipping_city }}</p>
                                <p>Phone: {{ $order->shipping_phone }}</p>
                                <p>Email: {{ $order->shipping_email }}</p>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">Customer</h4>
                            @if ($order->user)
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</p>
                                    <p>{{ $order->user->email }}</p>
                                </div>
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400">Guest checkout</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
