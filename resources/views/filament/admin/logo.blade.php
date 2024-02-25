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
@endif
