@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getIndex')}}">{{$title}}</a>
    </li>
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getCreate')}}">Сотрудники роли {{$role->name}}</a>
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
                    <h1>Сотрудники роли {{$role->name}}</h1>
                    <form action="{{action('\Yadeshevle\Roles\RoleController@postAttachStaffs', $role->id)}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @foreach($staffs as $user)
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="users[{{$user->id}}]" value="{{$user->id}}" {{$role->staffs->contains($user->id) ? "checked" : ''}}> {{$user->login}}
                                    </label>
                                </div>
                            </div>
                            <hr />
                        @endforeach
                        <button class="btn btn-success btn-lg">Связать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop