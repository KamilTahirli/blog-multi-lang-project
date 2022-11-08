<!doctype html>
<html class="no-js" lang="{{  app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.site_name') }} / @yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/normalize.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome-all.min.css') }}">
    <!-- Flat Icon CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/font/flaticon.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <!-- Popup CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/meanmenu.min.css') }}">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/OwlCarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/OwlCarousel/owl.theme.default.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <!-- Modernize js -->
    <script src="{{ asset('frontend/js/modernizr-3.6.0.min.js') }}"></script>
</head>

<body class="sticky-header">


    <div id="wrapper" class="wrapper">
        <!-- Header Area Start Here -->
        <header class="has-mobile-menu">
            <div id="header-middlebar" class="pt--29 pb--29 bg--light border-bootom border-color-accent2">
                <div class="container">

                        <div class="text-center">
                        <div class="logo-area">
                            <a href="{{ route('home.page') }}" class="temp-logo" id="temp-logo">
                                <img src="{{ asset('frontend/img/logo-dark.png') }}" class="img-fluid">
                            </a>
                        </div>

                        </div>
                        
                    </div>
            </div>
            <div id="rt-sticky-placeholder"></div>
            <div id="header-menu" class="header-menu menu-layout1 bg--light">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav id="dropdown" class="template-main-menu">
                                <ul>
                                   <li>
                                     <a href="{{ route('home.page') }}">{{ __('translate.ana_sehife') }}</a>
                                    </li>
                                    <li>
                                        <a href="#">{{__('translate.kateqoriyalar')}}</a>
                                        <ul class="dropdown-menu-col-1">
                                         @foreach($categories as $category)
                                            <li>
                                                <a href="{{ url($category->slug) }}">{{ $category->name }}</a>
                                            </li> 
                                         @endforeach
                                        </ul>
                                    </li>
                                    <li>
                                     <a href="#">
                                            @if(Config::get('languages')[App::getLocale()] === 'az')
                                            <img class="i-20" src="{{asset('frontend/icon/az.svg')}}">
                                            @endif
                                            @if(Config::get('languages')[App::getLocale()] === 'en')
                                            <img class="i-20" src="{{asset('frontend/icon/en.svg')}}">
                                            @endif
                                            @if(Config::get('languages')[App::getLocale()] === 'ru')
                                            <img class="i-20" src="{{asset('frontend/icon/ru.svg')}}">
                                            @endif
                                        </a>
                                       <ul class="dropdown-menu-col-1">
                                    
                                            @foreach (Config::get('languages') as $lang => $language)
                                            @if ($lang != App::getLocale())
                                            <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">
                                                @if($language == 'az') <div class="d-flex align-items-center">
                                                    <b>{{__('translate.lang_az')}}</b></div>
                                                @endif
                                                @if($language == 'en') <div class="d-flex align-items-center">
                                                    <b>{{__('translate.lang_en')}}</b></div>
                                                @endif
                                                @if($language == 'ru') <div class="d-flex align-items-center">
                                                    <b>{{__('translate.lang_ru')}}</b></div>
                                                @endif
                                            </a>
                                            @endif
                                            @endforeach
                                      
                                        </ul>
                                    </li>
                                    <li class="header-search-box divider-style-border">
                                        <a href="#header-search" title="Search">
                                            <i class="flaticon-magnifying-glass"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

                
        <div id="header-search" class="header-search">
            <button type="button" class="close">×</button>
            <form method="GET" action="{{ route('post.search') }}" class="header-search-form">
                <input type="search" name="q" placeholder="{{ __('translate.post_axtarin') }}" />
                <button type="submit" class="search-btn">
                    <i class="flaticon-magnifying-glass"></i>
                </button>
            </form>
        </div>




        <!-- Header Area End Here -->