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
        <h2>Common instructions</h2>
        <p>For getting responses in JSON format, you have to send your requests with header:
        <pre>Accept: application/json</pre>
        </p>
        <h2>Authorization</h2>

        <h2>Authorized HTTP Requests</h2>
        <p>
            On sending HTTP request on resources, I'm recommending add to your requests special header
            <pre>AuthToken: token_string</pre>
            You can get this token in POST auth request.
            This authorized request will return special fields available to an authorized user with access to some requests:
            <ol>
                <h3>Content</h3>
                <li>Bookings block on home activity</li>
                <li>Profile activity</li>
                <li>Profile page</li>
                <h3>Requests</h3>
                <li>GET /api/boooking/get/{id}</li>
                <li>GET /api/boooking/delete/{id}</li>
                <li>POST /api/boooking</li>
                <li>POST /api/like</li>
            </ol>

        </p>
        <h2>URL's</h2>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/home"><abbr title="/api/home">/api/home</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getMain</a>
                <p>Return JSON for creating home page in application</p>
            </div>
        </div>
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
                <a href="/api/anticafes/16"><abbr title="/api/anticafes">/api/anticafes/{count}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getAnticafes</a>(int $count)
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
                <a href="/api/events/1"><abbr title="/api/events">/api/events/{count}</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getEvents</a>(int $count)
                <p>Make query and take events by specified count</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/tags"><abbr title="/api/tags">/api/tags</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getTags</a>
                <p>Make query and take tags</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/abilities"><abbr title="/api/abilities">/api/abilities</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getAbilities</a>
                <p>Make query and take all abilities list</p>
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
                <a href="/api/client"><abbr title="/api/client/">/api/client</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getClient</a>
                <p>Returned client profile json. Recommended do this query than application is running and save client model in preferences of your application</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <p><strong>GET</strong></p>
            </div>
            <div class="col-md-2 type">
                <a href="/api/profile"><abbr title="/api/profile/">/api/profile</abbr></a>
            </div>
            <div class="col-md-9 type">
                <a href="#">getProfile</a>
                <p>Returned json for profile info page - <a href="https://drive.google.com/file/d/0B_SjoeZavdZwU08yT2VxdEVBc2M/view?usp=sharing" target="_blank">link to page</a></p>
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
<pre>{
    "status": 200,
    "error": false,
    "anticafes_and_events": [
        ...
    ],
    "finded_by_tags_and_aliases":
        ...
    ]
}</pre>
                    <b>anticafes_and_events</b> - contains anticafes and events entities find by <i>name</i>, <i>address</i>, <i>excerpt</i>, <i>description</i> fields<br/>
                    <b>finded_by_tags_and_aliases</b> - contains anticafes and events entities find by <i>Tags name</i> fields OR <i>Aliases name</i> fields
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
            </div>
            <div class="col-md-7 type">
                <a href="#">postBooking</a>(Illuminate\Http\Request $request)
                <p>
                    Make post request with required params. This method returned JSON: <br/>
<pre>{
    "status": 200,
    "error": false
}</pre>
                    or<br/>
<pre>{
    "status": 500,
    "error": true,
    "message": "error message"
}</pre><br/>
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
            </div>
            <div class="col-md-7 type">
                <a href="#">postLike</a>(Illuminate\Http\Request $request)
                <p>
                    This method serve to like or unlike entity(anticafe or events). If user unlike post - this method will return JSON:
<pre>{
    "status": 200,
    "error": false,
    "likeStatus": "unliked\liked" // <span style="color: red">In dependence of like or unlike action</span>
    "totalLikes": 123
}</pre>
                </p>
            </div>
        </div>
    </div>
@endsection
