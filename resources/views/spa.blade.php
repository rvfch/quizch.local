<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Quizch project">
		<meta name="robot" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- styles import -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
</head>
<body>
    <div id="app">
        @guest
          @yield('content')
        @endguest

        @auth
          <app username="{{ Auth::user()->name }}" userid="{{ Auth::id() }}"></app>
        @endauth
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
