@props(['hover' => false, 'padding' => 'normal'])

@php
$classes = 'bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden';
if ($hover) {
    $classes .= ' transition duration-300 hover:shadow-lg hover:-translate-y-0.5';
}

$paddings = [
    'none' => '',
    'sm' => ' p-4',
    'normal' => ' p-6',
    'lg' => ' p-8',
];
$classes .= $paddings[$padding] ?? $paddings['normal'];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
