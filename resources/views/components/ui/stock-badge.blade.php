@props(['stock'])

@if ($stock > 0)
    <span class="inline-flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
        In Stock
    </span>
@else
    <span class="inline-flex items-center gap-1 text-xs font-medium text-red-600 dark:text-red-400">
        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
        Out of Stock
    </span>
@endif
