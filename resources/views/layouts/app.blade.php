<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title or "Laravel"}} | Антикафе Backend</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300,300italic,400italic,500,500italic,700italic,700,900,900italic&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dropzone/basic.min.css" rel="stylesheet">
    <link href="/css/dropzone/dropzone.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield('css')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Навигация</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Anticafe Backend
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Консоль</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Войти</a></li>
                        <li><a href="{{ url('/register') }}">Зарегистрироваться</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выйти</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if(Session::get('msg'))
        <div class="alert alert-success" role="alert">{{trans(Session::get('msg'))}}</div>
    @endif

    @if($errors->count())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $msg)
                <p>{{trans($msg)}}</p>
            @endforeach
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                    <h3>Основное</h3>
                    <li><a href="{{route('anticafes')}}">Антикафе</a></li>
                    <li><a href="{{route('events')}}">Cобытия</a></li>
                    <li><a href="{{route('tags')}}">Теги и Возможности</a></li>
                    <li><a href="{{route('bookings')}}">Бронирования</a></li>
                    <li><a href="{{route('clients')}}">Клиенты приложения</a></li>
                    <h3>Права и роли</h3>
                    <li><a href="{{route('users')}}">Менеджеры и администраторы</a></li>
                    <li><a href="#">Права</a></li>
                    <li><a href="#">Роли</a></li>
                    <h3>Опции</h3>
                    <li><a href="{{route('ioptions')}}">Опции изображений</a></li>
                    <h3>API</h3>
                    <li><a href="{{route('api.doc')}}">Документация</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                {{-- breadcrumbs --}}
                <ul class="breadcrumb">
                    @yield('breadcrumbs')
                </ul>

                @yield('actions_menu')

                {{-- /breadcrumbs --}}
                @yield('content')
            </div>
        </div>
    </div>



    <!-- JavaScripts --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="/js/dropzone.min.js"></script>
    <script src="/js/dropzone-amd-module.min.js"></script>
    <script src="/js/image-handler.js"></script>
    <script type="text/javascript">

        $(function () {

            $('.btn-danger').on("click", function (e) {

                if (!confirm("Подтвердите действие")) {
                    e.preventDefault();
                } else {
                    //
                }

            });

        });

    </script>
    @yield('js')
</body>
</html>
