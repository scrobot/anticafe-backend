@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">Создать</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    <h1>Создать новое антикафе</h1>

    <div class="row">
        <div class="col-md-6">
            <form method="post" action="{{action('AnticafeController@postCreate')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    {{Form::label('name', "Фирменное Название")}}
                    {{Form::text('name', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('city', "Город")}}
                    {{Form::text('city', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('metro', "Ближайшее метро")}}
                    {{Form::textarea('metro', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('prices', "Цены")}}
                    {{Form::textarea('prices', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('routine', "График работы")}}
                    {{Form::text('routine', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    {{Form::label('phone', "Номер телефона")}}
                    {{Form::text('phone', null, ["class" => "form-control"])}}
                </div>

                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.create')}}</button>
            </form>
        </div>
    </div>
@endsection
