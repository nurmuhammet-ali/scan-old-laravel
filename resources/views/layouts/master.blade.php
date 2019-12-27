<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Nurmuhammet Allanov">    
    <meta name="theme-color" content="#ffffff">
    
    <title>{{ env('APP_NAME') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style>
        .mt-80px {
            margin-top: 80px !important;
        }
        .pb-0 {
            padding-bottom: 0 !important;
        }
        .btn {
            cursor: pointer;
            font-weight: bold;
            padding: .6em;
            border-radius: 10px;
        }
        .btn-sm {
            width: 20%;
        }
        .float-right {
            float: right;
        }
        .float-left {
            float: left;
        }
        .clearfix {
            clear: both;
        }
        .mb-1 {
            margin-bottom: 0.25em;
        }
        .h-4 {
            height: 1em;
        }
        </style>
        <script>
            window.Lara = {
                routes: {
                    typesDelete: '{{ route('types.delete') }}',
                    typesUpdate: '{{ route('types.update') }}',
                    plansDelete: '{{ route('plans.delete') }}',
                    plansUpdate: '{{ route('plans.update') }}'
                }
            };
        </script>
      @yield('styles')
</head>
<body>
@if(request()->path() != '/')
    <div class="nav">
        <div class="menu"><span class="menu-name">Menýu</span>
            <div class="menu-items" style="display: none;">
                <a class="menu-item-link" href="/admin">Admin panel</a>
                <a class="menu-item-link" href="{{ route('plans.index') }}">VPS tarifler</a>
                <a class="menu-item-link" href="{{ route('types.index') }}">Görnüşler</a>
            </div>
        </div>
        
        <div class="user"><img class="user-icon" height="16" width="16" src="/img/avatar.png">Admin
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" style="display: none;" class="logout-link">
                <span class="logoust-link-span" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</span>
            </a>
        </div>
    </div>
@endif
    
<div id="app">
    @yield('content')
</div>

<script src="/js/api/jquery.js"></script>
<script src="/js/app.js"></script>
@yield('scripts')
</body>
</html>
