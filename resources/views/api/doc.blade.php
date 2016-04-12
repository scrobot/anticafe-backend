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

        ul.wp {
            padding-left: 40px;
        }

        ul {
            padding: 0;
        }

        .underlined > .row {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .col-xs-12 > .row {
            margin-top: 25px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .col-xs-12 > .row:last-child {
            border-bottom: none;
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
        <div class="row">
            <div class="col-xs-12">
                <h2>Common instructions</h2>
                <p>For getting responses in JSON format, you have to send your requests with header:
                <pre>Accept: application/json</pre>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h2>Authorization</h2>
                <p>Process of authentication is very simple. Recources are using Vk.com and facebook.com Oauth servers. For implimenting auth in aplication, you have to includes sdk:</p>
                <ul class="wp">
                    <h3>Android</h3>
                    <li>VK SDK - <a href="https://vk.com/dev/android_sdk">https://vk.com/dev/android_sdk</a></li>
                    <li>Facebook SDK - <a href="https://developers.facebook.com/docs/facebook-login/android">https://developers.facebook.com/docs/facebook-login/android</a></li>
                    <h3>iOS</h3>
                    <li>VK SDK - <a href="https://vk.com/dev/ios_sdk">https://vk.com/dev/ios_sdk</a></li>
                    <li>Facebook SDK - <a href="https://developers.facebook.com/docs/facebook-login/ios">https://developers.facebook.com/docs/facebook-login/ios</a></li>
                    <h3>Windows Phone(For Fun =) Or simple reading =) ) </h3>
                    <li>VK SDK - <a href="https://vk.com/dev/wp_sdk">https://vk.com/dev/wp_sdk</a></li>
                </ul>
                <p>In documentation describes detailed instructions how to implement apps OAuth.</p>
                <p>Then, when you include this SKD's, you have to make lists of permissions:</p>
                <ul class="wp">
                    <h3>VK</h3>
                    <li>email</li>
                    <li>nohttps</li>
                    <li>photos</li>
                    <li>notify</li>
                    <h3>Facebook</h3>
                    <li>public_profile</li>
                    <li>email</li>
                </ul>
                <p><b>Note: </b><i>I'm recommending include more permissions(scopes) than it's needed now. For future requesting and extending new functionality. It will we easer working and testings with accounts, that already have needed permissions. Also, it's better for users. Then they are will update app they willn't need to reauthorized for recieving new scopes and permissions.</i></p>
                <br/>
                <p>So, then you include SDK's in your app, you can send POST request with requeried uid and access_token fields</p>

                <h2>Authorization URL's</h2>

                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/vk"><abbr title="/api/vk">/api/vk</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(int) uid</p>
                        <p>(string) access_token</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postVk</a>(Illuminate\Http\Request $request)
                        <p>
                            Backend VK authentication request. this method send request in "https://api.vk.com/method/users.get?user_id={$uid}&fields=photo_50" and recieved VK API response. In DB searching client by <b>"uid"</b>. If he is finded - his some fields are update by VK response. If he is not finded - this client is created. <br/>
                            Responsing JSON if request was successfuly
<pre>{
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "client": {
    "id": 1,
    "first_name": "Alexey",
    "last_name": "Skrobot",
    "phone": null,
    "email": null,
    "avatar": "http://cs7001.vk.me/v7001872/114d1/lQjM7nrWVeM.jpg",
    "get_notifications": null,
    "get_news": null,
    "created_at": "2016-03-12 14:24:39",
    "updated_at": "2016-03-12 15:09:12",
    "social_profile_link": null,
    "authToken": "S0fTJRsadsd3oY9oNVRWbxyBeZ0Gelt",
    "vkontakte": 1,
    "facebook": 0,
    "vk_uid": 178685292,
    "fb_uid": null,
    "vk_token": "b66aede53902a7bfebe6a3ea48c86aa3d9da24321d4554ff2af1b8ff8be0c3cc474530fc82d47e82dacb9",
    "fb_token": null
  }
}</pre>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/fb"><abbr title="/api/fb">/api/fb</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(int) uid</p>
                        <p>(string) access_token</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postFb</a>(Illuminate\Http\Request $request)
                        <p>
                            Backend FB authentication request. this method send request in "https://graph.facebook.com//v2.5/{$uid}?access_token={$access_token}&fields=id,email,first_name,last_name,picture" and recieved FB API response. In DB searching client by <b>"uid"</b>. If he is finded - his some fields are update by FB response. If he is not finded - this client is created. <br/>
                            Responsing JSON if request was successfuly
<pre>{
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "client": {
    "id": 1,
    "first_name": "Alexey",
    "last_name": "Skrobot",
    "phone": null,
    "email": null,
    "avatar": "http://cs7001.vk.me/v7001872/114d1/lQjM7nrWVeM.jpg",
    "get_notifications": null,
    "get_news": null,
    "created_at": "2016-03-12 14:24:39",
    "updated_at": "2016-03-12 15:09:12",
    "social_profile_link": null,
    "authToken": "S0fTJRsadsd3oY9oNVRWbxyBeZ0Gelt",
    "vkontakte": 0,
    "facebook": 1,
    "vk_uid": null,
    "fb_uid": 792012727595876,
    "vk_token": null,
    "fb_token": CAAOBYkKgTzoBAI4ZBfB05nLf5rQo6qZAWhlE9kFqz5NGvXRu365ZCGZAZCSdCnCuvfVdiwYHiHThHsxejdhM8pERONwKCs5hJolSo5slUe1Q26Gzew5OWmfHOtZBPDnwOldKN4JAZCadRHFJO3O0YFJLqPaLEzN1j1XpW5Yh6LybMroeuAyA8st
  }
}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
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
                    <li>GET /api/booking/get/{id}</li>
                    <li>GET /api/booking/delete/{id}</li>
                    <li>POST /api/booking</li>
                    <li>POST /api/like</li>
                </ol>

                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
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
                        <a href="/api/booking/get/1"><abbr title="/api/booking/get/{id}">/api/booking/get/{id}</abbr></a>
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
                        <a href="/api/booking/delete/1"><abbr title="/api/booking/get/{id}">/api/booking/delete/{id}</abbr></a>
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
                        <a href="/api/profile-update"><abbr title="/api/profile-update">/api/profile-update</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(string) first_name</p>
                        <p>(string) last_name</p>
                        <p>(string) email</p>
                        <p>(string) phone</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postProfileUpdate</a>(Illuminate\Http\Request $request)
                        <p>
                            Make post request with required params. This method returned result array with two elemetnts.<br/>
<pre>{
    "status": 500\200,
    "error": false\true,
    "message": "Произошла ошибка при обновлении профиля."\"Профиль успешно обновлен" // В зависимости от результата выполнения запроса - провал\успех
}</pre>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/search-by-tag"><abbr title="/api/search-by-tag">/api/search-by-tag</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(string) tag_id</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postFindByTag</a>(Illuminate\Http\Request $request)
                        <p>
                            Make post request with required params. This method returned result array with json:<br/>
<pre>{
    "status": 200,
    "error": false,
    "searchResult": [
        "anticafes_and_events": [
            ...
        ]
    ]
}</pre>
                        <b>anticafes_and_events</b> - contains anticafes and events entities find by <i>name</i>, <i>address</i>, <i>excerpt</i>, <i>description</i> fields<br/>
                        </p>
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
                            Make post request with required params. This method returned result array with json.<br/>
<pre>{
    "status": 200,
    "error": false,
    "searchResult": [
        "anticafes_and_events": [
            ...
        ]
    ]
}</pre>
                        <b>anticafes_and_events:</b><br/>
                        This result is collecting by 2 operations<br/>
                        1 itteration - push in collection anticafes and events entities find by <i>name</i>, <i>address</i>, <i>excerpt</i>, <i>description</i> fields<br/>
                        2 itteration - push in collection anticafes and events entities find by <i>Tags name</i> fields OR <i>Aliases name</i> fields
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/booking"><abbr title="/api/booking">/api/booking</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(int) count_of_customers</p>
                        <p>(string) comment</p>
                        <p>(string) contacts</p>
                        <p>(string) status - not required. Default: process</p>
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
        </div>

    </div>
@endsection
