<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>InfoMap</title>
    <link rel="shortcut icon" href="{{ asset('/logo-image/Travel-map-icon.png')}}" type="image/png">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper" id='warder'>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <!-- {{ config('app.name', 'InfoMap') }} -->
                    InfoMap
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item" @click='initialization = "login"'>
                                <a class="nav-link" data-toggle="modal" data-target="#initWindow">{{ __('Вхід') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item" @click='initialization = "register"'>
                                    <a class="nav-link" data-toggle="modal" data-target="#initWindow">{{ __('Реєстрація') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right text-center" style='padding: 0' aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item exit-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Вихід') }}
                                        <i class='fas fa-sign-out-alt'></i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Modal -->
        <button type="hidden" class="btn btn-primary removeButton" data-toggle="modal" data-target="#removeForms">
        </button>
        
        <div class="modal fade" id="removeForms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Видалення</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Ви справді хочете видалити?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ні</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click='removeData(locationId)'>Так</button>
                    </div>
                </div>
            </div>
        </div>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <!-- <script src="{{asset('js/jquery.scrollbar.min.js')}}"></script> -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCheUi_teeeCbBHW3niSAj3QaTvJgTNTRk"
    async defer></script>
</body>
</html>
