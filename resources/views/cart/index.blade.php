<x-storefront-layout>
    <x-slot name="title">Shopping Cart | Cartup</x-slot>

    <div class="py-8">
        <x-ui.container>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Shopping Cart</h2>

            @if (empty($items))
                <x-ui.empty-state
                    title="Your cart is empty"
                    description="Looks like you haven't added anything yet. Browse our products and find something you love."
                    action-href="{{ route('products.index') }}"
                    action-text="Continue Shopping"
                >
                    <x-slot:icon>
                        <svg class="h-12 w-12 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </x-slot:icon>
                </x-ui.empty-state>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start animate-fade-in">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <x-ui.card padding="none">
                            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Cart Items ({{ count($items) }})</h3>
                                <form method="POST" action="{{ route('cart.clear') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 flex items-center gap-1 transition" onclick="return confirm('Clear your cart?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Clear Cart
                                    </button>
                                </form>
                            </div>

                            <div class="divide-y divide-gray-200">
                                @foreach ($items as $item)
                                    <div class="p-5 flex flex-col sm:flex-row gap-5">
                                        <a href="{{ route('products.show', $item['product']) }}" class="block h-32 w-32 bg-gray-50 rounded-xl flex-shrink-0 overflow-hidden">
                                            @if ($item['product']->image)
                                                <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                            @endif
                                        </a>
                                        <div class="flex-1 flex flex-col">
                                            <div class="flex justify-between items-start gap-4">
                                                <div>
                                                    <a href="{{ route('products.show', $item['product']) }}" class="text-lg font-semibold text-gray-900 hover:text-pink-600 transition">
                                                        {{ $item['product']->name }}
                                                    </a>
                                                    <p class="text-sm text-gray-500 mt-1">{{ $item['product']->category->name }}</p>
                                                </div>
                                                <x-ui.price :amount="$item['subtotal']" size="md" />
                                            </div>

                                            <div class="mt-auto pt-4 flex flex-wrap items-center justify-between gap-4">
                                                <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <x-ui.quantity-stepper :name="'quantity'" :value="$item['quantity']" :min="1" :max="$item['product']->stock" :id="'quantity_' . $item['product']->id" />
                                                    <x-ui.button type="submit" variant="secondary" size="sm">Update</x-ui.button>
                                                </form>

                                                <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 flex items-center gap-1 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-ui.card>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <x-ui.card class="sticky top-24">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Summary</h3>
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>৳{{ number_format($total) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="text-pink-600 font-semibold">Free</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4 flex justify-between text-xl font-bold text-gray-900">
                                    <span>Total</span>
                                    <span>৳{{ number_format($total) }}</span>
                                </div>
                            </div>

                            <x-ui.button href="{{ route('checkout.index') }}" variant="primary" size="lg" class="w-full">
                                Proceed to Checkout
                            </x-ui.button>
                            <x-ui.button href="{{ route('products.index') }}" variant="secondary" class="w-full mt-3">
                                Continue Shopping
                            </x-ui.button>

                            <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Secure checkout
                            </div>
                        </x-ui.card>
                    </div>
                </div>
            @endif
        </x-ui.container>
    </div>
</x-storefront-layout>
