<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            @if(can(['anticafe.see.all', 'anticafe.see.own'], null, null, "or"))
                <li><a href="{{action('AnticafeController@getIndex')}}">Все антикафе {{can('anticafe.see.all') ? "({$count['anticafes']})" : ""}}</a></li>
            @endif
            @if(can('anticafe.create'))
                <li><a href="{{action('AnticafeController@getCreate')}}">Создать антикафе</a></li>
            @endif
            @if(can(['events.see.all', 'events.see.own'], null, null, "or"))
                <li><a href="{{action('EventsController@getIndex')}}">Все события {{can('events.see.all') ? "({$count['events']})" : ""}}</a></li>
            @endif
            @if(can('events.create'))
                <li><a href="{{action('EventsController@getCreate')}}">Создать событие</a></li>
            @endif
            @if(can('trash'))
            <li><a href="{{action('AnticafeController@getTrash')}}">Корзина</a></li>
            @endif
        </ul>
    </div>
</div>