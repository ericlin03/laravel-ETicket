<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ETicket') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.0.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <link href="css/bootstrap-4.0.0.css" rel="stylesheet">
    <link href="test.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico"/>
<link rel="bookmark" href="/favicon.ico"/>

</head>

<body>
    <div>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/backhome') }}">
                        {{ config('app.name', 'ETicket') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link ecolor bcl bcr" href="/programsmanager">　管理活動　<span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item active white">
                                <a class="nav-link ecolor bcr" href="/newprogram">　新增節目　</a>
                            </li>
                            <li class="nav-item active white">
                                <a class="nav-link ecolor bcr" href="/newpost">　發布公告　</a>
                            </li>
                            <li class="nav-item active white">
                                <a class="nav-link ecolor bcr" href="/transferToOrganizer">　轉帳給主辦方　</a>
                            </li>
                            <li class="nav-item active white">
                                <a class="nav-link ecolor bcr" href="/deposite">　新增平台幣　</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('登入') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('註冊') }}</a>
                            </li>
                            @endif
                            @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('登出') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                <script src="js/jquery-3.2.1.min.js"></script>
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="js/popper.min.js"></script>
                <script src="js/bootstrap-4.0.0.js"></script>
                <script src="js/main.js"></script>
                <script src="./dist/js/index.js"></script>
            </main>
        </div>
        <footer class="text-center" style="right: 0;bottom: 0;left: 0;">
            <div class=" text-white bg-dark p-4">
                <div class="row text-center col-12">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-12">
                        <ul class="nav">
                            <li class="nav-item col-2 col-md-2 col-lg-2">
                            </li>
                            <li class="nav-item col-2 col-md-2 col-lg-2">
                                <a class="nav-link" href="">購票流程說明</a>
                            </li>
                            <li class="nav-item col-2 col-md-2 col-lg-2">
                                <a class="nav-link" href="{{url('clause')}}">服務條款</a>
                            </li>
                            <li class="nav-item col-2 col-md-2 col-lg-2">
                                <a class="nav-link" href="#">隱私權政策</a>
                            </li>
                            <li class="nav-item col-2 col-md-2 col-lg-2">
                                <a class="nav-link" href="#">加入我們</a>
                            </li>
                            <li class="nav-item col-2 col-md-2 col-lg-2">
                            </li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="row text-center">
                    <div class="col-4 col-md-4 col-lg-4">
                        <a data-toggle="tooltip" data-placement="bottom" title="關於我們" target="_blank"
                            href="#"><strong>ETicket票務平台</strong></a>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4">
                        <span data-toggle="tooltip" data-placement="bottom"
                            title="(Mon-Fri 9:30am–8:00pm Sat.11:00am-7:00pm)">客服專線:
                            02-22227777</span>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4">
                        <a data-toggle="tooltip" data-placement="bottom" title="send now!" target="_blank"
                            href="https://mail.google.com/mail/?view=cm&fs=1&to=ETicket@gmail.com">客服信箱:
                            ETicket@gmail.com</a>
                    </div>
                </div>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <p>CopyrightcETicket Corporation. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
        </footer>
        <div>
</body>

</html>