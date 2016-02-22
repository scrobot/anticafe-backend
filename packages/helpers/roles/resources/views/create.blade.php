@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getIndex')}}">{{$title}}</a>
    </li>
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getCreate')}}">Создать</a>
    </li>
@stop

@section('inner-menu')
    @include('roles::inner-menu')
@stop

@section('content')
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-9 col-lg-8">
                    <form action="{{action('\Yadeshevle\Roles\RoleController@postStore')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">Имя роли*</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <button class="btn btn-success btn-lg">Создать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop