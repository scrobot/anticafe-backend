@extends('layouts.app')

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
            <th>Лого</th>
            <th>Наименование</th>
            <th>Город</th>
            <th>Метро</th>
            <th>Адрес</th>
            <th>Телефон</th>
            <th>Обложка</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($anticafes as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td style="text-align: center"><img src="{{$item->logo ? $item->logo : "/images/no-image.png"}}" width="100" height="100"/></td>
                <td>{{$item->name}}</td>
                <td>{{$item->city}}</td>
                <td>{{$item->metro}}</td>
                <td>{{$item->address}}</td>
                <td>{{$item->phone}}</td>
                <td style="text-align: center"><img src="{{$item->cover ? $item->cover : "/images/no-image.png"}}" width="100" height="100"/></td>
                <td>
                    <a href="{{action('AnticafeController@getUpdate', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{action('AnticafeController@getDelete', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Антикафе в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
