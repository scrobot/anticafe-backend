@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('content')
    <h1>{{$title}}</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>E-mail</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($clients as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->first_name}}</td>
                <td>{{$item->last_name}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->email}}</td>
                <td>
                    <a href="{{action('ClientsController@getShow', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.show')}}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="{{action('ClientsController@getDestroy', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Клиентов в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
