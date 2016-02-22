@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getIndex')}}">{{$title}}</a>
    </li>
@stop

@section('inner-menu')
    @include('roles::inner-menu')
@stop

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="row">
        <div class="col-xs-12">
            <h2>Список правил</h2>
            <a href="{{action('\Yadeshevle\Roles\RoleController@getCreate')}}" class="btn btn-lg btn-link">Добавить <i class="fa fa-plus"></i></a>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Имя роли</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            <a href="{{action('\Yadeshevle\Roles\RoleController@getEdit', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Редактировать" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <a href="{{action('\Yadeshevle\Roles\RoleController@getPermissions', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Набор правил для роли" class="btn btn-primary"><i class="fa fa-paperclip"></i></a>
                            <a href="{{action('\Yadeshevle\Roles\RoleController@getUsers', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Набор пользователей для роли" class="btn btn-warning"><i class="fa fa-user"></i></a>
                            <a href="{{action('\Yadeshevle\Roles\RoleController@getStaffs', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Набор сотрудников для роли" class="btn btn-success"><i class="fa fa-user"></i></a>
                            @if($role->id > 2)
                                <a href="{{action('\Yadeshevle\Roles\RoleController@getDestroy', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Удалить" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4">Ролей в базе не найдено</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop