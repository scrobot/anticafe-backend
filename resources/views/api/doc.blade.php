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
                        <a href="/api/login"><abbr title="/api/vk">/api/login</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p><span style="color: red">(Required)</span>(string) email. {OPTIONAL} Validator mask - (3+)@(2+).(2+)</p>
                        <p><span style="color: red">(Required)</span>(string) password</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postLogin</a>(Illuminate\Http\Request $request)
                        <p>
                            Backend clean authentication method. Send your http request with necessary fields.
                        <p><strong>success json structure</strong></p>
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
                        <p><strong>fail json structure</strong></p>
<pre>{
  "status": 500,
  "error": true,
  "needAuth": false,
  "message": "Ошибка авторизации"
}</pre>

                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/register"><abbr title="/api/vk">/api/register</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(string) first_name</p>
                        <p>(string) last_name</p>
                        <p>(string) phone</p>
                        <p><span style="color: red">(Required)</span>(string) email. {OPTIONAL} Validator mask - (3+)@(2+).(2+)</p>
                        <p><span style="color: red">(Required)</span>(string) password</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postRegister</a>(Illuminate\Http\Request $request)
                        <p>
                            Backend clean registration method. Send your http request with necessary fields.
                        <p><strong>success json structure</strong></p>
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
                        <p><strong>fail json structure</strong></p>
<pre>{
  "status": 500,
  "error": true,
  "needAuth": false,
  "message": "",
  "messages": [
    {
      "field": "email",
      "message": "The email field is required."
    },
    {
      "field": "password",
      "message": "The password field is required."
    }
  ]
}</pre>
                        </p>
                    </div>
                </div>
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
                <h2>Push notifications</h2>
                <p>For put device in list of notificated you need to do simple thing - one POST request.</p>

                <h3>Some details</h3>

                <h3>OS</h3>
                <p>The only difference beetwen android and iOS systems it's one parameter: os. For android it's value <b>"android"</b>, for iOS - <b>"ios"</b>.</p>
                <p><b><span style='color: red'>IMPORTANT!!!</span></b> Values "android" and "ios" must be in this text case. </p>

                <h3>Token</h3>
                <p>Token - is a unique string, that is provides by GCM(Google Cloud Messaging Service) or APNS(Apple Notification Service). All instructions see in your platform documentation</p>

                <h3>Device ID</h3>
                <p>DeviceID - unique id of client device. It's generated by devices OS, or you can generate by yourself and store in preferences for example</p>

                <h3>How to..</h3>
                <p>.. Put device on listening notifications? Send <i>/register-device</i> request with nesseray parametres</p>
                <p>.. Get dowm device from listening notifications? Send <i>/unregister-device</i> request with nesseray parametres</p>

                <h2>Notification API URL's</h2>

                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/register-device"><abbr title="/register-device">/register-device</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p><span style="color: red">(Required)</span>(string) os</p>
                        <p><span style="color: red">(Required)</span>(string) token</p>
                        <p><span style="color: red">(Required)</span>(string) device_id</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postRegisterDevice</a>(Illuminate\Http\Request $request)
                        <p>
                            Backend clean authentication method. Send your http request with necessary fields.
                        <p><strong>success json structure</strong></p>
<pre>{
  "status": 200,
  "error": false,
  "needAuth": true,
  "message": "Устройство успешно зарегестрировано"
}</pre>
                        <p><strong>fail json structure</strong></p>
<pre>{
  "status": 500,
  "error": true,
  "needAuth": true,
  "message": "Ошибка авторизации"
}</pre>

                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/unregister-device"><abbr title="/unregister-device">/unregister-device</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p><span style="color: red">(Required)</span>(string) device_id</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postUnregisterDevice</a>(Illuminate\Http\Request $request)
<pre>{
  "status": 200,
  "error": false,
  "needAuth": true,
  "message": "Устройство успешно удалено"
}</pre>
                        <p><strong>fail json structure</strong></p>
