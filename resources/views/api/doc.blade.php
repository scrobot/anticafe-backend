@extends('layouts.app')

@section('css')
    <style>
        h2 {
            background-color: #EDF3FE;
            padding: 4px 4px 4px 8px;
            font-size: 25px;
            margin: 20px 0;
        }

        p strong {
            text-align: center;
            display: block;
        }

        ul {
            padding: 0;
        }

        .underlined > .row {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
    </style>
@stop

@section('breadcrumbs')
    <li><a href="/">Главная</a></li>
    <li class="active">{{$title}}</li>
@stop

@section('content')
    <h1>{{$title}}</h1>
    <div class="container-fluid underlined">
        <h2>URL's</h2>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/anticafes"><abbr title="/api/anticafes">/api/anticafes</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getAnticafes</a>
                <p>Make query and take anticafes. Default count - 15</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/anticafes/1"><abbr title="/api/anticafes">/api/anticafes/{limit}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getAnticafes</a>(int $limit)
                <p>Make query and take anticafes by specified count</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/events"><abbr title="/api/anticafes">/api/events</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getEvents</a>
                <p>Make query and take events. Default count - 15</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/events/1"><abbr title="/api/events">/api/events/{limit}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getEvents</a>(int $limit)
                <p>Make query and take events by specified count</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/entity/get/1"><abbr title="/api/entity/get/{id}">/api/entity/get/{id}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getGetOneAnticafeOrEvent</a>(int $id)
                <p>Make query to get single of the entities. (Anticafe or Event). Returned specified entity with tags and attached Anticafes\Events relation fields</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/client/1"><abbr title="/api/client/{id}">/api/client/{id}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getProfile</a>(int $id)
                <p>Take app profile client entity. Returned with bookings and likes relation fields</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/boooking/get/1"><abbr title="/api/boooking/get/{id}">/api/boooking/get/{id}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getClientBooking</a>(int $id)
                <p>Find booking by {id} in param and returned it's entity with anticafe(or event) relation field. </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/boooking/delete/1"><abbr title="/api/boooking/get/{id}">/api/boooking/delete/{id}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getDeleteBooking</a>(int $id)
                <p>This method returned JSON status text "OK" and HTTP code status "200" if booking will be delete successfuly.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>POST</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/search"><abbr title="/api/search">/api/search</abbr></a>
            </div>
            <div class="col-md-2">
                <strong>Params</strong>
                <p>(string) search_text</p>
            </div>
            <div class="col-md-7 type">
                <a href="#">postSearch</a>(Illuminate\Http\Request $request)
                <p>
                    Make post request with required params. This method returned result array with two elemetnts.<br/>
                    <b>result[anticafes_and_events]</b> - contains anticafes and events entities find by <i>name</i>, <i>address</i>, <i>excerpt</i>, <i>description</i> fields<br/>
                    <b>result[finded_by_tags_and_aliases]</b> - contains anticafes and events entities find by <i>Tags name</i> fields OR <i>Aliases name</i> fields
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>POST</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/boooking"><abbr title="/api/boooking">/api/boooking</abbr></a>
            </div>
            <div class="col-md-2">
                <strong>Params</strong>
                <p>(int) count_of_customers</p>
                <p>(string) comment</p>
                <p>(string) contacts</p>
                <p>(string) status</p>
                <p>(timestamp) arrival_at</p>
                <p>(int) anticafe_id</p>
                <p>(int) client_id</p>
            </div>
            <div class="col-md-7 type">
                <a href="#">postBooking</a>(Illuminate\Http\Request $request)
                <p>
                    Make post request with required params. This method returned JSON status text "OK" and HTTP code status "200" if booking will be saved successfuly.<br/>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>POST</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/like"><abbr title="/api/like">/api/like</abbr></a>
            </div>
            <div class="col-md-2">
                <strong>Params</strong>
                <p>(int) anticafe_id</p>
                <p>(int) client_id</p>
            </div>
            <div class="col-md-7 type">
                <a href="#">postLike</a>(Illuminate\Http\Request $request)
                <p>
                    This method serve to like or unlike entity(anticafe or events). If user unlike post - this method will return JSON status "unliked", if user like post - will be returned "liked" status.
                </p>
            </div>
        </div>
    </div>
@endsection
