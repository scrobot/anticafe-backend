<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>
        @section('title')
            {!! config('layout.title') !!}
        @endsection
    </title>
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">

        $(function () {

            $('a.btn-danger').on("click", function (e) {

                if (!confirm("Подтвердите действие")) {
                    e.preventDefault();
                } else {
                    //
                }

            });

        });

    </script>
    
    @yield('head')

</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand">Администрирование</span>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">

            </ul>

        </div>
    </div>
</nav>

<div class="container-fluid">

    <div class="row">

        <div class="col-md-2">


                <ul class="nav nav-pills nav-stacked">

                </ul>


        </div>

        <div class="col-md-9">

            {{-- messages --}}
            <div class="row">
                <div class="col-md-12">
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
                </div>
            </div>
            {{-- /messages --}}

            <div class="row">
                <div class="col-md-12">

                    {{-- breadcrumbs --}}
                    <ul class="breadcrumb">
                        @yield('breadcrumbs')
                    </ul>
                    {{-- /breadcrumbs --}}

                    @yield('actions_menu')

                    {{-- content --}}
                    @yield('content')
                    {{-- /content --}}

                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>
