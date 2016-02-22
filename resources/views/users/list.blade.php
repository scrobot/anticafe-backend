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
            <th>Логин</th>
            <th>E-mail</th>
            <th>Уровень доступа</th>
            <th>Менеджер</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><a href="{{action('UsersController@getEdit', $user->id)}}">{{$user->username}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->level == 0 ? "Суперадмин" : $user->role()}}</td>
                    <td>
                        @forelse($user->Entities as $entity)
                            {{$entity->name}},
                        @empty
                            Не закреплено ни одного кафе или события
                        @endforelse
                    </td>
                    <td>
                        @unless($user->level < 1)
                            {{--@if(can(['staff.user.edit', ['staff.user.self_edit', $user, \Auth::user()]], 'or'))--}}
                                <a href="{{action('UsersController@getEdit', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
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
