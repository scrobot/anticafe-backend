@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h1>Статистика по приложению</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Количество лайков</th>
                        <th>Количество просмотров</th>
                        <th>Количество бронирований</th>
                        <th colspan="3" style="text-align: center">Количество скачиваний</th>
                        <th>Количество пользователей</th>
                        <th>Среднее время использования</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th>iOS</th>
                        <th>Android</th>
                        <th>Все</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$stata->likes}}</td>
                        <td>{{$stata->views}}</td>
                        <td>{{$stata->bookings}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{$stata->bookings}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6"></div>

    </div>
@endsection
