@extends('layouts.app')

@section('css')
    <style>
        table tr {
            height: 50px;
        }

        table tr td {
            vertical-align: middle;
        }

        /* Cначала обозначаем стили для IE8 и более старых версий
т.е. здесь мы немного облагораживаем стандартный чекбокс. */
        .checkbox {
            vertical-align: top;
            margin: 0 3px 0 0;
            height: 30px;
            z-index: 10;
            width: 200px;
        }
        /* Это для всех браузеров, кроме совсем старых, которые не поддерживают
        селекторы с плюсом. Показываем, что label кликабелен. */
        .checkbox + label {
            cursor: pointer;
        }

        /* Далее идет оформление чекбокса в современных браузерах, а также IE9 и выше.
        Благодаря тому, что старые браузеры не поддерживают селекторы :not и :checked,
        в них все нижеследующие стили не сработают. */

        /* Прячем оригинальный чекбокс. */
        .checkbox:not(checked) {
            position: absolute;
            opacity: 0;
        }
        .checkbox:not(checked) + label {
            position: relative; /* будем позиционировать псевдочекбокс относительно label */
            padding: 0 0 0 60px; /* оставляем слева от label место под псевдочекбокс */
        }
        /* Оформление первой части чекбокса в выключенном состоянии (фон). */
        .checkbox:not(checked) + label:before {
            content: '';
            position: absolute;
            top: -4px;
            left: 0;
            width: 50px;
            height: 26px;
            border-radius: 13px;
            background: #CDD1DA;
            box-shadow: inset 0 2px 3px rgba(0,0,0,.2);
        }
        /* Оформление второй части чекбокса в выключенном состоянии (переключатель). */
        .checkbox:not(checked) + label:after {
            content: '';
            position: absolute;
            top: -2px;
            left: 2px;
            width: 22px;
            height: 22px;
            border-radius: 10px;
            background: #FFF;
            box-shadow: 0 2px 5px rgba(0,0,0,.3);
            transition: all .2s; /* анимация, чтобы чекбокс переключался плавно */
        }
        /* Меняем фон чекбокса, когда он включен. */
        .checkbox:checked + label:before {
            background: #9FD468;
        }
        /* Сдвигаем переключатель чекбокса, когда он включен. */
        .checkbox:checked + label:after {
            left: 26px;
        }
        /* Показываем получение фокуса. */
        .checkbox:focus + label:before {
            box-shadow: 0 0 0 3px rgba(255,255,0,.5);
        }
    </style>
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('users')}}">{{$title}}</a></li>
    <li class="active">Создать</li>
@stop

@section('actions_menu')
    @include('users.actions_menu')
@stop

@section('content')
    <h1>Создать нового пользовтеля</h1>

    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{action('UsersController@postCreate')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {{Form::label('username', "Логин")}}
                    {{Form::text('username', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('name', "ФИО")}}
                    {{Form::text('name', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('phone', "Телефон")}}
                    {{Form::text('phone', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('email', "E-mail")}}
                    {{Form::email('email', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('password', "Пароль")}}
                    {{Form::password('password', ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('password_confirmation', "Подтверждение пароля")}}
                    {{Form::password('password_confirmation', ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    <label>Роль</label>
                    <select name="roles[]" class="form-control">
                        <option>Нет роли</option>
                        @foreach(\Helpers\Roles\Role::all() as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Антикафе и события</h2>
                    </div>
                    <div class="panel-body">
                        <button id="check-all" class="btn btn-success btn-lg" type="button">Выбрать все</button>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Тип</th>
                                <th>Привязать</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($anticafes as $anticafe)
                                <tr>
                                    <td>{{$anticafe->name}}</td>
                                    <td>{{config("types.select.{$anticafe->type}")}}</td>
                                    <td class="relative">
                                        <input name="anticafes[]" type="checkbox" value="{{$anticafe->id}}" class="checkbox">
                                        <label for="checkbox"></label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">В базе данных нет антикафе</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.create')}}</button>
            </form>
        </div>
    </div>
@endsection

@section("js")
    <script type="text/javascript">
        $(document).ready(function(){

            $('#check-all').click(function(){
                $(this).toggleClass('checked')

                var checked;

                if($(this).hasClass('checked')) {
                    $(this).text('Cнять все')
                    checked = true;
                } else {
                    $(this).text('Выбрать все')
                    checked = false
                }

                $('.checkbox').each(function(){
                    $(this).prop('checked', checked)
                })

            })

        })
    </script>
@stop