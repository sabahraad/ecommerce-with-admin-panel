<footer class="bg-white border-t border-gray-100 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-2">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 text-2xl font-extrabold tracking-tight">
                    <svg class="w-8 h-8 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 01-8 0"></path>
                    </svg>
                    <span><span class="text-cyan-500">cart</span><span class="text-pink-500">up</span></span>
                </a>
                <p class="mt-4 text-gray-500 max-w-sm text-sm leading-relaxed">
                    Discover amazing products at great prices. Fast delivery, verified sellers, and cash on delivery.
                </p>
            </div>

            <div>
                <h4 class="font-semibold text-gray-900 mb-4">Shop</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('products.index') }}" class="hover:text-pink-600 transition">All Products</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-pink-600 transition">Shopping Cart</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="hover:text-pink-600 transition">My Orders</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-gray-900 mb-4">Account</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-pink-600 transition">Profile</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-pink-600 transition">Log in</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-pink-600 transition">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Cartup') }}. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Secure Checkout
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Fast Delivery
                </span>
            </div>
        </div>
    </div>
</footer>
