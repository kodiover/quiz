<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Logo -->
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/quizlogo.png') }}"/>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>  

    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen">
            
        @if (Request::is('/'))
            @include('navigation-menu')
        @elseif (Request::is('home'))
            @include('navigation-menu')
        @elseif (Request::is('user/profile'))
            @include('navigation-menu')
        @elseif (request()->route()->getName() == 'user.manage-quiz')
            @include('navigation-menu')
        @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="text-gray-600 border-gray-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-white leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="main">
                {{ $slot }}
            </main>

            

        </div>

        @stack('modals')

        @livewireScripts

    </body>
</html>
