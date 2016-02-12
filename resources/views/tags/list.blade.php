@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('actions_menu')
    @include('tags.actions_menu')
@stop


@section('content')
    <h1>{{$title}}</h1>
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['action' => "TagsController@postStore", 'class' => 'form-inline']) }}
            {{ Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Возможность']) }}
            <button class="btn btn-success" type="submit">Добавить</button>
            {{ Form::close() }}
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Наименование</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tags as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            <a href="{{action('TagsController@getEdit', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.edit')}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="{{action('TagsController@getDelete', $item->id)}}" data-toggle="tooltip" data-placement="top" title="{{trans('common.button.delete')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Антикафе в базе не найдено</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
