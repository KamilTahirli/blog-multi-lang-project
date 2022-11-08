<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.site_name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	<script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.site_name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <div class="nav-item dropdown float-right" style="margin-right: 10px;">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								@if(Config::get('languages')[App::getLocale()] === 'az')
								<img style="width:20px; height:20px;" src="{{asset('frontend/icon/az.svg')}}">
								@endif
								@if(Config::get('languages')[App::getLocale()] === 'en')
								<img style="width:20px; height:20px;" src="{{asset('frontend/icon/en.svg')}}">
								@endif
								@if(Config::get('languages')[App::getLocale()] === 'ru')
								<img style="width:20px; height:20px;" src="{{asset('frontend/icon/ru.svg')}}">
								@endif
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								@foreach (Config::get('languages') as $lang => $language)
								@if ($lang != App::getLocale())
								<a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">
									@if($language == 'az') <div class="d-flex align-items-center">
										<b>{{__('translate.lang_az')}}</b></div> @endif
									@if($language == 'en') <div class="d-flex align-items-center">
										<b>{{__('translate.lang_en')}}</b></div> @endif
									@if($language == 'ru') <div class="d-flex align-items-center">
										<b>{{__('translate.lang_ru')}}</b></div> @endif
								</a>
								@endif
								@endforeach
							</div>
						</div>
                    <!-- Right Side Of Navbar -->

                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
