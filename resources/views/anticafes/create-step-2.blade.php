@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">Создание антикафе. Шаг 2</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    <h1>Создание антикафе {{$anticafe->name}}. Шаг 2</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Галерея</h2>
                </div>
                <div class="panel-body">
                    {!! image_handler_widget("gallery", $anticafe) !!}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            {{ Form::model($anticafe, ['action' => ['AnticafeController@postUpdate', $anticafe->id, 2], 'files' => true]) }}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Изображения</h2>
                    </div>
                    <div class="panel-body grid">
                        <div class="form-group">
                            <div class="col-md-12">
                                <img src="{{$anticafe->logo ? "/images/anticafes/logos/100x100/100x100_".$anticafe->logo : "/images/no-image.png"}}" width="100" height="100">
                            </div>
                            {{Form::label('logo', "Логотип")}}
                            {{Form::file('logo', ["class" => "form-control"])}}
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <img src="{{$anticafe->cover ? "/images/anticafes/covers/100x100/100x100_".$anticafe->cover : "/images/no-image.png"}}" width="100" height="100">
                            </div>
                            {{Form::label('cover', "Обложка")}}
                            {{Form::file('cover', ["class" => "form-control"])}}
                        </div>

                        <div class="col-md-12">
                            <h4>Миниатюры</h4>
                            <h5>Логотип</h5>
                            @foreach(\Anticafe\Http\Models\ImageOption::all() as $option)
                                <div class="col-md-2">
                                    <img src="{{"/images/anticafes/logos/{$option->name}/{$option->name}_".$anticafe->logo}}" style="width: 100%; height: auto">
                                    <p>{{$option->name}}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-12">
                            <h5>Ковер</h5>
                            @foreach(\Anticafe\Http\Models\ImageOption::all() as $option)
                                <div class="col-md-2">
                                    <img src="{{"/images/anticafes/covers/{$option->name}/{$option->name}_".$anticafe->cover}}" style="width: 100%; height: auto">
                                    <p>{{$option->name}}</p>
                                </div>
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