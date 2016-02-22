@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{action('\Helpers\Permissions\PermissionsController@getIndex')}}">{{$title}}</a></li>
    <li class="active">Создать</li>
@stop

@section('content')
    <h2>Создать правило</h2>
    <form action="{{action('\Helpers\Permissions\PermissionsController@postStore')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="name">Навзание правила*</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="slug">Ярлык*</label>
            <input type="text" id="slug" name="slug" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="module">Модуль</label>
            <select id="module" name="module" class="form-control">
                <option value="Общее правило">Общее правило</option>
                @foreach(config('modules') as $module)
                    <option value="{{$module}}">{{$module}}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success btn-lg">Создать</button>
    </form>
@endsection