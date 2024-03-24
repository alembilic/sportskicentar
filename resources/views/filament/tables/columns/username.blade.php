@if($state->past_three_memberships_count != 3)
    {{ $state->full_name }}

    <x-filament::badge color="danger" class="inline-flex">
        {{ 3 - $state->past_three_memberships_count }}
    </x-filament::badge>
@else
    {{ $state->full_name }}
@endif
