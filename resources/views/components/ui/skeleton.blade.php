@props(['variant' => 'text', 'lines' => 1, 'class' => ''])

@php
$classes = 'animate-pulse bg-gray-200 dark:bg-gray-800 rounded-md ' . $class;

$variants = [
    'text' => 'h-4 w-full',
    'heading' => 'h-6 w-2/3',
    'title' => 'h-8 w-1/2',
    'image' => 'h-48 w-full',
    'avatar' => 'h-12 w-12 rounded-full',
    'button' => 'h-10 w-32',
    'card' => 'h-80 w-full rounded-2xl',
];

$base = $variants[$variant] ?? $variants['text'];
@endphp

@if ($variant === 'text' && $lines > 1)
    <div class="space-y-2 w-full">
        @for ($i = 0; $i < $lines; $i++)
            @php
                $width = $i === $lines - 1 ? 'w-3/4' : 'w-full';
            @endphp
            <div class="{{ $classes }} {{ $base }} {{ $width }}"></div>
        @endfor
    </div>
@else
    <div class="{{ $classes }} {{ $base }}"></div>
@endif
