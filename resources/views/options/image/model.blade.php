@extends('layouts.app')

@section('css')
    <style>
        .anchor tr td{
            height: 25px;
            width: 25px;
            text-align: center;
            vertical-align: middle;
        }
    </style>
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('ioptions')}}">{{$title}}</a></li>
    <li class="active">Создать</li>
@stop

@section('actions_menu')
    @include('options.image.actions_menu')
@stop

@section('content')
    <h1>Опции изображений</h1>

    <div class="row">
        <div class="col-md-6">
            {{ Form::model($option, ['url' => $action]) }}
                <div class="form-group">
                    {{Form::label('name', "Имя")}}
                    {{Form::text('name', null, ["class" => "form-control"])}}
                </div>

                <div class="form-group">
                    <div class="form-inline">
                        {{Form::text('width', null, ["class" => "form-control", 'placeholder' => 'ширина'])}}
                        {{Form::text('height', null, ["class" => "form-control", 'placeholder' => 'высота'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label>Якорь обрезки изображения</label>
                    <table class="anchor">
                        <tr>
                            <td>{{Form::radio('anchor', 'top-left')}}</td>
                            <td>{{Form::radio('anchor', 'top')}}</td>
                            <td>{{Form::radio('anchor', 'top-right')}}</td>
                        </tr>
                        <tr>
                            <td>{{Form::radio('anchor', 'top')}}</td>
                            <td>{{Form::radio('anchor', 'center', true)}}</td>
                            <td>{{Form::radio('anchor', 'right')}}</td>
                        </tr>
                        <tr>
                            <td>{{Form::radio('anchor', 'bottom-left')}}</td>
                            <td>{{Form::radio('anchor', 'bottom')}}</td>
                            <td>{{Form::radio('anchor', 'bottom-right')}}</td>
                        </tr>
                    </table>
                </div>

                <div class="form-group">
                    {{Form::label('relative', "Относительная обрезка")}}
                    {{Form::checkbox('relative', 1)}}
                    <p class="small">Определить, что изменение размера будет происходить в относительном режиме. Это означает, что значения ширины или высоты будет добавлен или вычитается из текущего высоты изображения.</p>
                </div>

                <div class="form-group">
                    {{Form::label('bgcolor', "Изображение фона")}}
                    {{Form::text('bgcolor', null, ["class" => "form-control"])}}
                    <p class="small">Цвет фона для новых областей изображения. Цвет фона может быть принят в разных цветовых <a href="http://image.intervention.io/getting_started/formats">форматов</a>. Если это поле будет пустое, по умолчанию создастся #000000</p>
                </div>

                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.ok')}}</button>
            {{ Form::close() }}
        </div>
    </div>
@endsection
