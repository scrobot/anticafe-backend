@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('users')}}">{{$title}}</a></li>
    <li class="active">редактировать</li>
@stop

@section('actions_menu')
    @include('users.actions_menu')
@stop

@section('content')
    <h1>Редактировать пользовтеля {{$user->username}}</h1>

    <div class="row">
        <div class="col-md-6">
            <form method="post" action="{{action('UsersController@postUpdate')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {{Form::label('username', "Логин")}}
                    {{Form::text('username', $user->username, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('email', "E-mail")}}
                    {{Form::email('email', $user->email, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('password', "Пароль")}}
                    {{Form::text('password', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('password_confirmation', "Подтверждение пароля")}}
                    {{Form::text('password_confirmation', null, ["class" => "form-control"])}}
                </div>

                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.edit')}}</button>
            </form>
        </div>
    </div>
@endsection
