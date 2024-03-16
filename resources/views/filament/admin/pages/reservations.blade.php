<x-filament-panels::page>

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

    @livewire(\App\Filament\Admin\Widgets\CalendarWidget::class, ['field' => $activeTab, 'duration' => $duration])
</x-filament-panels::page>
