@php
$cart = session('cart', []);
$cartCount = collect($cart)->sum('quantity');
@endphp

<!-- Utility bar -->
<div class="bg-pink-100 text-pink-700 text-xs">
    <div class="container-app py-2 flex items-center justify-between">
        <div class="hidden sm:flex items-center gap-4">
            <span class="font-medium">Save More on App</span>
        </div>
        <div class="flex items-center gap-4 ml-auto">
            <a href="#" class="hover:text-pink-900 transition">Save More on App</a>
            <a href="#" class="hover:text-pink-900 transition">Sell on Cartup</a>
            <a href="#" class="hover:text-pink-900 transition">Help & Support</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-pink-900 transition">Account</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-pink-900 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-pink-900 transition">Sign up</a>
            @endauth
        </div>
    </div>
</div>

<!-- Main header -->
<header class="bg-white border-b border-gray-100 sticky top-0 z-40">
    <div class="container-app py-3">
        <div class="flex items-center gap-4 lg:gap-8">
            <!-- Logo -->
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 shrink-0">
                <svg class="w-8 h-8 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 01-8 0"></path>
                </svg>
                <span class="text-2xl font-extrabold tracking-tight">
                    <span class="text-cyan-500">cart</span><span class="text-pink-500">up</span>
                </span>
            </a>

            <!-- Categories button -->
            <button type="button" class="hidden md:inline-flex items-center gap-2 border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 hover:border-pink-300 hover:text-pink-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                Categories
            </button>

            <!-- Search -->
            <form method="GET" action="{{ route('products.index') }}" class="flex-1 max-w-3xl">
                <div class="flex rounded-lg overflow-hidden border-2 border-pink-100 focus-within:border-pink-400 transition">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-6 text-sm font-semibold transition">Search</button>
                </div>
            </form>

            <!-- Cart -->
            <a href="{{ route('cart.index') }}" class="relative shrink-0 p-2 text-gray-700 hover:text-pink-600 transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                @if ($cartCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-pink-500 text-[10px] font-bold text-white border-2 border-white">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>
</header>
