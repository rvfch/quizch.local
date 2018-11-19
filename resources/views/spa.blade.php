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

    <!-- fonts import -->
      <link href="https://fonts.googleapis.com/css?family=Inconsolata|Open+Sans:300,400,600,700&amp;subset=cyrillic" rel="stylesheet">

    <!-- styles import -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body>
    <div id="app" class="container">
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
