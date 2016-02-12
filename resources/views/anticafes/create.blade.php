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
        <div class="col-md-12">
            {{ Form::open(['action' => ['AnticafeController@postCreate']]) }}
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

                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.create')}}</button>
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

