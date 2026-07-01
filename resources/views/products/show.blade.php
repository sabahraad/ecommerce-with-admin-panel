<x-storefront-layout>
    <x-slot name="title">{{ $product->name }} | Cartup</x-slot>

    <div class="py-6">
        <x-ui.container>
            <x-ui.breadcrumb class="mb-4" :items="[
                ['label' => 'Products', 'href' => route('products.index')],
                ['label' => $product->category->name, 'href' => route('products.index', ['category' => $product->category_id])],
                ['label' => $product->name],
            ]" />

            <x-ui.card padding="none">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <!-- Image -->
                    <div class="h-96 lg:h-auto min-h-[28rem] bg-gray-50 flex items-center justify-center p-8">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain rounded-2xl shadow-lg">
                        @else
                            <div class="text-center">
                                <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="block mt-2 text-gray-400">No Image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="p-6 lg:p-10 flex flex-col">
                        <div class="flex items-center gap-3 mb-3 flex-wrap">
                            <x-ui.badge variant="primary">{{ $product->category->name }}</x-ui.badge>
                            @if ($product->verified)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-white bg-blue-700 px-2 py-1 rounded">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Verified
                                </span>
                            @endif
                            <x-ui.stock-badge :stock="$product->stock" />
                        </div>

                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>

                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex text-yellow-400">
                                @php
                                    $fullStars = (int) floor($product->rating);
                                    $hasHalf = $product->rating - $fullStars >= 0.5;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $fullStars)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @elseif ($hasHalf && $i === $fullStars + 1)
                                        <svg class="w-4 h-4" viewBox="0 0 20 20"><defs><linearGradient id="half{{ $product->id }}"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#e5e7eb"/></linearGradient></defs><path fill="url(#half{{ $product->id }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">{{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} reviews)</span>
                        </div>

                        <div class="flex items-end gap-3 mb-6">
                            <span class="text-3xl font-bold text-pink-600">৳{{ number_format($product->price) }}</span>
                            @if ($product->old_price)
                                <span class="text-lg text-gray-400 line-through">৳{{ number_format($product->old_price) }}</span>
                            @endif
                            @if ($product->discount_percent)
                                <span class="text-sm font-bold text-white bg-pink-500 px-2 py-1 rounded">-{{ $product->discount_percent }}%</span>
                            @endif
                        </div>

                        <div class="prose max-w-none mb-6">
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        <x-ui.card class="mb-6" padding="sm">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Free shipping
                                </div>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Secure checkout
                                </div>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    Cash on delivery
                                </div>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Easy returns
                                </div>
                            </div>
                        </x-ui.card>

                        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-auto">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-4 items-end">
                                <div>
                                    <x-ui.label for="quantity">Quantity</x-ui.label>
                                    <x-ui.quantity-stepper id="quantity" name="quantity" :value="1" :min="1" :max="$product->stock" class="mt-1" />
                                </div>
                                <x-ui.button type="submit" variant="primary" size="lg" class="flex-1" :disabled="!$product->isInStock()">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    {{ $product->isInStock() ? 'Add to Cart' : 'Out of Stock' }}
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            </x-ui.card>

            <!-- Structured Data -->
            <x-ui.json-ld :data="[
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->name,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'description' => Str::limit(strip_tags($product->description), 5000),
                'sku' => (string) $product->id,
                'brand' => [
                    '@type' => 'Brand',
                    'name' => config('app.name', 'Cartup'),
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'url' => route('products.show', $product),
                    'priceCurrency' => 'BDT',
                    'price' => number_format($product->price, 2),
                    'availability' => $product->isInStock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'itemCondition' => 'https://schema.org/NewCondition',
                ],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => (string) $product->rating,
                    'reviewCount' => (string) $product->reviews_count,
                ],
            ]" />

            <!-- Related Products -->
            @php
                $related = \App\Models\Product::with('category')
                    ->where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->where('is_active', true)
                    ->take(6)
                    ->get();
            @endphp
            @if ($related->isNotEmpty())
                <div class="mt-12">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">You may also like</h2>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                        @foreach ($related as $product)
                            <x-ui.product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif
        </x-ui.container>
    </div>
</x-storefront-layout>
