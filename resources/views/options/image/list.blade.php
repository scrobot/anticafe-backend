@extends('layouts.app')

@section('css')
    <style>
        .bg-sq {
            width: 50px;
            height: 50px;
            border: 1px solid #000;
        }
    </style>
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('actions_menu')
    @include('options.image.actions_menu')
@stop

@section('content')
    <h1>{{$title}}</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>ширина изображения</th>
            <th>высота изображения</th>
            <th>Якорь</th>
            <th>Относительная образка(Да\Нет)</th>
            <th>Цвет фона</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($options as $option)
            <tr>
                <td>{{$option->id}}</td>
                <td>{{$option->name}}</td>
                <td>{{$option->width}}</td>
                <td>{{$option->height}}</td>
                <td>{{$option->anchor}}</td>
                <td>{{$option->relative ? "Да" : "Нет"}}</td>
                <td><div class="bg-sq" style="background-color: {{$option->bgcolor}}"></div></td>
                <td>
                    <a href="{{action('ImageOptionsController@getUpdate', $option->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{action('ImageOptionsController@getDestroy', $option->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Опций в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
