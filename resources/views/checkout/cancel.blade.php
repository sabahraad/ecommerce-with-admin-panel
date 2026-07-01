<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Payment Cancelled') }}</h2>
    </x-slot>

    <div class="py-12">
        <x-ui.container>
            <x-ui.card class="max-w-3xl mx-auto text-center p-8 sm:p-12 animate-fade-in-up">
                <div class="mx-auto w-20 h-20 bg-yellow-100 dark:bg-yellow-900/40 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">Payment was cancelled</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8">Your order <span class="font-semibold text-gray-900 dark:text-white">#{{ $order->id }}</span> has been cancelled. You can try again anytime.</p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <x-ui.button href="{{ route('cart.index') }}" variant="primary" size="lg">Return to Cart</x-ui.button>
                    <x-ui.button href="{{ route('products.index') }}" variant="secondary" size="lg">Continue Shopping</x-ui.button>
                </div>
            </x-ui.card>
        </x-ui.container>
    </div>
</x-app-layout>
