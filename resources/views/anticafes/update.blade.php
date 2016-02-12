@extends('layouts.app')

@section('css')
    <style>
        .grid {
            min-height: 800px;
        }
    </style>
@stop

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
        {{ Form::model($anticafe, ['action' => ['AnticafeController@postUpdate', $anticafe->id], 'files' => true]) }}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Основные данные</h2>
                    </div>
                    <div class="panel-body grid">
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
                            {{Form::textarea('metro', null, ["class" => "form-control", 'rows' => 4])}}
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

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Описание</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('description', "Описание")}}
                            {{Form::textarea('description', null, ["class" => "form-control"])}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Ссылки на соц.сети</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('vk', "Вконтакте")}}
                            {{Form::text('vk', null, ["class" => "form-control"])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('inst', "Instagram")}}
                            {{Form::text('inst', null, ["class" => "form-control"])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('fb', "Facebook")}}
                            {{Form::text('fb', null, ["class" => "form-control"])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('tw', "Twitter")}}
                            {{Form::text('tw', null, ["class" => "form-control"])}}
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

@section('js')
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'description' );
    </script>
@stop