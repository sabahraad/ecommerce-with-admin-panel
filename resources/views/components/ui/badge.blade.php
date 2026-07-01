@props(['variant' => 'default'])

@php
$classes = 'inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full';

$variants = [
    'default' => 'bg-gray-100 text-gray-800',
    'primary' => 'bg-pink-100 text-pink-800',
    'success' => 'bg-green-100 text-green-800',
    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
    'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
];

$classes .= ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
