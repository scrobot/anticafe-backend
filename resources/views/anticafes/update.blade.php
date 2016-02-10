@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">редактировать</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    <h1>Редактировать антикафе {{$anticafe->name}}</h1>

    <div class="row">
        <div class="col-md-12">
        {{ Form::model($anticafe, ['action' => ['AnticafeController@postUpdate', $anticafe->id], 'files' => true]) }}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Основные данные</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('name', "Фирменное Название")}}
                            {{Form::text('name', null, ["class" => "form-control"])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('city', "Город")}}
                            {{Form::text('city', null, ["class" => "form-control"])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('address', "Адрес")}}
                            {{Form::text('address', null, ["class" => "form-control"])}}
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

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Изображения</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <img src="{{$anticafe->logo ? "/images/anticafes/logos/".$anticafe->logo : "/images/no-image.png"}}" width="100" height="100">
                            </div>
                            {{Form::label('logo', "Логотип")}}
                            {{Form::file('logo', ["class" => "form-control"])}}
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <img src="{{$anticafe->cover ? "/images/anticafes/covers/".$anticafe->cover : "/images/no-image.png"}}" width="100" height="100">
                            </div>
                            {{Form::label('cover', "Обложка")}}
                            {{Form::file('cover', ["class" => "form-control"])}}
                        </div>

                        <div class="col-md-12">
                            <h4>Миниатюры</h4>
                            <p>Логотип</p>
                            @foreach(\Anticafe\Http\Models\ImageOption::all() as $option)
                                <img src="{{"/images/anticafes/logos/{$option->name}/{$option->name}_".$anticafe->logo}}">
                            @endforeach
                        </div>

                        <div class="col-md-12">
                            <h4>Миниатюры</h4>
                            <p>Ковер</p>
                            @foreach(\Anticafe\Http\Models\ImageOption::all() as $option)
                                <img src="{{"/images/anticafes/covers/{$option->name}/{$option->name}_".$anticafe->cover}}">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.edit')}}</button>
            </div>
        {{ Form::close() }}
        </div>
    </div>
@endsection
