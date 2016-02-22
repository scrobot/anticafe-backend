@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('content')
    <h2>Список правил</h2>
    <a href="{{action('\Helpers\Permissions\PermissionsController@getCreate')}}" class="btn btn-lg btn-link">Добавить <i class="fa fa-plus"></i></a>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>id</th>
                <th>Название правила</th>
                <th>Группа</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($permissions as $perm)
                <tr>
                    <td>{{$perm->id}}</td>
                    <td>{{$perm->name}}</td>
                    <td>{{$perm->group}}</td>
                    <td>
                        <a href="{{action('\Helpers\Permissions\PermissionsController@getEdit', $perm->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <a href="{{action('\Helpers\Permissions\PermissionsController@getDestroy', $perm->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
@endsection


@section('js')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop

