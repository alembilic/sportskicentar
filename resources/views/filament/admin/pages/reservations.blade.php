<x-filament-panels::page>

    @if(count($fields) == 0)
        <div
            class="fi-ta-ctn divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
            <div
                class="fi-ta-content divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">
                <div class="fi-ta-empty-state px-6 py-12">
                    <div class="fi-ta-empty-state-content mx-auto grid max-w-lg justify-items-center text-center">
                        <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20">
                            <!--[if BLOCK]><![endif]-->
                            <svg class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                            </svg><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <h4 class="fi-ta-empty-state-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Nije pronađen nijedan teren.
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-filament::tabs label="Content tabs">
            @foreach($fields as $field)
                <x-filament::tabs.item
                    :active="$activeTab === $field->id"
                    :href="Request::url() . '?field=' . $field->id"
                    tag="a"
                >
                    {{ $field->name }}
                </x-filament::tabs.item>
            @endforeach
        </x-filament::tabs>

        @livewire(\App\Filament\Admin\Widgets\CalendarWidget::class, ['field' => $activeTab, 'duration' => $duration, 'fieldName' => $fieldName])
    @endif
</x-filament-panels::page>
