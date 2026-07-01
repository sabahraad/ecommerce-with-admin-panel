@if (session('success'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mb-4 rounded-xl border px-4 py-3 bg-green-50 border-green-200 text-green-800 dark:bg-green-900/30 dark:border-green-800 dark:text-green-100 flex items-start justify-between gap-4 shadow-sm"
         role="alert">
        <p class="text-sm font-medium">{{ session('success') }}</p>
        <button type="button" @click="show = false" class="text-green-600 hover:text-green-800 dark:text-green-300 dark:hover:text-green-100 text-xl leading-none" aria-label="Close">&times;</button>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mb-4 rounded-xl border px-4 py-3 bg-red-50 border-red-200 text-red-800 dark:bg-red-900/30 dark:border-red-800 dark:text-red-100 flex items-start justify-between gap-4 shadow-sm"
         role="alert">
        <p class="text-sm font-medium">{{ session('error') }}</p>
        <button type="button" @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-300 dark:hover:text-red-100 text-xl leading-none" aria-label="Close">&times;</button>
    </div>
@endif

@if (session('info'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mb-4 rounded-xl border px-4 py-3 bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-100 flex items-start justify-between gap-4 shadow-sm"
         role="alert">
        <p class="text-sm font-medium">{{ session('info') }}</p>
        <button type="button" @click="show = false" class="text-blue-600 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-100 text-xl leading-none" aria-label="Close">&times;</button>
    </div>
@endif

@if (session('warning'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mb-4 rounded-xl border px-4 py-3 bg-yellow-50 border-yellow-200 text-yellow-800 dark:bg-yellow-900/30 dark:border-yellow-800 dark:text-yellow-100 flex items-start justify-between gap-4 shadow-sm"
         role="alert">
        <p class="text-sm font-medium">{{ session('warning') }}</p>
        <button type="button" @click="show = false" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-300 dark:hover:text-yellow-100 text-xl leading-none" aria-label="Close">&times;</button>
    </div>
@endif