<pre>{
  "status": 404,
  "error": true,
  "needAuth": true,
  "message": "Устройство не найдено"
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
                        <p><strong>common json structure</strong></p>
<pre>
    {
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "anticafe": [
    {
      "id": 18,
      "name": "TimeTerria",
      "prices": "1 час 3 руб/мин, далее 2 руб/мин",
      "city": "Москва",
      "metro": "м. Новослободская\r\n",
      "phone": "+7(999)800-03-30",
      "event_address": null,
      "address": "2-й Щемиловский переулок, 4",
      "excerpt": "<p>Позволить себе быть современным, ярким и настоящим теперь стоит всего ничего! Антикафе Timeterria &nbsp;LiPeople &mdash; это новое остромодное место столицы, которое по праву можно назвать уникальным.&nbsp;</p>\r\n",
      "description": "<p>Позволить себе быть современным, ярким и настоящим теперь стоит всего ничего! АнтиКафе TimeTerria&nbsp;&mdash; это новое остромодное место столицы, которое по праву можно назвать уникальным.&nbsp;Молодежи больше не нужно тратить неоправданных денег для того, чтобы познакомиться с интересными людьми, посетить светское &nbsp;мероприятие, посмотреть новинки кинематографа или провести бизнес-конференцию. Все это уже есть в АнтиКафе TimeTerria.</p>\r\n",
      "logo": "aa6bc94a1cce34e24bc8036286df2ead.jpg",
      "cover": "ebb49c1730ebf1d5db9010afd2e5c1dd.jpg",
      "type": 0,
      "tw": "",
      "fb": "",
      "inst": "",
      "vk": "https://vk.com/timeterria2012",
      "created_at": "2016-02-29 06:01:30",
      "updated_at": "2016-05-26 10:11:31",
      "deleted_at": null,
      "start_at": null,
      "end_at": null,
      "total_views": 110,
      "total_likes": 8,
      "total_bookings": 2,
      "promo": 0,
      "routine": "пн-чт 10:30 - 23:30, пт 10:30 - 06:00, сб 12:00 - 06:00, вс 12:00 - 00-00",
      "booking_available": 1,
      "pincode": "2187",
      "attachments": {
        "logo": "http://backend.anticafe.im/images/anticafes/logos/aa6bc94a1cce34e24bc8036286df2ead.jpg",
        "cover": "http://backend.anticafe.im/images/anticafes/covers/ebb49c1730ebf1d5db9010afd2e5c1dd.jpg",
        "gallery": []
      }
    }
    }
  ],
  "tags": [
    {
      "id": 3,
      "slug": "nastolki",
      "name": "Настолки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png"
    }
  ],
  "bookings": [{
      "id": 108,
      "anticafe": "Anticafe.im",
      "address": "Кремль, 4 этаж",
      "type": "Антикафе",
      "arrivalAt": "27.05 в 13:00",
      "countOfCustomers": 2,
      "comment": "test tes test",
      "status": "В процессе",
      "anticafe_id": 62
    }]
}
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    {
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "anticafe": [
    {
      "id": 11,
      "name": "Jeffrey's Coffee (Менделеевская)",
      "prices": "2,5 руб/мин\r\nи не больше 500 рублей",
      "city": "Москва",
      "metro": "м.Менделеевская",
      "phone": "8(499)270-27-17",
      "event_address": null,
      "address": "Сущевская, 9с5",
      "excerpt": "",
      "description": "<p>Тайм-кофейня американского формата в историческом центре Москвы. Стильный интерьер, фирменный лось Джоффри, прекрасный кофе и профессиональный бариста - вот отличительные черты тайм-кофеен Jeffrey&#39;s. Кроме этого приятным бонусом идут снеки, сладости, разнообразные сиропы и прочие вкусняшки, а также игровые приставки, кикер, настольные игры и регулярные мероприятия вплоть до киноночей.</p>\r\n",
      "logo": "202e707536359ef2e6996336ef3a9659.jpg",
      "cover": "f73bffabf10352e3286e5c1f87598176.jpg",
      "type": 0,
      "tw": "",
      "fb": "",
      "inst": "@jeffreys_mendeleev",
      "vk": "vk.com/jeffreys_mendeleev",
      "created_at": "2016-02-19 11:00:53",
      "updated_at": "2016-05-26 09:30:33",
      "deleted_at": null,
      "start_at": null,
      "end_at": null,
      "total_views": 86,
      "total_likes": 5,
      "total_bookings": 4,
      "promo": 0,
      "routine": "пн-вс с 8:00 до 23:00, в киноночи до 6:00",
      "booking_available": 1,
      "pincode": "2187",
      "tags": [
        {
          "id": 6,
          "slug": "playstation",
          "name": "PlayStation",
          "parent_id": 54,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 6
          }
        },
        {
          "id": 37,
          "slug": "kalyan",
          "name": "Кальян",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/8ea2ed8e76ed00bbe864fab17222e68f.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 37
          }
        },
        {
          "id": 11,
          "slug": "knigi",
          "name": "Книги",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/aa4a3562a69cb6a352f5b626f651a7c4.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 11
          }
        },
        {
          "id": 10,
          "slug": "ko-vorking",
          "name": "Ко-воркинг",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 10
          }
        },
        {
          "id": 31,
          "slug": "lektsii",
          "name": "Лекции",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 31
          }
        },
        {
          "id": 14,
          "slug": "nastolnyy-futbol",
          "name": "Настольный футбол",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/c7bf3881481d9e2634a6ef553f755529.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 14
          }
        },
        {
          "id": 45,
          "slug": "nastolnyy-khokkey",
          "name": "Настольный хоккей",
          "parent_id": 999999999,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/a2b9ba2cd1f99579ba96bf88c40e47e6.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 45
          }
        },
        {
          "id": 54,
          "slug": "pristavki",
          "name": "Приставки",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 54
          }
        },
        {
          "id": 999999999,
          "slug": "prochee",
          "name": "Прочее",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 999999999
          }
        },
        {
          "id": 42,
          "slug": "kiker",
          "name": "Кикер",
          "parent_id": 999999999,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/c7bf3881481d9e2634a6ef553f755529.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 42
          }
        },
        {
          "id": 3,
          "slug": "nastolki",
          "name": "Настолки",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 3
          }
        },
        {
          "id": 58,
          "slug": "obshchenie",
          "name": "Общение",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/03bbe0cc963880a226e2891500975419.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 58
          }
        },
        {
          "id": 5,
          "slug": "proektor",
          "name": "Проектор",
          "parent_id": 10,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/9209d718cdc8a7878a6cbb5ef2f41f55.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 5
          }
        },
        {
          "id": 9,
          "slug": "flipchart",
          "name": "Флипчарт",
          "parent_id": 10,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/aaa7544e689e53fd054af93cdc34a00e.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 9
          }
        },
        {
          "id": 36,
          "slug": "yazyki",
          "name": "Языки",
          "parent_id": 31,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/4ade012bb1ea2a6540ecb2c15d3a20ba.png",
          "pivot": {
            "anticafe_id": 11,
            "tag_id": 36
          }
        }
      ],
      "events": [],
      "attachments": {
        "logo": "http://backend.anticafe.im/images/anticafes/logos/202e707536359ef2e6996336ef3a9659.jpg",
        "cover": "http://backend.anticafe.im/images/anticafes/covers/f73bffabf10352e3286e5c1f87598176.jpg",
        "gallery": []
      }
    },
    ... //more 14 items
  ]
}
</pre>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>GET</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/anticafes/16"><abbr title="/api/anticafes">/api/anticafes/{offset}</abbr></a>
                    </div>
                    <div class="col-md-9 type">
                        <a href="#">getAnticafes</a>(int $offset)
                        <p>Make query and take anticafes by specified offset</p>
                        <p><strong>common json structure for example: /api/anticafes/16</strong></p>
