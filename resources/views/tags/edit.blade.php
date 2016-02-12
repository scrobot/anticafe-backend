@extends('layouts.app')

@section('css')
    <style>
        #variables {
            margin: 20px 0;
        }
        .variable {
            margin: 10px 0;
        }
        .buttons .btn-danger {
            display: none;
        }
        .ready-to-delete {
            display: block !important;
        }
        button[type='submit'] {
            float: right;
        }
    </style>
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li><a href="{{route('tags')}}">{{$title}}</a></li>
    <li class="active">редактировать</li>
@stop

@section('actions_menu')
    @include('tags.actions_menu')
@stop

@section('content')
    <h1>Редактировать возможность {{$tag->name}}</h1>

    <div class="row">
        <div class="col-md-12">
        {{ Form::model($tag, ['action' => ['TagsController@postUpdate', $tag->id]]) }}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Основные данные</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {{Form::label('name', "Название")}}
                            {{Form::text('name', null, ["class" => "form-control"])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Синонимы</h2>
                    </div>
                    <div class="panel-body">
                        <div id="variables">
                            @foreach($tag->Aliases as $alias)
                                <div class="col-md-3 variable form-inline">
                                    <div class="form-group">
                                        {{Form::label('aliases', "Алиас")}}
                                        {{Form::text('aliases[]', $alias->name, ["class" => "form-control"])}}
                                    </div>
                                    <div class="form-group buttons">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-clone"><i class="glyphicon glyphicon-plus"></i></button>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger ready-to-delete"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                <div class="col-md-3 variable form-inline">
                                    <div class="form-group">
                                        {{Form::label('aliases', "Алиас")}}
                                        {{Form::text('aliases[]', null, ["class" => "form-control"])}}
                                    </div>
                                    <div class="form-group buttons">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-clone"><i class="glyphicon glyphicon-plus"></i></button>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-lg btn-primary" type="submit">{{trans('common.button.edit')}}</button>
            </div>
        {{ Form::close() }}
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            var variables = $('#variables');
            var variable = $('.variable');
            var variableCount = 0;
            var variableId = 1;
            var limit = 50;
            variables.on('click', '.btn-clone', function(){
                var clone = $(this).closest('.variable').clone();
                clone.find('.btn-danger').fadeIn()
                clone.find('.var-param').attr('name', 'params[' + variableId + '][name]')
                clone.find('.var-value').attr('name', 'params[' + variableId + '][value]')
                variables.append(clone)
                buttonsManipulation(false)
                console.log(variableCount)
            })
            variables.on('click', '.btn-danger', function(){
                $(this).closest('.variable').remove()
                buttonsManipulation(true)
                console.log(variableCount)
            })
            function buttonsManipulation(remove) {
                if(remove) {
                    variable.each(function(){
                        variableCount--;
                    })
                } else {
                    variable.each(function(){
                        variableCount++;
                        variableId++;
                    })
                }
                if(variableCount >= limit) {
                    $('.btn-clone').fadeOut()
                } else {
                    $('.btn-clone').fadeIn()
                }
            }
        })
    </script>
@stop