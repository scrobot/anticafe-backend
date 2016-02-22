@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('roles')}}">{{$title}}</a></li>
    <li class="active">
        <a href="{{action('\Helpers\Roles\RoleController@getCreate')}}">Создать роль</a>
    </li>
@stop

@section('actions_menu')
    @include('roles::inner-menu')
@stop

@section('content')
    <h1>Создать роль</h1>
    <form action="{{action('\Helpers\Roles\RoleController@postStore')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="name">Имя роли*</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success btn-lg">Создать</button>
    </form>
@endsection
