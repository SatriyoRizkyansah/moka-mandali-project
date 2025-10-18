<x-layouts.app.sidebar :title="$title ?? null">
    <main class="flex-1 p-6 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            {{ $slot }}
        </div>
    </main>
</x-layouts.app.sidebar>
