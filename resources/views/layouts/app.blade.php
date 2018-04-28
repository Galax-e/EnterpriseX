<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500,600|Material+Icons" rel="stylesheet" type="text/css">
    
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        body{
            font: 300 26px/36px Roboto, "Proxima Nova", Arial, serif;
        }
        .middle-box{
            width: 500px !important;
            max-width: 500px !important;
            background-color: ;
        }
        .ibox-content{
            padding: 10px 25px;
        }
    </style>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">Ent-X</h1>
            </div>
            </br>
            <h3>Welcome!</h3>
            <!--<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            </p> -->
             @yield('content')
            <p class="m-t"> <small>Enterprise-X web app productivity tool &copy; 2018</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>

