<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-2">{{ __("You're logged in!") }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Roles:
                        <span class="font-semibold">
                            {{ Auth::user()->roles->pluck('name')->implode(', ') }}
                        </span>
                    </p>
                    @can('view admin dashboard')
                        <a href="{{ route('admin.dashboard') }}" class="inline-block mt-4 text-indigo-600 dark:text-indigo-400 hover:underline">
                            Go to Admin Panel &rarr;
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
