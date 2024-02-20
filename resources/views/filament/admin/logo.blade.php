<img src="{{ asset('storage/' . cache()->get('club.' . auth()->user()->id)['logo']) }}"
     alt=" {{ cache()->get('club.' . auth()->user()->id)['name'] }}"/>
<div class="mx-3 fi-logo flex text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white">
    {{ cache()->get('club.' . auth()->user()->id)['name'] }}
</div>
