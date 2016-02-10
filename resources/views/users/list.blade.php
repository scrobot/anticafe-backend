@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('actions_menu')
    @include('users.actions_menu')
@stop

@section('content')
    <h1>{{$title}}</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>E-mail</th>
            <th>Логин</th>
            <th>Уровень доступа</th>
            <th>В бане</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->level > 0 ? "Обычный" : "Суперадмин"}}</td>
                    <td>{{$user->blocked ? "Да" : "Нет"}}</td>
                    <td>
                        @unless($user->level < 1)
                            {{--@if(can(['staff.user.edit', ['staff.user.self_edit', $user, \Auth::user()]], 'or'))--}}
                                <a href="{{action('UsersController@getEdit', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                            {{--@endif
                            @if(can('staff.user.block'))--}}
                                @if($user->blocked)
                                    <a href="{{action('UsersController@getUnblock', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.unblock')}}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon glyphicon-off"></span></a>
                                @else
                                    <a href="{{action('UsersController@getBlock', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.block')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon glyphicon-off"></span></a>
                                @endif
                            {{--@endif
                            @if(can('staff.user.delete') && !$user->isMe($user, \Auth::user()))--}}
                                <a href="{{action('UsersController@getDestroy', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                            {{--@endif--}}
                        @endunless
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Юзеро'в в базе не найдено</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {!! $users->links() !!}
@endsection
