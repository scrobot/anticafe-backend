@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('actions_menu')
    @include('roles::inner-menu')
@stop

@section('content')
    <h1>{{$title}}</h1>
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
                    <a href="{{action('\Helpers\Roles\RoleController@getEdit', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Редактировать" class="btn btn-info"><i class="fa fa-edit"></i></a>
                    <a href="{{action('\Helpers\Roles\RoleController@getPermissions', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Набор правил для роли" class="btn btn-primary"><i class="fa fa-paperclip"></i></a>
                    <a href="{{action('\Helpers\Roles\RoleController@getUsers', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Набор пользователей для роли" class="btn btn-warning"><i class="fa fa-user"></i></a>
                    @unless(count($role->users))
                        <a href="{{action('\Helpers\Roles\RoleController@getDestroy', $role->id)}}" data-toggle="tooltip" data-placement="top" title="Удалить" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    @endunless
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Ролей в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection


@section('js')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
