@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('roles')}}">{{$title}}</a></li>
    <li class="active">
        <a href="{{action('\Helpers\Roles\RoleController@getCreate')}}">Набор правил для роли {{$role->name}}</a>
    </li>
@stop

@section('actions_menu')
    @include('roles::inner-menu')
@stop

@section('content')
    <h1>Набор правил для роли {{$role->name}}</h1>
    <form action="{{action('\Helpers\Roles\RoleController@postAttachWithRole', $role->id)}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @foreach(config('modules') as $module)
            <h3>{{$module}}</h3>
            <div class="form-group">
                @foreach($permissions as $perm)
                    @if($module == $perm->group)
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
                @if($perm->group == "Общее правило")
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
@endsection
