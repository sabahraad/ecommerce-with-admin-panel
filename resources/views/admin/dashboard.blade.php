<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Welcome to the admin panel!') }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @can('manage users')
                    <a href="{{ route('admin.users.index') }}" class="block p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Users</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Assign roles to users.</p>
                    </a>
                @endcan

                @can('manage roles')
                    <a href="{{ route('admin.roles.index') }}" class="block p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Roles</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Create roles and assign permissions.</p>
                    </a>
                @endcan

                @can('manage permissions')
                    <a href="{{ route('admin.permissions.index') }}" class="block p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Permissions</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Create and manage permissions.</p>
                    </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
