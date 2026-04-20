<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Custom Studio Header --}}
        <div class="py-12 border-b border-gray-200 dark:border-gray-800">
            <h1 class="text-6xl font-serif tracking-tight text-gray-900 dark:text-white mb-4">
                Good Morning, <span class="italic text-gray-400">{{ auth()->user()->name }}</span>.
            </h1>
            <p class="text-xl text-gray-500 font-light max-w-2xl">
                Welcome to the Accaive Studio command center. Here is the latest pulse of your creative operations.
            </p>
        </div>

        {{-- Default Widget Grid --}}
        @if (method_exists($this, 'getWidgets'))
            <x-filament-widgets::widgets
                :widgets="$this->getWidgets()"
                :columns="$this->getColumns()"
            />
        @endif
    </div>
</x-filament-panels::page>
