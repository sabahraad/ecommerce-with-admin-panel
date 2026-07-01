@props(['items' => []])

<nav aria-label="Breadcrumb" class="flex items-center text-sm text-gray-500 dark:text-gray-400">
    <ol class="flex items-center flex-wrap">
        @foreach ($items as $index => $item)
            <li class="flex items-center">
                @if ($index > 0)
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                @endif
                @if (!empty($item['href']))
                    <a href="{{ $item['href'] }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-900 dark:text-gray-200 font-medium truncate">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
