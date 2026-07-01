@props(['product'])

@php
$fullStars = (int) floor($product->rating);
$hasHalf = $product->rating - $fullStars >= 0.5;

$gradients = [
    'from-pink-100 to-rose-100 text-pink-600',
    'from-cyan-100 to-blue-100 text-cyan-600',
    'from-purple-100 to-pink-100 text-purple-600',
    'from-orange-100 to-amber-100 text-orange-600',
    'from-emerald-100 to-teal-100 text-emerald-600',
    'from-indigo-100 to-blue-100 text-indigo-600',
];
$gradient = $gradients[$product->id % count($gradients)];
$initials = collect(explode(' ', $product->name))->take(2)->map(fn ($w) => strtoupper($w[0] ?? ''))->implode('');
@endphp

<a href="{{ route('products.show', $product) }}" class="group block bg-white rounded-lg border border-gray-100 hover:shadow-md transition duration-200">
    <div class="relative aspect-square bg-gray-50 overflow-hidden">
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br {{ $gradient }}">
                <span class="text-3xl font-black opacity-80">{{ $initials }}</span>
                <span class="text-[10px] font-semibold opacity-70 mt-1 uppercase tracking-wider">Cartup</span>
            </div>
        @endif

        @if ($product->free_delivery)
            <span class="absolute top-2 left-0 bg-cyan-500 text-white text-[10px] font-bold uppercase tracking-wide px-2 py-1 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                Free Delivery
            </span>
        @endif

        @if (!$product->isInStock())
            <span class="absolute inset-0 bg-white/70 flex items-center justify-center text-sm font-bold text-gray-700 uppercase tracking-wide">Out of Stock</span>
        @endif
    </div>

    <div class="p-2">
        <div class="flex items-center gap-1 mb-1.5 flex-wrap">
            @if ($product->fast_delivery)
                <span class="bg-pink-500 text-white text-[10px] font-black italic px-1.5 py-0.5 uppercase transform -skew-x-12">FAST</span>
            @endif
            @if ($product->verified)
                <span class="inline-flex items-center gap-0.5 text-[10px] font-semibold text-white bg-blue-700 px-1.5 py-0.5 rounded">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Verified
                </span>
            @endif
        </div>

        <h3 class="text-sm text-gray-700 line-clamp-2 h-10 mb-1.5 group-hover:text-pink-600 transition">{{ $product->name }}</h3>

        <div class="flex items-end gap-2 mb-1.5 flex-wrap">
            <span class="text-lg font-bold text-pink-600 leading-none">৳{{ number_format($product->price) }}</span>
            @if ($product->old_price)
                <span class="text-xs text-gray-400 line-through leading-none">৳{{ number_format($product->old_price) }}</span>
            @endif
            @if ($product->discount_percent)
                <span class="text-[10px] font-semibold text-pink-600 bg-pink-50 px-1.5 py-0.5 rounded leading-none">-{{ $product->discount_percent }}%</span>
            @endif
        </div>

        <div class="flex items-center gap-1.5 text-xs text-gray-500">
            <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $fullStars)
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @elseif ($hasHalf && $i === $fullStars + 1)
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20"><defs><linearGradient id="half{{ $product->id }}"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#e5e7eb"/></linearGradient></defs><path fill="url(#half{{ $product->id }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @else
                        <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endif
                @endfor
            </div>
            <span>{{ number_format($product->rating, 1) }}({{ $product->reviews_count }})</span>
        </div>
    </div>

    @if ($product->promo_text)
        <div class="px-2 pb-2">
            <div class="h-10 rounded overflow-hidden relative bg-gradient-to-r from-pink-500 via-pink-600 to-purple-600 text-white text-[10px] font-black uppercase flex items-center justify-center px-2 text-center leading-tight shadow-sm">
                <svg class="w-4 h-4 absolute left-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4 2 2 0 010 4zm14 0a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                {{ $product->promo_text }}
            </div>
        </div>
    @endif
</a>
