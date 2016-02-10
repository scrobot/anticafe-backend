<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li><a href="{{action('UsersController@getIndex')}}">Все юзеры</a></li>
            <li><a href="{{action('UsersController@getCreate')}}">Создать юзера</a></li>
            {{--@if(can('permissions.staff.user.see_list'))<li @lightAction('\Pinerp\Staff\Controllers\UserController@getList')><a href="{{action('\Pinerp\Staff\Controllers\UserController@getList')}}">{{trans('staff::staff.all_staff')}}</a></li>@endif
            @if(can('permissions.staff.user.see_blocked'))<li @lightAction('\Pinerp\Staff\Controllers\UserController@getLaidOff')><a href="{{action('\Pinerp\Staff\Controllers\UserController@getLaidOff')}}">{{trans('staff::staff.template.users_restore')}}</a></li>@endif
            @if(can('permissions.staff.user.create'))<li @lightAction('\Pinerp\Staff\Controllers\UserController@getCreate')><a href="{{action('\Pinerp\Staff\Controllers\UserController@getCreate')}}">{{trans('staff::staff.create_staff')}}</a></li>@endif--}}
        </ul>
    </div>
</div>