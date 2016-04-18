@extends('layouts.app')

@section('css')

    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <style>
        .tags ul {
            list-style: none;
        }
        .tags ul ul {
            padding-left: 20px;
        }
        .relative {
            position: relative;
        }
        .table tr td{
            vertical-align: middle;
        }

        .panel-body .form-group {
            padding: 5px 0;
        }

        .h74 {
            height: 74px !important;
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
            <div class="col-md-12">
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
                            {{Form::label('pincode', "Пинкод")}}
                            {{Form::number('pincode', null, ["class" => "form-control pincode"])}}
                            {{--{{Form::button("Сгенерировать", ["class" => "btn btn-default pin-gen"])}}--}}
                        </div>

                        <div class="row">
                            @if(can('edit.promo'))
                                <div class="col-md-4 col-md-offset-2">
                                    <div class="form-group">
                                        <label>{{Form::checkbox('promo', 1, null)}} Промо</label>
                                    </div>
                                </div>
                            @endif
                            @if(can('edit.booking.available'))
                            <div class="col-md-4 col-md-offset-2">
                                <div class="form-group">
                                    <label>{{Form::checkbox('booking_available', 1, null)}} Доступная бронь</label>
                                </div>
                            </div>
                            @endif
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info" role="alert">
                                    <p>Картинки автоматически преобразуются в jpeg с качеством 75%</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning" role="alert">
                                            <p><strong>Внимание: </strong>Максимальный размер загружаемого логотипа не должно превыщать 300х300 пикселей. В противном случае произойдет ошибка при валидации.<br/></p>
                                        </div>
                                    </div>
                                    @if($anticafe != null)
                                        <div class="col-md-12">
                                            <img src="{{$anticafe->logo ? "/images/anticafes/logos/100x100/100x100_".$anticafe->logo : "/images/no-image.png"}}" width="100" height="100">
                                        </div>
                                    @endif
                                    {{Form::label('logo', "Логотип")}}
                                    {{Form::file('logo', ["class" => "form-control"])}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning" role="alert">
                                            <p><strong>Внимание: </strong>Размер и соотношение сторон не важно. Данный cover автоматически преобразовывается в jpg высотой равной 400 пикселей и шириной, высчитанной по aspect ratio 1:1. <br/>
                                            Например: 800х600 -> 600х400</p>
                                        </div>
                                    </div>
                                    @if($anticafe != null)
                                        <div class="col-md-12">
                                            <img src="{{$anticafe->cover ? "/images/anticafes/covers/100x100/100x100_".$anticafe->cover : "/images/no-image.png"}}" width="100" height="100">
                                        </div>
                                    @endif
                                    {{Form::label('cover', "Обложка")}}
                                    {{Form::file('cover', ["class" => "form-control"])}}
                                </div>
                            </div>
                        </div>

                        <hr />

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
                            {{Form::textarea('metro', null, ["class" => "form-control", 'rows' => 3])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('prices', "Цены")}}
                            {{Form::textarea('prices', null, ["class" => "form-control h74"])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('routine', "График работы")}}
                            {{Form::text('routine', null, ["class" => "form-control"])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('phone', "Номер телефона")}}
                            {{Form::text('phone', null, ["class" => "form-control"])}}
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
                <div class="panel-body tags">
                    @foreach($tags as $tag)
                        <div class="col-md-2">
                            <div class="form-group">
                                <ul>
                                    <li>
                                        <label>{{ Form::checkbox('tags[]', $tag->id, $anticafe == null ? false : $anticafe->Tags->contains($tag->id), ['class' => 'group_tag']) }} {{$tag->name}}</label>
                                        <ul>
                                            @foreach($tag->Children as $child)
                                                <li><label>{{ Form::checkbox('tags[]', $child->id, $anticafe == null ? false : $anticafe->Tags->contains($child->id)) }} {{$child->name}}</label></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-3">
                        <div class="form-group">
                            <ul>
                                <li>
                                    <label><input class="group_tag"type="checkbox">Без категории</label>
                                    <ul>
                                        @foreach($alones as $alone)
                                            <li><label>{{ Form::checkbox('tags[]', $alone->id, $anticafe == null ? false : $anticafe->Tags->contains($alone->id)) }} {{$alone->name}}</label></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
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
        <div class="col-md-12">
            @if($anticafe != null && can(['anticafe.delete', 'anticafe.delete.own'], ['\Anticafe\Http\Models\User@isMyAnticafe', $anticafe->id], null, "or"))
                <a href="{{action('AnticafeController@getDelete', $anticafe->id)}}" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-trash"></span> {{trans('common.button.delete')}}</a>
            @endif
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

    @include("inc.tags_js")

@stop