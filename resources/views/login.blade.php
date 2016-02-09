<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{trans('staff::staff.auth.name')}} | PinERP</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="/staff/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="/staff/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/staff/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/staff/js/ie10-viewport-bug-workaround.js"></script>
</head>

<body>

<div class="container">


    @if (isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        {!! Form::open(['action' => '\Anticafe\Http\Controllers\Auth\AuthController@postLogin']) !!}
            {{Form::label()}}
        {!! Form::close() !!}
    <form class="form-signin" action="{{action('\Pinerp\Staff\Controllers\AuthController@postLogin')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h2 class="form-signin-heading">{{trans('staff::staff.auth.name')}}</h2>
        <label for="inputEmail" class="sr-only">{{trans('staff::staff.auth.login')}}</label>
        <input type="text" id="inputEmail" name="username" class="form-control" placeholder="{{trans('staff::staff.auth.login')}}" value="{{old('username')}}" required autofocus>
        <label for="inputPassword" class="sr-only">{{trans('staff::staff.auth.password')}}</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="{{trans('staff::staff.auth.password')}}" required>
        <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>

</div> <!-- /container -->

</body>
</html>
