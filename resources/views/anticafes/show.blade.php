@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link href="/css/bootstrap-image-gallery.min.css" rel="stylesheet">
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">Просмотр</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    <h1>Просмотр антикафе {{$anticafe->name}}</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Галерея</h2>
                </div>
                <div class="panel-body">
                    <div id="links">
                        @forelse($anticafe->images as $image)
                            <a href="{{$image->preferences['preview']}}" data-gallery="">
                                <img src="{{$image->preferences['100x100']}}">
                            </a>
                        @empty
                            <p>Изображений в галерее для антикафе {{$anticafe->name}} не найдено</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @if(count($anticafe->Liked))
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Список лайкнувших</h2>
                </div>
                <div class="panel-body">
                    <div id="likes">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Фамилия Имя</th>
                                    <th>Профиль</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anticafe->Liked as $client)
                                    <tr>
                                        <td>{{$client->first_name . " " . $client->last_name}}</td>
                                        <td><a href="{{action('\Anticafe\Http\Controllers\ClientsController@getShow', $client->id)}}" class="btn btn-primary">Просмотреть</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Основные данные</h2>
                    </div>
                    <div class="panel-body grid">
                        <div class="form-group">
                            {{Form::label('name', "Фирменное Название")}}:
                            <p>{{$anticafe->name}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('city', "Город")}}:
                            <p>{{$anticafe->city}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('address', "Адрес")}}:{{$anticafe->name}}
                            <p>{{$anticafe->address}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('metro', "Ближайшее метро")}}:
                            <p>{{$anticafe->metro}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('prices', "Цены")}}:
                            <p>{{$anticafe->prices}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('routine', "График работы")}}:
                            <p>{{$anticafe->routine}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('phone', "Номер телефона")}}:
                            <p>{{$anticafe->phone}}</p>
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
                            {{Form::label('description', "Описание")}}:
                            {!! $anticafe->description !!}
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
                            {{Form::label('vk', "Вконтакте")}}:
                            <p>{{$anticafe->vk}}</p>
                        </div>
                        <div class="form-group">
                            {{Form::label('Instagram', "Instagram")}}:
                            <p>{{$anticafe->inst}}</p>
                        </div>
                        <div class="form-group">
                            {{Form::label('fb', "Facebook")}}:
                            <p>{{$anticafe->fb}}</p>
                        </div>
                        <div class="form-group">
                            {{Form::label('tw', "Twitter")}}:
                            <p>{{$anticafe->tw}}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <a href="{{action('AnticafeController@getUpdate', $anticafe->id)}}" class="btn btn-lg btn-primary">{{trans('common.button.edit')}}</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="/js/bootstrap-image-gallery.min.js"></script>
    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop