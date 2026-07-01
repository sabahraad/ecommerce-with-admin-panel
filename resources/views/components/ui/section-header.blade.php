@props(['title', 'subtitle' => null, 'action' => null, 'actionHref' => null, 'actionText' => null])

<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-2 text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($action || ($actionHref && $actionText))
        <div>
            @if ($action)
                {{ $action }}
            @else
                <x-ui.button href="{{ $actionHref }}" variant="outline" size="md">
                    {{ $actionText }} <span aria-hidden="true">&rarr;</span>
                </x-ui.button>
            @endif
        </div>
    @endif
</div>
