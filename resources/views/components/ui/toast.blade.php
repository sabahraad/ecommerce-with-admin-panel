@props([])

<div x-data="{
    toasts: [],
    add(message, type = 'success') {
        const id = Date.now() + Math.random();
        this.toasts.push({ id, message, type });
        setTimeout(() => this.remove(id), 5000);
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}"
     @toast.window="add($event.detail.message, $event.detail.type || 'success')"
     class="fixed bottom-4 right-4 z-[600] flex flex-col gap-3 w-full max-w-sm pointer-events-none"
     aria-live="polite"
     aria-atomic="true">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             :class="{
                'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/40 dark:border-green-800 dark:text-green-100': toast.type === 'success',
                'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/40 dark:border-red-800 dark:text-red-100': toast.type === 'error',
                'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/40 dark:border-blue-800 dark:text-blue-100': toast.type === 'info',
                'bg-yellow-50 border-yellow-200 text-yellow-800 dark:bg-yellow-900/40 dark:border-yellow-800 dark:text-yellow-100': toast.type === 'warning',
             }"
             class="pointer-events-auto rounded-xl border px-4 py-3 shadow-lg flex items-start justify-between gap-3">
            <p class="text-sm font-medium" x-text="toast.message"></p>
            <button type="button" @click="remove(toast.id)" class="text-current opacity-70 hover:opacity-100" aria-label="Close">
                &times;
            </button>
        </div>
    </template>
</div>
