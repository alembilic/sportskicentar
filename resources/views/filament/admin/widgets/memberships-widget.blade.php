<x-filament-widgets::widget class="fi-wi-stats-overview">
    <div
        class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="grid gap-y-2">
            <div class="flex items-center gap-x-2">
                <span class="fi-wi-stats-overview-stat-label text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ $title }}
            </span>
            </div>

            <div
                class="fi-wi-stats-overview-stat-value text-2xl font-semibold tracking-tight text-gray-950 dark:text-white grid gap-2 md:grid-cols-3">
                <div class="flex items-end cursor-pointer" wire:click="$dispatch('set-filter', { subMonths: 2 })">
                    <span class="leading-7 mr-2 text-sm font-medium text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::now()->subMonths(2)->format('M') }}</span>
                    {{ $first . '/' . floor(($first/$total)*100) . '%' }}
                </div>
                <div class="flex items-end cursor-pointer" wire:click="$dispatch('set-filter', { subMonths: 1 })">
                    <span class="leading-7 mr-2 text-sm font-medium text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::now()->subMonths(1)->format('M') }}</span>
                    {{ $second . '/' . floor(($second/$total)*100) . '%' }}
                </div>
                <div class="flex items-end text-3xl cursor-pointer" wire:click="$dispatch('set-filter', { subMonths: 0 })">
                    <span class="leading-7 mr-2 text-sm font-medium text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::now()->format('M') }}</span>
                    {{ $third . '/' . floor(($third/$total)*100) . '%' }}
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>

