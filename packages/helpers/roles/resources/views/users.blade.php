@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('roles')}}">{{$title}}</a></li>
    <li class="active">
        <a href="{{action('\Helpers\Roles\RoleController@getCreate')}}">Пользователи роли {{$role->name}}</a>
    </li>
@stop

@section('actions_menu')
    @include('roles::inner-menu')
@stop

@section('content')
    <h1>Пользователи роли {{$role->name}}</h1>
    <form action="{{action('\Helpers\Roles\RoleController@postAttachUsers', $role->id)}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @foreach($users as $user)
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="users[{{$user->id}}]" value="{{$user->id}}" {{$role->users->contains($user->id) ? "checked" : ''}}> {{$user->username}}
                    </label>
                </div>
            </div>
            <hr />
        @endforeach
        <button class="btn btn-success btn-lg">Связать</button>
    </form>
@endsection


@section('js')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop