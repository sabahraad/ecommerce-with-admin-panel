<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Order Confirmed') }}</h2>
    </x-slot>

    <div class="py-12">
        <x-ui.container>
            <x-ui.card class="max-w-3xl mx-auto text-center p-8 sm:p-12 animate-fade-in-up">
                <div class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Thank you for your order!</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Your order <span class="font-semibold text-gray-900 dark:text-white">#{{ $order->id }}</span> has been placed and is being processed.</p>

                <x-ui.card class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800/50 mb-8 text-left" padding="normal">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Order Details</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Order Total:</span>
                            <x-ui.price :amount="$order->total" size="sm" />
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Payment Method:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Stripe' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Payment Status:</span>
                            <span class="font-semibold capitalize {{ $order->payment_status === 'paid' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">{{ $order->payment_status }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Shipping To:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $order->shipping_name }}</span>
                        </div>
                    </div>
                </x-ui.card>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <x-ui.button href="{{ route('products.index') }}" variant="primary" size="lg">Continue Shopping</x-ui.button>
                    @auth
                        <x-ui.button href="{{ route('orders.show', $order) }}" variant="secondary" size="lg">View Order</x-ui.button>
                    @endauth
                </div>
            </x-ui.card>
        </x-ui.container>
    </div>
</x-app-layout>
