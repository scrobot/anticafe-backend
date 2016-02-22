@extends('layouts.app')

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('content')
    <h1>{{$title}}</h1>
    {{ Form::open(['route' => 'bookings.status']) }}
    @if(can('booking.status.change'))
    <button type="submit" class="btn btn-success right" style="margin-bottom: 20px">Сохранить</button>
    @endif
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Фамилия Имя клиента</th>
            <th>Телефон клиента</th>
            <th>Дата прибытия</th>
            <th>Тип брони</th>
            <th>Место\Событие</th>
            <th>Количество человек</th>
            <th>Комментарии</th>
            <th>Доп. контактные данные</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @forelse($bookings as $item)
            <tr>
                <td>{{$item->Client->first_name . " " . $item->Client->last_name}}</td>
                <td>{{$item->Client->phone}}</td>
                <td>{{$item->arrival_at}}</td>
                <td>{{$item->Anticafe->type == 0 ? "Антикафе" : "Событие"}}</td>
                <td>{{$item->Anticafe->name}}</td>
                <td>{{$item->count_of_customers}}</td>
                <td>{{$item->comment}}</td>
                <td>{{$item->contacts}}</td>
                <td>
                    @if(can('booking.status.change'))
                        {{ Form::select("clients[{$item->id}]", config('statuses'), $item->status, ['class' => 'form-control'])}}
                    @else
                        {{$item->status}}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10">Заказов на бронь в базе не найдено</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{ Form::close() }}
@endsection