<pre>
    {
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "anticafe": [
    {
      "id": 4,
      "name": "ПВК Коперник",
      "prices": "2 руб/мин\r\nстоп-чек в будни 350 руб, в выходные 500 руб.\r\n",
      "city": "Москва",
      "metro": "м. Шаболовская\r\n",
      "phone": "+7(903)790-09-29",
      "event_address": null,
      "address": "Мытная, 52",
      "excerpt": "<p>Уникальное место для уникальных людей. Полное название этого необычного места - Пространственно-временной клуб Коперник. Днем это полноценный коворкинг для деловых встреч и мероприятий, полностью оборудованный необходимым оборудованием. А к вечеру и в выходные дни тайм кафе Коперник превращается в настоящий клуб по интересам.<br />\r\n&nbsp;</p>\r\n",
      "description": "<p>Уникальное место для уникальных людей. Полное название этого необычного места - Пространственно-временной клуб Коперник. Днем это полноценный коворкинг для деловых встреч и мероприятий, полностью оборудованный необходимым оборудованием. А к вечеру и в выходные дни тайм кафе Коперник превращается в настоящий клуб по интересам.<br />\r\n&nbsp;</p>\r\n",
      "logo": "44852187f04d1af32f764659fe5ec07f.png",
      "cover": "no-image.png",
      "type": 0,
      "tw": "",
      "fb": "",
      "inst": "",
      "vk": "https://vk.com/pvk_kopernik",
      "created_at": "2016-02-17 14:48:59",
      "updated_at": "2016-05-22 10:50:03",
      "deleted_at": null,
      "start_at": null,
      "end_at": null,
      "total_views": 7,
      "total_likes": 0,
      "total_bookings": 0,
      "promo": 0,
      "routine": "пн-вс 11:00-23:00",
      "booking_available": 0,
      "pincode": "2187",
      "tags": [
        {
          "id": 6,
          "slug": "playstation",
          "name": "PlayStation",
          "parent_id": 54,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 6
          }
        },
        {
          "id": 3,
          "slug": "nastolki",
          "name": "Настолки",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 3
          }
        },
        {
          "id": 12,
          "slug": "guitarhero",
          "name": "GuitarHero",
          "parent_id": 55,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/dd05f42aa4d5768b91a857d64591ebb7.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 12
          }
        },
        {
          "id": 21,
          "slug": "barabannaya-ustanovka",
          "name": "Барабанная установка",
          "parent_id": 55,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/a2b9ba2cd1f99579ba96bf88c40e47e6.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 21
          }
        },
        {
          "id": 35,
          "slug": "eda-s-soboy",
          "name": "Еда с Собой",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/69f801331b994668b94e5ee7f2bc7bb1.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 35
          }
        },
        {
          "id": 10,
          "slug": "ko-vorking",
          "name": "Ко-воркинг",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 10
          }
        },
        {
          "id": 20,
          "slug": "pin-bol",
          "name": "Пин-бол",
          "parent_id": 999999999,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/a2b9ba2cd1f99579ba96bf88c40e47e6.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 20
          }
        },
        {
          "id": 13,
          "slug": "ping-pong",
          "name": "Пинг-понг",
          "parent_id": 999999999,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/bc4bf053c6b690a0ea0cf52bb7437f28.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 13
          }
        },
        {
          "id": 5,
          "slug": "proektor",
          "name": "Проектор",
          "parent_id": 10,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/9209d718cdc8a7878a6cbb5ef2f41f55.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 5
          }
        },
        {
          "id": 16,
          "slug": "karaoke",
          "name": "Караоке",
          "parent_id": 55,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/9216dd0ccb1da52f71d44248f94db097.png",
          "pivot": {
            "anticafe_id": 4,
            "tag_id": 16
          }
        }
      ],
      "events": [],
      "attachments": {
        "logo": "http://backend.anticafe.im/images/anticafes/logos/44852187f04d1af32f764659fe5ec07f.png",
        "cover": "http://backend.anticafe.im/images/anticafes/covers/no-image.png",
        "gallery": [
          "http://backend.anticafe.im/images/anticafes/gallery/PVK2.jpg",
          "http://backend.anticafe.im/images/anticafes/gallery/PVK.png"
        ]
      },
      ...
     // more 14 items
    }
  ]
}
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    {
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "anticafe": [
    {
      "id": 72,
      "name": "Искусство общения: Королевство",
      "prices": "2 руб/мин",
      "city": null,
      "metro": null,
      "phone": null,
      "event_address": null,
      "address": null,
      "excerpt": "Театр импровизации: Королевство",
      "description": "<p>В честь того, что занятие по импровизации будет последним в этом &quot;сезоне&quot;, его будут проводить сами участники.<br />\r\nУже заявились Павел Новиков с разминкой и Михаил Беличенко с игрой про королевский двор.</p>\r\n\r\n<p>Также хотелось бы поговорить на тему разработки игр и перформансов, чтобы совершенствоваться в области импровизации, делать процессы более глубокими, захватывающими и философскими.</p>\r\n\r\n<p>Все, у кого есть опыт и идеи в этой области, смогут поделиться им ради общей пользы и процветания ;)<br />\r\nПриходите друзья!</p>\r\n",
      "logo": "f5780945b190051ee473bbddeaed39e5.jpg",
      "cover": "f5780945b190051ee473bbddeaed39e5.jpg",
      "type": 1,
      "tw": null,
      "fb": null,
      "inst": null,
      "vk": null,
      "created_at": "2016-04-17 20:09:17",
      "updated_at": "2016-05-26 10:33:22",
      "deleted_at": null,
      "start_at": "2016-06-01 00:00:00",
      "end_at": "2016-06-02 00:00:00",
      "total_views": 12,
      "total_likes": 0,
      "total_bookings": 0,
      "promo": 0,
      "routine": null,
      "booking_available": 0,
      "pincode": "2187",
      "tags": [
        {
          "id": 35,
          "slug": "eda-s-soboy",
          "name": "Еда с Собой",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/69f801331b994668b94e5ee7f2bc7bb1.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 35
          }
        },
        {
          "id": 9,
          "slug": "flipchart",
          "name": "Флипчарт",
          "parent_id": 10,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/aaa7544e689e53fd054af93cdc34a00e.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 9
          }
        },
        {
          "id": 31,
          "slug": "lektsii",
          "name": "Лекции",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 31
          }
        },
        {
          "id": 36,
          "slug": "yazyki",
          "name": "Языки",
          "parent_id": 31,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/4ade012bb1ea2a6540ecb2c15d3a20ba.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 36
          }
        },
        {
          "id": 43,
          "slug": "gitara",
          "name": "Гитара",
          "parent_id": 55,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/dd05f42aa4d5768b91a857d64591ebb7.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 43
          }
        },
        {
          "id": 3,
          "slug": "nastolki",
          "name": "Настолки",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 3
          }
        },
        {
          "id": 11,
          "slug": "knigi",
          "name": "Книги",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/aa4a3562a69cb6a352f5b626f651a7c4.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 11
          }
        },
        {
          "id": 58,
          "slug": "obshchenie",
          "name": "Общение",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/03bbe0cc963880a226e2891500975419.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 58
          }
        }
      ],
      "anticafes": [
        {
          "id": 22,
          "name": "Кочерга",
          "prices": "2 руб/мин\r\nстоп чек 500 руб\r\n",
          "city": "Москва",
          "metro": "м. Киевская",
          "phone": "+7(499)350-20-42",
          "event_address": null,
          "address": "Большая Дорогомиловская, 5к2",
          "excerpt": "",
          "description": "<p>Это не просто &laquo;еще одно антикафе&raquo;! &laquo;Кочергу&raquo; сделали люди, увлеченные рациональным мышлением и наукой, &mdash; чтобы отыскать побольше таких же увлеченных сообщников. Поэтому вы можете просто пить у нас чай с вайфаем, или можете участвовать в ежедневных мероприятиях: лекциях, играх, дебатах, воркшопах на разные темы (в области философии, психологии, математики, технологий).</p>\r\n",
          "logo": "0747816ef8165a0a202ab169b561eaef.jpg",
          "cover": "11d2306a6a60864b874fac8bc9397f24.jpg",
          "type": 0,
          "tw": "",
          "fb": "https://www.facebook.com/kocherga.club",
          "inst": "",
          "vk": "https://vk.com/kocherga_club",
          "created_at": "2016-02-29 06:17:55",
          "updated_at": "2016-05-25 21:49:17",
          "deleted_at": null,
          "start_at": null,
          "end_at": null,
          "total_views": 24,
          "total_likes": 2,
          "total_bookings": 0,
          "promo": 0,
          "routine": "пн-вс 11:00-23:00",
          "booking_available": 1,
          "pincode": "2187",
          "pivot": {
            "event_id": 72,
            "anticafe_id": 22
          }
        }
      ],
      "attachments": {
        "logo": "http://backend.anticafe.im/images/anticafes/logos/f5780945b190051ee473bbddeaed39e5.jpg",
        "cover": "http://backend.anticafe.im/images/anticafes/covers/f5780945b190051ee473bbddeaed39e5.jpg",
        "gallery": []
      },
      "images": []
    }
  ]
}
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    {
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "anticafe": [
    {
      "id": 72,
      "name": "Искусство общения: Королевство",
      "prices": "2 руб/мин",
      "city": null,
      "metro": null,
      "phone": null,
      "event_address": null,
      "address": null,
      "excerpt": "Театр импровизации: Королевство",
      "description": "<p>В честь того, что занятие по импровизации будет последним в этом &quot;сезоне&quot;, его будут проводить сами участники.<br />\r\nУже заявились Павел Новиков с разминкой и Михаил Беличенко с игрой про королевский двор.</p>\r\n\r\n<p>Также хотелось бы поговорить на тему разработки игр и перформансов, чтобы совершенствоваться в области импровизации, делать процессы более глубокими, захватывающими и философскими.</p>\r\n\r\n<p>Все, у кого есть опыт и идеи в этой области, смогут поделиться им ради общей пользы и процветания ;)<br />\r\nПриходите друзья!</p>\r\n",
      "logo": "f5780945b190051ee473bbddeaed39e5.jpg",
      "cover": "f5780945b190051ee473bbddeaed39e5.jpg",
      "type": 1,
      "tw": null,
      "fb": null,
      "inst": null,
      "vk": null,
      "created_at": "2016-04-17 20:09:17",
      "updated_at": "2016-05-26 10:33:22",
      "deleted_at": null,
      "start_at": "2016-06-01 00:00:00",
      "end_at": "2016-06-02 00:00:00",
      "total_views": 12,
      "total_likes": 0,
      "total_bookings": 0,
      "promo": 0,
      "routine": null,
      "booking_available": 0,
      "pincode": "2187",
      "tags": [
        {
          "id": 35,
          "slug": "eda-s-soboy",
          "name": "Еда с Собой",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/69f801331b994668b94e5ee7f2bc7bb1.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 35
          }
        },
        {
          "id": 9,
          "slug": "flipchart",
          "name": "Флипчарт",
          "parent_id": 10,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/aaa7544e689e53fd054af93cdc34a00e.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 9
          }
        },
        {
          "id": 31,
          "slug": "lektsii",
          "name": "Лекции",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 31
          }
        },
        {
          "id": 36,
          "slug": "yazyki",
          "name": "Языки",
          "parent_id": 31,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/4ade012bb1ea2a6540ecb2c15d3a20ba.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 36
          }
        },
        {
          "id": 43,
          "slug": "gitara",
          "name": "Гитара",
          "parent_id": 55,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/dd05f42aa4d5768b91a857d64591ebb7.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 43
          }
        },
        {
          "id": 3,
          "slug": "nastolki",
          "name": "Настолки",
          "parent_id": null,
          "is_group": 1,
          "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 3
          }
        },
        {
          "id": 11,
          "slug": "knigi",
          "name": "Книги",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/aa4a3562a69cb6a352f5b626f651a7c4.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 11
          }
        },
        {
          "id": 58,
          "slug": "obshchenie",
          "name": "Общение",
          "parent_id": null,
          "is_group": 0,
          "icon": "http://backend.anticafe.im//images/icons/tags/03bbe0cc963880a226e2891500975419.png",
          "pivot": {
            "anticafe_id": 72,
            "tag_id": 58
          }
        }
      ],
      "anticafes": [
        {
          "id": 22,
          "name": "Кочерга",
          "prices": "2 руб/мин\r\nстоп чек 500 руб\r\n",
          "city": "Москва",
          "metro": "м. Киевская",
          "phone": "+7(499)350-20-42",
          "event_address": null,
          "address": "Большая Дорогомиловская, 5к2",
          "excerpt": "",
          "description": "<p>Это не просто &laquo;еще одно антикафе&raquo;! &laquo;Кочергу&raquo; сделали люди, увлеченные рациональным мышлением и наукой, &mdash; чтобы отыскать побольше таких же увлеченных сообщников. Поэтому вы можете просто пить у нас чай с вайфаем, или можете участвовать в ежедневных мероприятиях: лекциях, играх, дебатах, воркшопах на разные темы (в области философии, психологии, математики, технологий).</p>\r\n",
          "logo": "0747816ef8165a0a202ab169b561eaef.jpg",
          "cover": "11d2306a6a60864b874fac8bc9397f24.jpg",
          "type": 0,
          "tw": "",
          "fb": "https://www.facebook.com/kocherga.club",
          "inst": "",
          "vk": "https://vk.com/kocherga_club",
          "created_at": "2016-02-29 06:17:55",
          "updated_at": "2016-05-25 21:49:17",
          "deleted_at": null,
          "start_at": null,
          "end_at": null,
          "total_views": 24,
          "total_likes": 2,
          "total_bookings": 0,
          "promo": 0,
          "routine": "пн-вс 11:00-23:00",
          "booking_available": 1,
          "pincode": "2187",
          "pivot": {
            "event_id": 72,
            "anticafe_id": 22
          }
        }
      ],
      "attachments": {
        "logo": "http://backend.anticafe.im/images/anticafes/logos/f5780945b190051ee473bbddeaed39e5.jpg",
        "cover": "http://backend.anticafe.im/images/anticafes/covers/f5780945b190051ee473bbddeaed39e5.jpg",
        "gallery": []
      },
      "images": []
    }
  ]
}
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    [
  {
    "id": 3,
    "slug": "nastolki",
    "name": "Настолки",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png"
  },
  {
    "id": 10,
    "slug": "ko-vorking",
    "name": "Ко-воркинг",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
  },
  {
    "id": 31,
    "slug": "lektsii",
    "name": "Лекции",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png"
  },
  {
    "id": 53,
    "slug": "tantsy",
    "name": "Танцы",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/74c3617ddc5b7ca3c8f372aa3fcfc180.png"
  },
  {
    "id": 54,
    "slug": "pristavki",
    "name": "Приставки",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
  },
  {
    "id": 55,
    "slug": "muzyka",
    "name": "Музыка",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
  },
  {
    "id": 58,
    "slug": "obshchenie",
    "name": "Общение",
    "parent_id": null,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/03bbe0cc963880a226e2891500975419.png"
  },
  {
    "id": 999999999,
    "slug": "prochee",
    "name": "Прочее",
    "parent_id": null,
    "is_group": 1,
    "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
  }
]
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    [
  {
    "id": 1,
    "slug": "xbox",
    "name": "Xbox",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  },
  {
    "id": 5,
    "slug": "proektor",
    "name": "Проектор",
    "parent_id": 10,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/9209d718cdc8a7878a6cbb5ef2f41f55.png",
    "tag": "Ко-воркинг",
    "group": {
      "id": 10,
      "slug": "ko-vorking",
      "name": "Ко-воркинг",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
    }
  },
  {
    "id": 6,
    "slug": "playstation",
    "name": "PlayStation",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  },
  {
    "id": 7,
    "slug": "mfu",
    "name": "МФУ",
    "parent_id": 10,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/58e87a4860a7ff751daf0a3b78e289d6.png",
    "tag": "Ко-воркинг",
    "group": {
      "id": 10,
      "slug": "ko-vorking",
      "name": "Ко-воркинг",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
    }
  },
  {
    "id": 9,
    "slug": "flipchart",
    "name": "Флипчарт",
    "parent_id": 10,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/aaa7544e689e53fd054af93cdc34a00e.png",
    "tag": "Ко-воркинг",
    "group": {
      "id": 10,
      "slug": "ko-vorking",
      "name": "Ко-воркинг",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
    }
  },
  {
    "id": 12,
    "slug": "guitarhero",
    "name": "GuitarHero",
    "parent_id": 55,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/dd05f42aa4d5768b91a857d64591ebb7.png",
    "tag": "Музыка",
    "group": {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
    }
  },
  {
    "id": 13,
    "slug": "ping-pong",
    "name": "Пинг-понг",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/bc4bf053c6b690a0ea0cf52bb7437f28.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 16,
    "slug": "karaoke",
    "name": "Караоке",
    "parent_id": 55,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/9216dd0ccb1da52f71d44248f94db097.png",
    "tag": "Музыка",
    "group": {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
    }
  },
  {
    "id": 18,
    "slug": "kriket",
    "name": "Крикет",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/a9598421ef5ba1c5db4ff609dc715b9d.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 19,
    "slug": "badminton",
    "name": "Бадминтон",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/537522fdbbf6a97a0b811460bb1352fc.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 20,
    "slug": "pin-bol",
    "name": "Пин-бол",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/a2b9ba2cd1f99579ba96bf88c40e47e6.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 21,
    "slug": "barabannaya-ustanovka",
    "name": "Барабанная установка",
    "parent_id": 55,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/a2b9ba2cd1f99579ba96bf88c40e47e6.png",
    "tag": "Музыка",
    "group": {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
    }
  },
  {
    "id": 23,
    "slug": "kinect",
    "name": "Kinect",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  },
  {
    "id": 26,
    "slug": "manga",
    "name": "Манга",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/eecfc635c29408cb08f2ee3fbaf7130d.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 28,
    "slug": "dendy",
    "name": "Dendy",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  },
  {
    "id": 33,
    "slug": "justdance",
    "name": "JustDance",
    "parent_id": 53,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/f52a8c1774960362133b0201b5a63251.png",
    "tag": "Танцы",
    "group": {
      "id": 53,
      "slug": "tantsy",
      "name": "Танцы",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/74c3617ddc5b7ca3c8f372aa3fcfc180.png"
    }
  },
  {
    "id": 36,
    "slug": "yazyki",
    "name": "Языки",
    "parent_id": 31,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/4ade012bb1ea2a6540ecb2c15d3a20ba.png",
    "tag": "Лекции",
    "group": {
      "id": 31,
      "slug": "lektsii",
      "name": "Лекции",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png"
    }
  },
  {
    "id": 38,
    "slug": "segamegadrive",
    "name": "SegaMegaDrive",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/55351eb9d9cad9569ad8e37432c3a377.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  },
  {
    "id": 39,
    "slug": "madzhong",
    "name": "Маджонг",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/d38f9cf2a580777a0520eb3b767ab357.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 41,
    "slug": "multitouch-stoly-oqtopus",
    "name": "Multitouch столы ОQTOPUS",
    "parent_id": 10,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/4bf8d0e8749fb3573439a8853d143728.png",
    "tag": "Ко-воркинг",
    "group": {
      "id": 10,
      "slug": "ko-vorking",
      "name": "Ко-воркинг",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
    }
  },
  {
    "id": 42,
    "slug": "kiker",
    "name": "Кикер",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/c7bf3881481d9e2634a6ef553f755529.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 43,
    "slug": "gitara",
    "name": "Гитара",
    "parent_id": 55,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/dd05f42aa4d5768b91a857d64591ebb7.png",
    "tag": "Музыка",
    "group": {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
    }
  },
  {
    "id": 44,
    "slug": "kinozal",
    "name": "Кинозал",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/8cc44f5b6b03aec803b76e0a5f1a9f07.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 45,
    "slug": "nastolnyy-khokkey",
    "name": "Настольный хоккей",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/a2b9ba2cd1f99579ba96bf88c40e47e6.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 46,
    "slug": "oculus-rift",
    "name": "Oculus Rift",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im/images/default-icon.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  },
  {
    "id": 47,
    "slug": "bilyard",
    "name": "Бильярд",
    "parent_id": 999999999,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/7f513bd87b443fe0e64696c500fdaa27.png",
    "tag": "Прочее",
    "group": {
      "id": 999999999,
      "slug": "prochee",
      "name": "Прочее",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
    }
  },
  {
    "id": 48,
    "slug": "pianino",
    "name": "Пианино",
    "parent_id": 55,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/19ebfeb50b9ff5b55ac794fd0c651cb0.png",
    "tag": "Музыка",
    "group": {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
    }
  },
  {
    "id": 49,
    "slug": "dj-hero",
    "name": "DJ Hero",
    "parent_id": 55,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/e6cd6e9652435d249dcf3048fb35c2b3.png",
    "tag": "Музыка",
    "group": {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
    }
  },
  {
    "id": 50,
    "slug": "wii",
    "name": "Wii",
    "parent_id": 54,
    "is_group": 0,
    "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
    "tag": "Приставки",
    "group": {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
    }
  }
]
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    {
  "id": 1,
  "name": "Jeffrey's Coffee (Арбат)",
  "prices": "2 руб/мин",
  "city": "Москва",
  "metro": "м. Арбатская",
  "phone": "+7(495)411-39-67",
  "event_address": null,
  "address": "Староконюшенный пер., 45",
  "excerpt": "<p>Тайм-кофейня американского формата в историческом центре Москвы. Стильный интерьер, фирменный лось Джоффри, прекрасный кофе и профессиональный бариста - вот отличительные черты тайм-кофеен Jeffrey&#39;s. Кроме этого приятным бонусом идут снеки, сладости, разнообразные сиропы и прочие вкусняшки, а также игровые приставки, кикер, настольные игры и регулярные мероприятия вплоть до киноночей.</p>\r\n",
  "description": "<p>Тайм-кофейня американского формата в историческом центре Москвы. Стильный интерьер, фирменный лось Джоффри, прекрасный кофе и профессиональный бариста - вот отличительные черты тайм-кофеен Jeffrey&#39;s. Кроме этого приятным бонусом идут снеки, сладости, разнообразные сиропы и прочие вкусняшки, а также игровые приставки, кикер, настольные игры и регулярные мероприятия вплоть до киноночей.</p>\r\n",
  "logo": "9285eb718ea51d618922b50fda017062.jpg",
  "cover": "1b15ff6ec498c265ee5283cc20979f85.jpg",
  "type": 0,
  "tw": "twitter.com",
  "fb": "https://www.facebook.com/Jeffreys.Arbat/?ref=bookmarks",
  "inst": "https://www.instagram.com/",
  "vk": "https://vk.com/jeffreys_arbat",
  "created_at": "2016-02-17 03:23:39",
  "updated_at": "2016-05-26 10:37:32",
  "deleted_at": null,
  "start_at": null,
  "end_at": null,
  "total_views": 19,
  "total_likes": 0,
  "total_bookings": 0,
  "promo": 0,
  "routine": "пн-пт  8:30 - 23:00 , сб-вск 10:00 - 23:00",
  "booking_available": 1,
  "pincode": "2187",
  "tags": [
    {
      "id": 6,
      "slug": "playstation",
      "name": "PlayStation",
      "parent_id": 54,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 6
      },
      "group": {
        "id": 54,
        "slug": "pristavki",
        "name": "Приставки",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
      }
    },
    {
      "id": 3,
      "slug": "nastolki",
      "name": "Настолки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 3
      }
    },
    {
      "id": 5,
      "slug": "proektor",
      "name": "Проектор",
      "parent_id": 10,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/9209d718cdc8a7878a6cbb5ef2f41f55.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 5
      },
      "group": {
        "id": 10,
        "slug": "ko-vorking",
        "name": "Ко-воркинг",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
      }
    },
    {
      "id": 14,
      "slug": "nastolnyy-futbol",
      "name": "Настольный футбол",
      "parent_id": null,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/c7bf3881481d9e2634a6ef553f755529.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 14
      }
    },
    {
      "id": 11,
      "slug": "knigi",
      "name": "Книги",
      "parent_id": null,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/aa4a3562a69cb6a352f5b626f651a7c4.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 11
      }
    },
    {
      "id": 43,
      "slug": "gitara",
      "name": "Гитара",
      "parent_id": 55,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/dd05f42aa4d5768b91a857d64591ebb7.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 43
      },
      "group": {
        "id": 55,
        "slug": "muzyka",
        "name": "Музыка",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png"
      }
    },
    {
      "id": 42,
      "slug": "kiker",
      "name": "Кикер",
      "parent_id": 999999999,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/c7bf3881481d9e2634a6ef553f755529.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 42
      },
      "group": {
        "id": 999999999,
        "slug": "prochee",
        "name": "Прочее",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
      }
    },
    {
      "id": 10,
      "slug": "ko-vorking",
      "name": "Ко-воркинг",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 10
      }
    },
    {
      "id": 9,
      "slug": "flipchart",
      "name": "Флипчарт",
      "parent_id": 10,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/aaa7544e689e53fd054af93cdc34a00e.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 9
      },
      "group": {
        "id": 10,
        "slug": "ko-vorking",
        "name": "Ко-воркинг",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png"
      }
    },
    {
      "id": 31,
      "slug": "lektsii",
      "name": "Лекции",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 31
      }
    },
    {
      "id": 36,
      "slug": "yazyki",
      "name": "Языки",
      "parent_id": 31,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/4ade012bb1ea2a6540ecb2c15d3a20ba.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 36
      },
      "group": {
        "id": 31,
        "slug": "lektsii",
        "name": "Лекции",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png"
      }
    },
    {
      "id": 55,
      "slug": "muzyka",
      "name": "Музыка",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 55
      }
    },
    {
      "id": 58,
      "slug": "obshchenie",
      "name": "Общение",
      "parent_id": null,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/03bbe0cc963880a226e2891500975419.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 58
      }
    },
    {
      "id": 54,
      "slug": "pristavki",
      "name": "Приставки",
      "parent_id": null,
      "is_group": 1,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 54
      }
    },
    {
      "id": 13,
      "slug": "ping-pong",
      "name": "Пинг-понг",
      "parent_id": 999999999,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/bc4bf053c6b690a0ea0cf52bb7437f28.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 13
      },
      "group": {
        "id": 999999999,
        "slug": "prochee",
        "name": "Прочее",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
      }
    },
    {
      "id": 44,
      "slug": "kinozal",
      "name": "Кинозал",
      "parent_id": 999999999,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/8cc44f5b6b03aec803b76e0a5f1a9f07.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 44
      },
      "group": {
        "id": 999999999,
        "slug": "prochee",
        "name": "Прочее",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png"
      }
    },
    {
      "id": 1,
      "slug": "xbox",
      "name": "Xbox",
      "parent_id": 54,
      "is_group": 0,
      "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
      "pivot": {
        "anticafe_id": 1,
        "tag_id": 1
      },
      "group": {
        "id": 54,
        "slug": "pristavki",
        "name": "Приставки",
        "parent_id": null,
        "is_group": 1,
        "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png"
      }
    }
  ],
  "attachments": {
    "logo": "http://backend.anticafe.im/images/anticafes/logos/9285eb718ea51d618922b50fda017062.jpg",
    "cover": "http://backend.anticafe.im/images/anticafes/covers/1b15ff6ec498c265ee5283cc20979f85.jpg",
    "gallery": [
      "http://backend.anticafe.im/images/anticafes/gallery/oAQ-xYyynJY.jpg",
      "http://backend.anticafe.im/images/anticafes/gallery/FDtokFbKVyE.jpg"
    ]
  },
  "events": []
}
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
    {
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "client": {
    "id": 1,
    "first_name": "Алексей",
    "last_name": "Вконтактовский",
    "phone": "+79502749708",
    "email": "scrobot91@gmail.com",
    "avatar": "http://cs7001.vk.me/v7001872/114d1/lQjM7nrWVeM.jpg",
    "get_notifications": null,
    "get_news": null,
    "social_profile_link": null,
    "authToken": "S0fTJRqiZr0W3oY9oNVRWbxyBeZ0Gelt",
    "vkontakte": 1,
    "facebook": 0,
    "vk_uid": 178685292,
    "fb_uid": null,
    "vk_token": "2c8faef5a6bb8b00ba696cbbca5e4e50bf4dffa9230d51b8cb165fcf17bdfe46798d68334097697f5324d",
    "fb_token": null,
    "coupon": null,
    "coupon_repaid": 1,
    "likes": [
      {
        "id": 18,
        "name": "TimeTerria",
        "prices": "1 час 3 руб/мин, далее 2 руб/мин",
        "city": "Москва",
        "metro": "м. Новослободская\r\n",
        "phone": "+7(999)800-03-30",
        "event_address": null,
        "address": "2-й Щемиловский переулок, 4",
        "excerpt": "<p>Позволить себе быть современным, ярким и настоящим теперь стоит всего ничего! Антикафе Timeterria &nbsp;LiPeople &mdash; это новое остромодное место столицы, которое по праву можно назвать уникальным.&nbsp;</p>\r\n",
        "description": "<p>Позволить себе быть современным, ярким и настоящим теперь стоит всего ничего! АнтиКафе TimeTerria&nbsp;&mdash; это новое остромодное место столицы, которое по праву можно назвать уникальным.&nbsp;Молодежи больше не нужно тратить неоправданных денег для того, чтобы познакомиться с интересными людьми, посетить светское &nbsp;мероприятие, посмотреть новинки кинематографа или провести бизнес-конференцию. Все это уже есть в АнтиКафе TimeTerria.</p>\r\n",
        "logo": "aa6bc94a1cce34e24bc8036286df2ead.jpg",
        "cover": "ebb49c1730ebf1d5db9010afd2e5c1dd.jpg",
        "type": 0,
        "tw": "",
        "fb": "",
        "inst": "",
        "vk": "https://vk.com/timeterria2012",
        "created_at": "2016-02-29 06:01:30",
        "updated_at": "2016-05-26 10:21:03",
        "deleted_at": null,
        "start_at": null,
        "end_at": null,
        "total_views": 110,
        "total_likes": 9,
        "total_bookings": 2,
        "promo": 0,
        "routine": "пн-чт 10:30 - 23:30, пт 10:30 - 06:00, сб 12:00 - 06:00, вс 12:00 - 00-00",
        "booking_available": 1,
        "pincode": "2187",
        "tags": [
          {
            "id": 1,
            "slug": "xbox",
            "name": "Xbox",
            "parent_id": 54,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 1
            }
          },
          {
            "id": 10,
            "slug": "ko-vorking",
            "name": "Ко-воркинг",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/2eea25a3bd8d9937be075982e99611a7.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 10
            }
          },
          {
            "id": 3,
            "slug": "nastolki",
            "name": "Настолки",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/13c4d29976b9147d6c71213b4322b022.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 3
            }
          },
          {
            "id": 54,
            "slug": "pristavki",
            "name": "Приставки",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 54
            }
          },
          {
            "id": 23,
            "slug": "kinect",
            "name": "Kinect",
            "parent_id": 54,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 23
            }
          },
          {
            "id": 46,
            "slug": "oculus-rift",
            "name": "Oculus Rift",
            "parent_id": 54,
            "is_group": 0,
            "icon": "http://backend.anticafe.im/images/default-icon.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 46
            }
          },
          {
            "id": 50,
            "slug": "wii",
            "name": "Wii",
            "parent_id": 54,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/39b27ee8d375361bba003e139a89e0bc.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 50
            }
          },
          {
            "id": 35,
            "slug": "eda-s-soboy",
            "name": "Еда с Собой",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/69f801331b994668b94e5ee7f2bc7bb1.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 35
            }
          },
          {
            "id": 37,
            "slug": "kalyan",
            "name": "Кальян",
            "parent_id": null,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/8ea2ed8e76ed00bbe864fab17222e68f.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 37
            }
          },
          {
            "id": 16,
            "slug": "karaoke",
            "name": "Караоке",
            "parent_id": 55,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/9216dd0ccb1da52f71d44248f94db097.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 16
            }
          },
          {
            "id": 44,
            "slug": "kinozal",
            "name": "Кинозал",
            "parent_id": 999999999,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/8cc44f5b6b03aec803b76e0a5f1a9f07.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 44
            }
          },
          {
            "id": 11,
            "slug": "knigi",
            "name": "Книги",
            "parent_id": null,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/aa4a3562a69cb6a352f5b626f651a7c4.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 11
            }
          },
          {
            "id": 5,
            "slug": "proektor",
            "name": "Проектор",
            "parent_id": 10,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/9209d718cdc8a7878a6cbb5ef2f41f55.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 5
            }
          },
          {
            "id": 7,
            "slug": "mfu",
            "name": "МФУ",
            "parent_id": 10,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/58e87a4860a7ff751daf0a3b78e289d6.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 7
            }
          },
          {
            "id": 9,
            "slug": "flipchart",
            "name": "Флипчарт",
            "parent_id": 10,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/aaa7544e689e53fd054af93cdc34a00e.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 9
            }
          },
          {
            "id": 31,
            "slug": "lektsii",
            "name": "Лекции",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/5291e737f70c27be34a8493c2f6395ec.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 31
            }
          },
          {
            "id": 36,
            "slug": "yazyki",
            "name": "Языки",
            "parent_id": 31,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/4ade012bb1ea2a6540ecb2c15d3a20ba.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 36
            }
          },
          {
            "id": 39,
            "slug": "madzhong",
            "name": "Маджонг",
            "parent_id": 999999999,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/d38f9cf2a580777a0520eb3b767ab357.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 39
            }
          },
          {
            "id": 55,
            "slug": "muzyka",
            "name": "Музыка",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/3f6c5bad732143765f17c91bfe656a97.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 55
            }
          },
          {
            "id": 48,
            "slug": "pianino",
            "name": "Пианино",
            "parent_id": 55,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/19ebfeb50b9ff5b55ac794fd0c651cb0.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 48
            }
          },
          {
            "id": 14,
            "slug": "nastolnyy-futbol",
            "name": "Настольный футбол",
            "parent_id": null,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/c7bf3881481d9e2634a6ef553f755529.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 14
            }
          },
          {
            "id": 58,
            "slug": "obshchenie",
            "name": "Общение",
            "parent_id": null,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/03bbe0cc963880a226e2891500975419.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 58
            }
          },
          {
            "id": 999999999,
            "slug": "prochee",
            "name": "Прочее",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/46510d387392ada1852aacacabd6f520.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 999999999
            }
          },
          {
            "id": 53,
            "slug": "tantsy",
            "name": "Танцы",
            "parent_id": null,
            "is_group": 1,
            "icon": "http://backend.anticafe.im//images/icons/tags/74c3617ddc5b7ca3c8f372aa3fcfc180.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 53
            }
          },
          {
            "id": 33,
            "slug": "justdance",
            "name": "JustDance",
            "parent_id": 53,
            "is_group": 0,
            "icon": "http://backend.anticafe.im//images/icons/tags/f52a8c1774960362133b0201b5a63251.png",
            "pivot": {
              "anticafe_id": 18,
              "tag_id": 33
            }
          }
        ],
        "events": [],
        "attachments": {
          "logo": "http://backend.anticafe.im/images/anticafes/logos/aa6bc94a1cce34e24bc8036286df2ead.jpg",
          "cover": "http://backend.anticafe.im/images/anticafes/covers/ebb49c1730ebf1d5db9010afd2e5c1dd.jpg",
          "gallery": []
        },
        "pivot": {
          "client_id": 1,
          "anticafe_id": 18
        }
      }
    ],
    "bookings": [{
      "id": 108,
      "anticafe": "Anticafe.im",
      "address": "Кремль, 4 этаж",
      "type": "Антикафе",
      "arrivalAt": "27.05 в 13:00",
      "countOfCustomers": 2,
      "comment": "test tes test",
      "status": "В процессе",
      "anticafe_id": 62
    }]
  }
}
</pre>
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
                        <p><strong>common json structure</strong></p>
