@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">Корзина</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
@stop

@section('content')
    <h1>{{$title}}</h1>
    <div style="margin: 0 0 25px 0;">
        <ul class="nav nav-pills">
            <li><a href="{{action('AnticafeController@getDestroy')}}" class="btn btn-xs btn-danger">Очистить корзину</a></li>
            <li><a href="{{action('AnticafeController@getRestoreAll')}}" class="btn btn-xs btn-success">Восстановить все</a></li>
        </ul>
    </div>
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
                <td><img src="{{$item->logo ? $item->logo : "/images/no-image.png"}}" width="50" height="50"/></td>
                <td>{{$item->name}}</td>
                <td>{{$item->city}}</td>
                <td>{{$item->metro}}</td>
                <td>{{$item->address}}</td>
                <td>{{$item->phone}}</td>
                <td><img src="{{$item->cover ? $item->cover : "/images/no-image.png"}}" width="50" height="50"/></td>
                <td>
                    <a href="{{action('AnticafeController@getRestore', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.restore')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-up"></span></a>
                    <a href="{{action('AnticafeController@getClean', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.clean')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Антикафе в корзине не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
