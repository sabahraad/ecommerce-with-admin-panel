@props([
    'src',
    'alt' => '',
    'class' => '',
    'containerClass' => '',
    'lazy' => true,
    'aspect' => null,
])

@php
$aspectClass = match ($aspect) {
    'square' => 'aspect-square',
    'video' => 'aspect-video',
    'product' => 'aspect-[4/3]',
    default => '',
};
@endphp

<div class="relative overflow-hidden bg-gray-50 dark:bg-gray-800 {{ $aspectClass }} {{ $containerClass }}">
    <img src="{{ $src }}"
         alt="{{ $alt }}"
         @if ($lazy) loading="lazy" @endif
         class="h-full w-full object-cover transition duration-500 {{ $class }}"
         onload="this.classList.remove('opacity-0'); this.classList.add('opacity-100');"
         onerror="this.classList.add('opacity-0');"
         style="opacity: 0;"
    >
</div>
