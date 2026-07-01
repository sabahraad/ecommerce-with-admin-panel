@props(['amount', 'currency' => '৳', 'size' => 'md'])

@php
$sizes = [
    'sm' => 'text-sm',
    'md' => 'text-lg',
    'lg' => 'text-2xl',
    'xl' => 'text-3xl',
];
@endphp

<span {{ $attributes->merge(['class' => 'font-bold text-gray-900 ' . ($sizes[$size] ?? $sizes['md'])]) }}>
    {{ $currency }}{{ number_format($amount, 0) }}
</span>
