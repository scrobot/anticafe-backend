@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('actions_menu')
    @include('events.actions_menu')
@stop

@section('content')
    <h1>{{$title}}</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Наименование</th>
            <th>Краткое описание</th>
            <th>Начало</th>
            <th>Окончание</th>
            <th>Цена</th>
            <th>Обложка</th>
            <th>Фото</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($events as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->excerpt}}</td>
                <td>{{$item->start_at}}</td>
                <td>{{$item->end_at}}</td>
                <td>{{$item->phone}}</td>
                <td style="text-align: center"><img src="{{$item->photo ? "/images/anticafes/events/100x100/100x100_".$item->photo : "/images/no-image.png"}}" width="100" height="100"/></td>
                <td style="text-align: center"><img src="{{$item->cover ? "/images/anticafes/events/100x100/100x100_".$item->cover : "/images/no-image.png"}}" width="100" height="100"/></td>
                <td>
                    <a href="{{action('EventsController@getUpdate', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{action('EventsController@getDestroy', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Событий в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
