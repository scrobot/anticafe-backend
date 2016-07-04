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
    <li><a href="{{route('anticafes')}}">{{$title}}</a></li>
    <li class="active">Лайки</li>
@stop

@section('actions_menu')
    @include('anticafes.actions_menu')
    <div class="row">
        <h2>Фильтр:</h2>
        {!! Form::open(["action" => "AnticafeController@postLikesFilter", "method" => "post"]) !!}
            <div class="form-group">
                <label class="col-xs-12 col-md-2 col-md-offset-2">Антикафе</label>
                <div class="col-xs-12 col-md-6">
                    {!! Form::select("anticafe", $anticafes, $selected['anticafe'], ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-md-2 col-md-offset-2">Клиент</label>
                <div class="col-xs-12 col-md-6">
                    {!! Form::select("client", $clients, $selected['client'], ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-large">Фильтровать</button>
            </div>
        {!! Form::close() !!}
    </div>
@stop

@section('content')
    <h1>Лайки. Количество: {{$likes->count()}}</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Антикафе</th>
            <th>Клиент</th>
        </tr>
        </thead>
        <tbody>
        @forelse($likes as $like)
            @if($like->Anticafe)
            <tr>
                <td><a href="{{action('AnticafeController@getShow', $like->Anticafe->id)}}">{{$like->Anticafe->name}}</a></td>
                <td>
                    <a href="{{action('ClientsController@getShow', $like->Client->id)}}">
                        @if($like->Client->email == null)
                            {{$like->Client->first_name}} {{$like->Client->last_name}}
                        @else
                            {{$like->Client->email}}
                        @endif
                    </a>
                </td>
            </tr>
            @endif
        @empty
            <tr>
                <td colspan="9">Лайков в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
