@extends('layouts.app')

@section('css')

    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <style>
        .relative {
            position: relative;
        }
        .table tr td{
            vertical-align: middle;
        }

        .grid {
            min-height: 900px;
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
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">Антикафе</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    @if($anticafe != null)
        <h1>Редактировать антикафе {{$anticafe->name}}</h1>
    @else
        <h1>Создать антикафе</h1>
    @endif

    <div class="row">
        <div class="col-md-12">
        {{ Form::model($anticafe, ['url' => $action, 'files' => true, 'class' => 'image-handler-binded-form']) }}
            {!! Form::hidden('type', 0) !!}
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
                        <div class="form-group">
                            <label>{{Form::checkbox('promo', 1, null)}} Промо</label>
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
                            @if($anticafe != null)
                            <div class="col-md-12">
                                <img src="{{$anticafe->logo ? "/images/anticafes/logos/100x100/100x100_".$anticafe->logo : "/images/no-image.png"}}" width="100" height="100">
                            </div>
                            @endif
                            {{Form::label('logo', "Логотип")}}
                            {{Form::file('logo', ["class" => "form-control"])}}
                        </div>

                        <div class="form-group">
                            @if($anticafe != null)
                            <div class="col-md-12">
                                <img src="{{$anticafe->cover ? "/images/anticafes/covers/100x100/100x100_".$anticafe->cover : "/images/no-image.png"}}" width="100" height="100">
                            </div>
                            @endif
                            {{Form::label('cover', "Обложка")}}
                            {{Form::file('cover', ["class" => "form-control"])}}
                        </div>

                        @if($anticafe != null)
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
                        @endif
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
                            {{Form::label('excerpt', "Краткое описание")}}
                            {{Form::textarea('excerpt', null, ["class" => "form-control"])}}
                        </div>
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Возможности</h2>
                    </div>
                    <div class="panel-body">
                        @foreach($tags as $tag)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ Form::checkbox('tags[]', $tag->id, $anticafe == null ? false : $anticafe->Tags->contains($tag->id)) }} {{$tag->name}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.save')}}</button>
            </div>
        {{ Form::close() }}
        </div>
        <div class="col-md-12">
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Галерея</h2>
                </div>
                <div class="panel-body">
                    {!! image_handler_widget("gallery", $anticafe) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/moment.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap/transition.js"></script>
    <script type="text/javascript" src="/js/bootstrap/collapse.js"></script>
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'excerpt' );
        CKEDITOR.replace( 'description' );

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

        $(function () {
            $('#start_at').datetimepicker({
                locale: 'ru'
            });
            $('#end_at').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                locale: 'ru'
            });
        });
    </script>
@stop