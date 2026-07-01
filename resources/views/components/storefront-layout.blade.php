<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @isset($seo)
            {{ $seo }}
        @else
            <title>{{ $title ?? config('app.name', 'Cartup') }}</title>
        @endisset

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col">
            <x-storefront-header />

            <!-- Category strip -->
            @php
                $categoryStrip = \App\Models\Category::withCount('products')->take(8)->get();
            @endphp
            <div class="bg-white border-b border-gray-100">
                <div class="container-app py-2">
                    <div class="flex items-center gap-3 overflow-x-auto no-scrollbar">
                        @foreach ($categoryStrip as $category)
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="whitespace-nowrap px-4 py-1.5 rounded-full bg-gray-50 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <main class="flex-1">
                {{ $slot }}
            </main>

            <x-footer />
        </div>
    </body>
</html>
