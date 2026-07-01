<x-storefront-layout>
    <x-slot name="title">All Products | Cartup</x-slot>

    <div class="py-6">
        <x-ui.container>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">All Products</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} products available</p>
                </div>
            </div>

            <!-- Filters -->
            <x-ui.card class="mb-6" padding="sm">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <x-ui.label for="search" class="sr-only">Search products</x-ui.label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <x-ui.input id="search" type="text" name="search" :value="request('search')" placeholder="Search by name or description..." class="pl-10" />
                        </div>
                    </div>
                    <div class="w-full lg:w-64">
                        <x-ui.label for="category" class="sr-only">Category</x-ui.label>
                        <x-ui.select id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </x-ui.select>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button type="submit" variant="primary">Filter</x-ui.button>
                        @if (request()->hasAny(['search', 'category']))
                            <x-ui.button href="{{ route('products.index') }}" variant="secondary">Clear</x-ui.button>
                        @endif
                    </div>
                </form>
            </x-ui.card>

            <!-- Products Grid -->
            @if ($products->isEmpty())
                <x-ui.empty-state
                    :title="'No products found'"
                    :description="'Try adjusting your search or filter to find what you\'re looking for.'"
                    action-href="{{ route('products.index') }}"
                    action-text="Clear Filters"
                >
                    <x-slot:icon>
                        <svg class="h-12 w-12 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </x-slot:icon>
                </x-ui.empty-state>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 animate-fade-in">
                    @foreach ($products as $product)
                        <x-ui.product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-10">
                    <x-ui.pagination :paginator="$products" />
                </div>
            @endif
        </x-ui.container>
    </div>
</x-storefront-layout>
