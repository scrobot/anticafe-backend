@extends('backend::admin_master')

@section('breadcrumbs')
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getIndex')}}">{{$title}}</a>
    </li>
    <li>
        <a href="{{action('\Yadeshevle\Roles\RoleController@getCreate')}}">Набор правил для роли {{$role->name}}</a>
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
                    <h1>Набор правил для роли {{$role->name}}</h1>
                    <form action="{{action('\Yadeshevle\Roles\RoleController@postAttachWithRole', $role->id)}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @foreach(app('modules') as $module)
                            <h3>{{$module['name']}}</h3>
                            <div class="form-group">
                                @foreach($permissions as $perm)
                                    @if($module['name'] == $perm->module['name'])
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="permissions[{{$perm->id}}]" value="{{$perm->id}}" {{$role->permissions->contains($perm->id) ? "checked" : ''}}> {{$perm->name}}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <hr />
                        @endforeach
                        <h3>Прочее</h3>
                        <div class="form-group">
                            @foreach($permissions as $perm)
                                @if(is_null($perm->module))
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permissions[{{$perm->id}}]" value="{{$perm->id}}" {{$role->permissions->contains($perm->id) ? "checked" : ''}}> {{$perm->name}}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <button class="btn btn-success btn-lg">Связать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop