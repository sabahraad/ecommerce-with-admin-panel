<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">

        <x-ui.seo-meta
            :title="$metaTitle ?? null"
            :description="$metaDescription ?? null"
            :canonical="$metaCanonical ?? null"
            :og-image="$metaOgImage ?? null"
            :og-type="$metaOgType ?? 'website'"
            :noindex="$metaNoindex ?? false"
        />

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
        <a href="#main-content" class="sr-only-focusable">Skip to main content</a>

        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
                <x-flash-messages />
            </div>

            <!-- Page Content -->
            <main id="main-content" class="flex-1">
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <x-ui.toast />
    </body>
</html>
