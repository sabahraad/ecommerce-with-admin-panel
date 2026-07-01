@props(['name' => 'quantity', 'value' => 1, 'min' => 1, 'max' => 99, 'formId' => null])

<div class="flex items-center border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden w-32">
    <button type="button"
            aria-label="Decrease quantity"
            class="px-3 py-2 bg-gray-50 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition"
            onclick="const q = document.getElementById('{{ $attributes->get('id', $name) }}'); q.value = Math.max({{ $min }}, parseInt(q.value || {{ $min }}) - 1); {{ $formId ? "document.getElementById('{$formId}').dispatchEvent(new Event('submit', { cancelable: true }));" : '' }}">
        −
    </button>
    <input type="number"
           name="{{ $name }}"
           id="{{ $attributes->get('id', $name) }}"
           value="{{ $value }}"
           min="{{ $min }}"
           max="{{ $max }}"
           class="w-full text-center border-0 rounded-none focus:ring-0 dark:bg-gray-900 dark:text-white"
           aria-label="Quantity">
    <button type="button"
            aria-label="Increase quantity"
            class="px-3 py-2 bg-gray-50 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition"
            onclick="const q = document.getElementById('{{ $attributes->get('id', $name) }}'); q.value = Math.min({{ $max }}, parseInt(q.value || {{ $min }}) + 1); {{ $formId ? "document.getElementById('{$formId}').dispatchEvent(new Event('submit', { cancelable: true }));" : '' }}">
        +
    </button>
</div>
