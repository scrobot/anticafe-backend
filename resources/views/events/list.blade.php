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
            <th>Начинается в</th>
            <th>Заканчивается в</th>
            <th class="sort {{\Request::get('total_views') == "desc" ? "asc" : "desc"}}"><a href="?total_views={{\Request::get('total_views') == "desc" ? "asc" : "desc"}}">Просмотрено</a></th>
            <th class="sort {{\Request::get('total_likes') == "desc" ? "asc" : "desc"}}"><a href="?total_likes={{\Request::get('total_likes') == "desc" ? "asc" : "desc"}}">Лайкнуто</a></th>
            <th class="sort {{\Request::get('total_bookings') == "desc" ? "asc" : "desc"}}"><a href="?total_bookings={{\Request::get('total_bookings') == "desc" ? "asc" : "desc"}}">Забронировано</a></th>
        </tr>
        </thead>
        <tbody>
        @forelse($events as $item)
            @if(can('events.see.own', ['\Anticafe\Http\Models\User@isMyAnticafe', $item->id], null, 'or'))
            <tr>
                <td>{{$item->id}}</td>
                <td>
                    <a href="{{action('AnticafeController@getShow', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.show')}}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('EventsController@getEdit', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
                <td><a href="{{action('EventsController@getEdit', $item->id)}}">{{$item->name}}</a><sup><b>{{!$item->promo ? "" : "Promo!"}}</b></sup></td>
                <td>{{$item->start_at}}</td>
                <td>{{$item->end_at}}</td>
                <td>{{$item->total_views}}</td>
                <td>{{$item->total_likes}}</td>
                <td>{{$item->total_bookings}}</td>
            </tr>
            @endif
        @empty
            <tr>
                <td colspan="9">Событий в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {!! $events->render() !!}
@endsection
