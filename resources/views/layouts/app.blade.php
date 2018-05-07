<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JymTube') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-grey-lightest font-body text-orange-darkest min-h-screen">
<div id="app">

    <nav-bar auth="{{ Auth::check() }}" user="{{ auth()->user() }}" register-route="{{ route('register') }}"
             login-route="{{ route('login') }}" logout-route="{{ route('logout') }}"></nav-bar>

    <main class="py-4 container mx-auto">
        @yield('content')
    </main>

    <footer class="bg-grey-light shadow absolute pin-b w-full py-4">
        <div class="container w-full mx-auto text-center">
            <p class="py-2">See a Jim Stoppani video that we missed?</p>
            <a href="{{ route('addVideo') }}"
               class="btn btn-orange">
                Add a Jim Stoppani Video
            </a>
        </div>
    </footer>
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
