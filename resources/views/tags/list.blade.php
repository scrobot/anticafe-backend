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
    <div class="alert alert-warning">
        <p><b>ВНИМАНИЕ!</b> При загрузке иконок следует знать:</p>
        <ol>
            <li>Иконки должны быть в формате png с прозрачным фоном.</li>
            <li>Соотношение сторон должно быть 1:1, т.е. иконки по размеру должны быть квадратные.</li>
        </ol>
        <p><b>При несоблюдении данных условий сущность не сохранится.</b></p>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['action' => "TagsController@postStore", 'class' => 'form-inline', 'files' => true]) }}
                {{ Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Возможность']) }}
                {{ Form::select("parent_id", $groups, null, ['class'=>'form-control',  'id' => 'group']) }}
                {{ Form::file("icon", ['class'=>'form-control']) }}
                <label id="is_group">
                    {{ Form::checkbox("is_group", 1, null, ['class'=>'form-control']) }}
                    Группа
                </label>
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
                    <th>Слуг</th>
                    <th>Наименование</th>
                    <th>Группа</th>
                    <th>Является группой</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tags as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->slug}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->Group ? $item->Group->name : "Без группы"}}</td>
                        <td>{{$item->is_group ? "Да" : "Нет"}}</td>
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
@stop

@section('js')
    <script type="text/javascript">
        $('#group').change(function(){
            if(isNaN(parseInt($(this).val()))) {
                $('#is_group').fadeIn()
            } else {
                $('#is_group').fadeOut()
            }
        })
    </script>
@stop
