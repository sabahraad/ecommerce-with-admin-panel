<x-storefront-layout>
    <x-slot name="title">Checkout | Cartup</x-slot>

    <div class="py-8">
        <x-ui.container>
            <!-- Progress -->
            <div class="max-w-2xl mx-auto mb-8">
                <div class="flex items-center justify-between text-sm font-medium">
                    <div class="flex items-center gap-2 text-gray-500">
                        <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">1</span>
                        <span class="hidden sm:inline">Cart</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
                    <div class="flex items-center gap-2 text-pink-600">
                        <span class="w-8 h-8 rounded-full bg-pink-600 text-white flex items-center justify-center">2</span>
                        <span class="hidden sm:inline">Shipping</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
                    <div class="flex items-center gap-2 text-gray-500">
                        <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">3</span>
                        <span class="hidden sm:inline">Confirm</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                <!-- Shipping Form -->
                <x-ui.card class="lg:col-span-3" padding="lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Shipping Information</h3>

                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <x-ui.label for="shipping_name">Full Name</x-ui.label>
                                <x-ui.input id="shipping_name" type="text" name="shipping_name" :value="old('shipping_name', Auth::user()?->name)" required class="mt-1" />
                                <x-ui.error :messages="$errors->get('shipping_name')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-ui.label for="shipping_email">Email Address</x-ui.label>
                                <x-ui.input id="shipping_email" type="email" name="shipping_email" :value="old('shipping_email', Auth::user()?->email)" required class="mt-1" />
                                <x-ui.error :messages="$errors->get('shipping_email')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-ui.label for="shipping_phone">Phone Number</x-ui.label>
                                <x-ui.input id="shipping_phone" type="text" name="shipping_phone" :value="old('shipping_phone')" required class="mt-1" placeholder="01XXX-XXXXXX" />
                                <x-ui.error :messages="$errors->get('shipping_phone')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-ui.label for="shipping_address">Address</x-ui.label>
                                <x-ui.textarea id="shipping_address" name="shipping_address" required class="mt-1" rows="3">{{ old('shipping_address') }}</x-ui.textarea>
                                <x-ui.error :messages="$errors->get('shipping_address')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-ui.label for="shipping_city">City</x-ui.label>
                                <x-ui.input id="shipping_city" type="text" name="shipping_city" :value="old('shipping_city')" required class="mt-1" />
                                <x-ui.error :messages="$errors->get('shipping_city')" class="mt-2" />
                            </div>
                        </div>

                        @guest
                            <x-ui.card class="mt-8 bg-pink-50 border-pink-100" padding="normal">
                                <h4 class="font-semibold text-gray-900 mb-2">Create Your Account</h4>
                                <p class="text-sm text-gray-600 mb-4">We'll create an account for you so you can track your order. Already have an account? <a href="{{ route('login') }}" class="text-pink-600 font-medium hover:underline">Log in</a>.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <x-ui.label for="password">Password</x-ui.label>
                                        <x-ui.input id="password" type="password" name="password" required class="mt-1" autocomplete="new-password" />
                                        <x-ui.error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-ui.label for="password_confirmation">Confirm Password</x-ui.label>
                                        <x-ui.input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1" autocomplete="new-password" />
                                    </div>
                                </div>
                            </x-ui.card>
                        @endguest

                        <div class="mt-8">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Payment Method</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label id="cod-label" class="relative flex items-center p-4 border-2 border-pink-600 rounded-xl cursor-pointer bg-pink-50 transition">
                                    <input type="radio" name="payment_method" value="cod" id="payment_cod" class="h-4 w-4 text-pink-600 focus:ring-pink-500" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                    <div class="ml-3">
                                        <span class="block font-semibold text-gray-900">Cash on Delivery</span>
                                        <span class="block text-xs text-gray-500">Pay when you receive</span>
                                    </div>
                                </label>
                                @if ($stripeEnabled)
                                    <label id="stripe-label" class="relative flex items-center p-4 border border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                                        <input type="radio" name="payment_method" value="stripe" id="payment_stripe" class="h-4 w-4 text-pink-600 focus:ring-pink-500" {{ old('payment_method') === 'stripe' ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="block font-semibold text-gray-900">Credit / Debit Card</span>
                                            <span class="block text-xs text-gray-500">Secure Stripe checkout</span>
                                        </div>
                                    </label>
                                @endif
                            </div>
                            <x-ui.error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <x-ui.button type="submit" variant="primary" size="lg" id="checkout-button" class="w-full mt-8">
                            Place Order — ৳{{ number_format($total) }}
                        </x-ui.button>

                        <p id="checkout-note" class="mt-4 text-center text-sm text-gray-500">
                            You will pay when your order is delivered.
                        </p>

                        <script>
                            (function () {
                                const cod = document.getElementById('payment_cod');
                                const stripe = document.getElementById('payment_stripe');
                                const button = document.getElementById('checkout-button');
                                const note = document.getElementById('checkout-note');

                                function updateUI(selected) {
                                    const codLabel = document.getElementById('cod-label');
                                    const stripeLabel = document.getElementById('stripe-label');

                                    const active = 'border-pink-600 bg-pink-50';
                                    const inactive = 'border-gray-300 hover:bg-gray-50';

                                    if (codLabel) {
                                        codLabel.className = codLabel.className.replace(active, '').replace(inactive, '') + (selected === 'cod' ? ' ' + active : ' ' + inactive);
                                    }
                                    if (stripeLabel) {
                                        stripeLabel.className = stripeLabel.className.replace(active, '').replace(inactive, '') + (selected === 'stripe' ? ' ' + active : ' ' + inactive);
                                    }

                                    if (selected === 'stripe') {
                                        button.textContent = 'Pay with Stripe — ৳{{ number_format($total) }}';
                                        note.textContent = 'You will be redirected to Stripe to complete your payment securely.';
                                    } else {
                                        button.textContent = 'Place Order — ৳{{ number_format($total) }}';
                                        note.textContent = 'You will pay when your order is delivered.';
                                    }
                                }

                                if (cod) cod.addEventListener('change', () => updateUI('cod'));
                                if (stripe) stripe.addEventListener('change', () => updateUI('stripe'));
                                updateUI('{{ old('payment_method', 'cod') }}');
                            })();
                        </script>
                    </form>
                </x-ui.card>

                <!-- Order Summary -->
                <x-ui.card class="lg:col-span-2 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Summary</h3>

                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2">
                        @foreach ($items as $item)
                            <div class="flex gap-4 items-center py-3 border-b border-gray-100 last:border-0">
                                <div class="h-16 w-16 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if ($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xs text-gray-400">No Image</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $item['product']->name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="font-semibold text-gray-900">৳{{ number_format($item['subtotal']) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>৳{{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-pink-600 font-semibold">Free</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t border-gray-200">
                            <span>Total</span>
                            <span>৳{{ number_format($total) }}</span>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </x-ui.container>
    </div>
</x-storefront-layout>
