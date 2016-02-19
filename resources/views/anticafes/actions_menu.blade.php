<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li><a href="{{action('AnticafeController@getIndex')}}">Все антикафе({{$count['anticafes']}})</a></li>
            <li><a href="{{action('AnticafeController@getCreate')}}">Создать антикафе</a></li>
            <li><a href="{{action('EventsController@getIndex')}}">Все события({{$count['events']}})</a></li>
            <li><a href="{{action('EventsController@getCreate')}}">Создать событие</a></li>
            <li><a href="{{action('AnticafeController@getTrash')}}">Корзина</a></li>
        </ul>
    </div>
</div>