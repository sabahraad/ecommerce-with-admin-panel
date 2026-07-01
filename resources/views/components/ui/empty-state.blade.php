@props([
    'icon' => null,
    'title',
    'description' => null,
    'actionHref' => null,
    'actionText' => null,
])

<div class="text-center py-20 bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800 animate-fade-in">
    @if ($icon)
        <div class="w-24 h-24 mx-auto bg-emerald-50 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mb-6">
            {{ $icon }}
        </div>
    @endif

    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 text-gray-500 dark:text-gray-400 max-w-md mx-auto">{{ $description }}</p>
    @endif

    @if ($actionHref && $actionText)
        <x-ui.button href="{{ $actionHref }}" variant="primary" size="lg" class="mt-8">
            {{ $actionText }}
        </x-ui.button>
    @endif

    @if (isset($slot) && trim($slot) !== '')
        <div class="mt-6">
            {{ $slot }}
        </div>
    @endif
</div>
