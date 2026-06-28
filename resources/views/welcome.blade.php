<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-gray-900">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="relative flex justify-center items-center min-h-screen">
                <div class="max-w-7xl mx-auto p-6 lg:p-8">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            Welcome to {{ config('app.name', 'Our Store') }}
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                            Your one-stop ecommerce destination.
                        </p>

                        <div class="flex justify-center gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    Log in
                                </a>
                                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    Register
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
