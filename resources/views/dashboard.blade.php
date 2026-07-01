<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="py-12">
        <x-ui.container>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <x-ui.card class="animate-fade-in-up" style="animation-delay: 0ms;">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ Auth::user()->orders()->count() }}</p>
                </x-ui.card>

                <x-ui.card class="animate-fade-in-up" style="animation-delay: 75ms;">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Completed Orders</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ Auth::user()->orders()->whereIn('status', ['completed','processing'])->count() }}</p>
                </x-ui.card>

                <x-ui.card class="animate-fade-in-up" style="animation-delay: 150ms;">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center text-yellow-600 dark:text-yellow-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1m15.356-2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format(Auth::user()->orders()->where('status', '!=', 'cancelled')->sum('total'), 2) }}</p>
                </x-ui.card>

                <x-ui.card class="animate-fade-in-up" style="animation-delay: 225ms;">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Role</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ Auth::user()->roles->pluck('name')->implode(', ') ?: 'Customer' }}</p>
                </x-ui.card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <x-ui.card class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('products.index') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition">
                            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Browse Products</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Discover new arrivals</p>
                            </div>
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition">
                            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">My Orders</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Track your purchases</p>
                            </div>
                        </a>
                        <a href="{{ route('cart.index') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition">
                            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Shopping Cart</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">View your cart</p>
                            </div>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 p-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition">
                            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Profile</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Manage your account</p>
                            </div>
                        </a>
                    </div>
                </x-ui.card>

                <x-ui.card>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->email }}</p>
                        </div>
                        @can('view admin dashboard')
                            <x-ui.button href="{{ route('admin.dashboard') }}" variant="primary" class="w-full mt-4">Admin Panel</x-ui.button>
                        @endcan
                    </div>
                </x-ui.card>
            </div>
        </x-ui.container>
    </div>
</x-app-layout>
