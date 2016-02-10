@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getIndex')}}">{{$title}}</a>
    </li>
    <li>
        <a href="{{action('\Yadeshevle\Permissions\PermissionsController@getCreate')}}">Создать</a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-9 col-lg-8">
            <form action="{{action('\Yadeshevle\Permissions\PermissionsController@postStore')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="level" value="1">
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
                        <option value="others">Общее правило</option>
                        @foreach(app('modules') as $module_id => $module)
                            <option value="{{$module_id}}">{{$module['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="whom">Для какой группы предназначено данное правило</label>
                    <select id="whom" name="for_whom" class="form-control">
                        @foreach(config('lists.roles__for_whom') as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success btn-lg">Создать</button>
            </form>
        </div>
    </div>

@stop