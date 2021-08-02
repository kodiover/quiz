 <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<!-- <link rel="shortcut icon" type="image/png" href="{{ asset('images/quizlogo.png') }}"/> -->

<script src="{{ mix('js/app.js') }}" defer></script>

<div class="min-h-screen">
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </div>