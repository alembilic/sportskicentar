@php
    $clubTenant = null;
    $host = explode('.' . config('app.domain'), $_SERVER['HTTP_HOST']);

    if (str_contains($_SERVER['HTTP_HOST'], '.') and $host[0] and cache()->get('club.' . $host[0])) {
        $clubTenant = $host[0];
    }
@endphp

@if($clubTenant)
    @if(auth()->user())
        <img src="{{ asset('storage/' . cache()->get('club.' . $clubTenant)['logo']) }}"
             alt="{{ cache()->get('club.' . $clubTenant)['name'] }}"
             class="logo-image"/>
        <div class="m-auto ml-3 flex text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white">
            {{ cache()->get('club.' . $clubTenant)['name'] }}
        </div>
    @else
        <img src="{{ asset('storage/' . cache()->get('club.' . $clubTenant)['logo']) }}"
             alt="{{ cache()->get('club.' . $clubTenant)['name'] }}"
             class="logo-image-login"/>
    @endif
@endif
