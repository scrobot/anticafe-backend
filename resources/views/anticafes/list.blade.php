@extends('layouts.app')

@section('css')
    <style>
        .sort {
            padding-right: 20px !important;
        }

        .desc {
            background: url("/images/up.jpg") no-repeat right 10px center;
        }

        .asc {
            background: url("/images/sort_down.png") no-repeat right 10px center;
        }

    </style>
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    <h1>{{$title}}</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Действия</th>
            <th class="sort {{\Request::get('name') == "desc" ? "asc" : "desc"}}"><a href="?name={{\Request::get('name') == "desc" ? "asc" : "desc"}}">Наименование</a></th>
            <th>Город</th>
            <th>Метро</th>
            <th>Адрес</th>
            <th>Телефон</th>
            <th class="sort {{\Request::get('total_views') == "desc" ? "asc" : "desc"}}"><a href="?total_views={{\Request::get('total_views') == "desc" ? "asc" : "desc"}}">Просмотрено</a></th>
            <th class="sort {{\Request::get('total_likes') == "desc" ? "asc" : "desc"}}"><a href="?total_likes={{\Request::get('total_likes') == "desc" ? "asc" : "desc"}}">Лайкнуто</a></th>
            <th class="sort {{\Request::get('total_bookings') == "desc" ? "asc" : "desc"}}"><a href="?total_bookings={{\Request::get('total_bookings') == "desc" ? "asc" : "desc"}}">Забронировано</a></th>
        </tr>
        </thead>
        <tbody>
        @forelse($anticafes as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>
                    <a href="{{action('AnticafeController@getShow', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.show')}}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('AnticafeController@getUpdate', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{action('AnticafeController@getDelete', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
                <td><a href="{{action('AnticafeController@getUpdate', $item->id)}}">{{$item->name}}<sup><b>{{!$item->promo ? "" : "Promo!"}}</b></sup></a></td>
                <td>{{$item->city}}</td>
                <td>{{$item->metro}}</td>
                <td>{{$item->address}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->total_views}}</td>
                <td>{{$item->total_likes}}</td>
                <td>{{$item->total_bookings}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Антикафе в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
