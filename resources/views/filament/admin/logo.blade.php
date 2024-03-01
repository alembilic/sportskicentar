@if(SUBDOMAIN)
    @if(auth()->user())
        <img src="{{ asset('storage/' . cache()->get('club.' . SUBDOMAIN)['logo']) }}"
             alt="{{ cache()->get('club.' . SUBDOMAIN)['name'] }}"
             class="logo-image"/>
        <div class="m-auto ml-3 flex text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white">
            {{ cache()->get('club.' . SUBDOMAIN)['name'] }}
        </div>
    @else
        <img src="{{ asset('storage/' . cache()->get('club.' . SUBDOMAIN)['logo']) }}"
             alt="{{ cache()->get('club.' . SUBDOMAIN)['name'] }}"
             class="logo-image-login"/>
    @endif
@else
    @if(auth()->user())
        <img src="{{ asset('storage/' . cache()->get('club.' . auth()->user()->club_id)['logo']) }}"
             alt="{{ cache()->get('club.' . auth()->user()->club_id)['name'] }}"
             class="logo-image"/>
        <div class="m-auto ml-3 flex text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white">
            {{ cache()->get('club.' . auth()->user()->club_id)['name'] }}
        </div>
    @elseif(cache()->get('club.' . 1))
        <img src="{{ asset('storage/' . cache()->get('club.' . 1)['logo']) }}"
             alt="{{ cache()->get('club.' . 1)['name'] }}"
             class="logo-image-login"/>
    @endif
@endif
