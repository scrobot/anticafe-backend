@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getIndex')}}">{{$title}}</a>
    </li>
    <li>
        <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getEdit', $permission->id)}}">Создать</a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-9 col-lg-8">
            <form action="{{action('\Yadeshevle\Permissions\PermissionsController@postUpdate', $permission->id)}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="level" value="1">
                <div class="form-group">
                    <label for="name">Навзание правила*</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{$permission->name}}" required>
                </div>
                <div class="form-group">
                    <label for="slug">Ярлык*</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{$permission->id}}" required>
                </div>
                <div class="form-group">
                    <label for="module">Модуль</label>
                    <select id="module" name="module" class="form-control">
                        <option value="others" {{is_null($permission->module) ? 'selected' : ''}}>Общее правило</option>
                        @foreach(app('modules') as $module_id => $module)
                            <option value="{{$module_id}}" {{$module['name'] == $permission->module['name'] ? 'selected' : ''}}>{{$module['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="for_whom">Для какой группы предназначено данное правило</label>
                    <select id="for_whom" name="for_whom" class="form-control">
                        @foreach(config('lists.roles__for_whom') as $key => $value)
                            <option value="{{$key}}" {{$permission->for_whom != $key ?: "selected"}}>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success btn-lg">Редактировать</button>
            </form>
        </div>
    </div>

@stop