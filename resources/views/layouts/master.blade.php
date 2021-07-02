<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')@hasSection('title') | @endif{{ config('app.name') }} </title>
        <!-- Fonts & Stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/all.min.css') }}">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/font-awesome.css">
        
        <script src="https://kit.fontawesome.com/68309a4001.js" crossorigin="anonymous"></script>
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-purple-500 text-white">
        @yield('body')
        @include('partials.errors')
        <!-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script> -->
        @livewireScripts
        <script type="text/javascript" src="{{ URL::asset('js/lava.js')}}"></script>
        @stack('scripts')
    </body>
</html>
