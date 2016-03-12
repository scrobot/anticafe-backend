<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Авторизация через соц.сети</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300,300italic,400italic,500,500italic,700italic,700,900,900italic&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        a {
            display: block;
            margin: 0 auto;
            width: 50%;
        }

        a img {
            text-align: center;
            width: 100%;
            height: auto;
            margin: 2% 0;
        }
    </style>

    @yield('css')
</head>
<body id="app-layout">

<div class="container-fluid">
    <div class="row">
        <h1 class="text-center">Войти через соц.сети</h1>
        <br/>
        <a href="/api/auth/vk"><img src="/images/vk.png"/></a>
        <a href="/api/auth/fb"><img src="/images/fb.png"/></a>
    </div>
</div>



<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>
