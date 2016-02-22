<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li @lightAction('\Helpers\Roles\RoleController@getIndex')><a href="{{action('\Helpers\Roles\RoleController@getIndex')}}">Посмотреть все</a></li>
            <li @lightAction('\Helpers\Roles\RoleController@getCreate')><a href="{{action('\Helpers\Roles\RoleController@getCreate')}}">Создать</a></li>
        </ul>
    </div>
</div>