<pre>
{
  "status": 200,
  "error": false,
  "needAuth": false,
  "message": "",
  "booking": {
    "id": 108,
    "anticafe": "Anticafe.im",
    "address": "Кремль, 4 этаж",
    "type": "Антикафе",
    "arrivalAt": "27.05 в 13:00",
    "countOfCustomers": 2,
    "comment": "test tes test",
    "status": "В процессе",
    "anticafe_id": 62
  }
}
</pre>
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
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/prepaid"><abbr title="/api/prepaid">/api/prepaid</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(string) pincode</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postLike</a>(Illuminate\Http\Request $request)
                        <p>
                            This method execute pincode check. And find anticafe with this pincode and set current user property coupon_prepaid = true;<br/>
                        <strong>success json:</strong>
<pre>{
    "status" => 200,
    "error" => false,
    "needAuth" => true,
    "message" => "Код успешно погашен",
}</pre>

                        <strong>failed json:</strong>
<pre>{
    "status" => 500,
    "error" => true,
    "needAuth" => true,
    "message" => "Неверный пинкод",
}</pre>                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/app-installed"><abbr title="/api/app-installed">/api/app-installed</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(string) type. Receiving values: "ios", "android"</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postAppInstalled</a>(Illuminate\Http\Request $request)
                        <p>
                            Statistics Aggregation method. Send request on this URL once on first creating application.
                        <strong>success json:</strong>
<pre>{
    "status" => 200,
    "error" => false,
    "needAuth" => true,
    "message" => "",
}</pre>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <p><strong>POST</strong></p>
                    </div>
                    <div class="col-md-2 type">
                        <a href="/api/button-pressed"><abbr title="/api/button-pressed">/api/button-pressed</abbr></a>
                    </div>
                    <div class="col-md-2">
                        <strong>Params</strong>
                        <p>(string) type. Receiving values: "ios", "android"</p>
                        <p>(string) button. Receiving values: "search", "anticafe", "events"</p>
                    </div>
                    <div class="col-md-7 type">
                        <a href="#">postButtonPressed</a>(Illuminate\Http\Request $request)
                        <p>
                            Statistics Aggregation method. Send request on this URL than user click one of the buttons.
                        <strong>success json:</strong>
<pre>{
    "status" => 200,
    "error" => false,
    "needAuth" => true,
    "message" => "",
}</pre>
                     </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
