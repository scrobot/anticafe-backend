@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getIndex')}}">{{$title}}</a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>Список правил</h2>
            <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getCreate')}}" class="btn btn-lg btn-link">Добавить <i class="fa fa-plus"></i></a>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Название правила</th>
                        <th>Модуль</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($permissions as $perm)
                    <tr>
                        <td>{{$perm->id}}</td>
                        <td>{{$perm->name}}</td>
                        <td>{{is_null($perm->module) ? "Прочее" :$perm->module['name']}}</td>
                        <td>
                            <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getEdit', $perm->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getDestroy', $perm->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4">Правил в базе не найдено</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop