<h3>В ваше антикафе {{$book['ent']}} поступил запрос на бронирование:</h3>
<p>{{$book['client_name']}}</p>
@if($book['contacts'])
    <p>{{$book['phone']}}</p>
@else
    <p>{{$book['contacts']}}</p>
@endif
<p>{{$book['count_of_customers']}} человек</p>
<p>{{$book['arrival_at']}}</p>
@if($book['comment'])
    <p>Комментарий: {{$book['comment']}}</p>
@endif