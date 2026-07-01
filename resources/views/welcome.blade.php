<x-storefront-layout>
    <x-slot name="seo">
        <x-ui.seo-meta
            title="Cartup - Shop Groceries, Electronics & More"
            description="Discover amazing products at great prices. Fast delivery, verified sellers, and cash on delivery."
            og-type="website"
        />
    </x-slot>

    <!-- Hero promo banner -->
    <section class="bg-white border-b border-gray-100">
        <div class="container-app py-4">
            <div class="rounded-xl bg-gradient-to-r from-pink-500 via-pink-600 to-purple-600 text-white px-6 py-8 sm:py-10 text-center">
                <h1 class="text-2xl sm:text-3xl font-extrabold mb-2">Big Savings on Daily Essentials</h1>
                <p class="text-pink-100 text-sm sm:text-base">Free delivery • Verified products • Cash on delivery</p>
            </div>
        </div>
    </section>

    <!-- Products grid -->
    <section class="py-6">
        <div class="container-app">
            @php
                $products = \App\Models\Product::with('category')->where('is_active', true)->inRandomOrder()->take(24)->get();
            @endphp

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">Just For You</h2>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-pink-600 hover:text-pink-700">View All</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                @foreach ($products as $index => $product)
                    @if ($index === 6)
                        <div class="col-span-2 sm:col-span-3 md:col-span-4 lg:col-span-5 xl:col-span-6 py-2">
                            <div class="rounded-xl overflow-hidden bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-6 py-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide">Cartup Picks</p>
                                    <p class="text-lg font-extrabold">Top Deals</p>
                                </div>
                                <a href="{{ route('products.index') }}" class="bg-white text-cyan-600 text-sm font-bold px-4 py-2 rounded-lg hover:bg-gray-100 transition">Shop Now</a>
                            </div>
                        </div>
                    @endif
                    <x-ui.product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
</x-storefront-layout>
