@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('clients')}}">{{$title}}</a></li>
    <li class="active">Просмотр клиента</li>
@stop

@section('content')
    <h1>Просмотр клиента {{$client->first_name . " " . $client->last_name}}</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Основные данные</h2>
                    </div>
                    <div class="panel-body grid">
                        <div class="form-group">
                            {{Form::label('fio', "Фамилия Имя")}}:
                            <p>{{$client->first_name . " " . $client->last_name}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('phone', "Телефон")}}:
                            <p>{{$client->phone}}</p>
                        </div>

                        <div class="form-group">
                            {{Form::label('email', "E-mail")}}:
                            <p>{{$client->email}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Лайкнуто</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Логотип</th>
                                <th>Наименование</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($client->Likes as $anticafe)
                                <tr>
                                    <td style="width: 100px"><img src="{{$anticafe->logo ? "/images/anticafes/logos/100x100/100x100_".$anticafe->logo : "/images/no-image.png"}}" width="100" height="100"/></td>
                                    <td>{{$anticafe->name}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">В базе данных нет лайкнутых</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Бронировано</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Количество человек</th>
                                <th>Комментарий</th>
                                <th>Тип брони</th>
                                <th>Место\Событие</th>
                                <th>Дата прибытия</th>
                                <th>Дата бронирования</th>
                                <th>Менеджер</th>
                                <th>Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($client->Bookings as $booking)
                                <tr>
                                    <td>{{$booking->count_of_customers}}</td>
                                    <td>{{$booking->comment}}</td>
                                    <td>{{$booking->Anticafe->type == 0 ? "Антикафе" : "Событие"}}</td>
                                    <td>{{$booking->Anticafe->name}}</td>
                                    <td>{{$booking->arrival_at}}</td>
                                    <td>{{$booking->created_at}}</td>
                                    <td>{{$booking->Manager->username}}</td>
                                    <td>{{config("statuses.{$booking->status}")}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">В базе данных нет брони</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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