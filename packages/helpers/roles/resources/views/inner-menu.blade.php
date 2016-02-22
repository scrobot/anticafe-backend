<div class="btn-group">
    <span @lightAction('\Yadeshevle\Roles\RoleController@getIndex')>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getIndex')}}" class="btn bg-slate-700">Посмотреть все</a>
    </span>
</div>

<div class="btn-group">
    <span @lightAction('\Yadeshevle\Roles\RoleController@getCreate')>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getCreate')}}" class="btn bg-slate-700">Создать</a>
    </span>
</div>
