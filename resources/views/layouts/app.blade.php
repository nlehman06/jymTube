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
             login-route="{{ route('login') }}" logout-route="{{ route('logout') }}"
             :user="{{ json_encode(Auth::user()) }}"></nav-bar>

    <main class="py-4 container mx-auto">
        @yield('content')
    </main>

    <footer class="bg-grey-light shadow absolute pin-b w-full py-4">
        <add-missing-video add-video-route="{{ route('addVideo') }}"
                           :user="{{ json_encode(Auth::user()) }}"></add-missing-video>
    </footer>
</div>


<!-- Scripts -->
<script>
    let user = {!! Auth::user() ? : '[]' !!};
</script>
<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
