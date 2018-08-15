<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JymTube') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
</head>

<body class="bg-grey-lightest font-body text-orange-darkest min-h-screen h-full">

<div id="app" class="flex flex-col h-full">

    <nav-bar
            auth="{{ Auth::check() }}"
            register-route="{{ route('register') }}"
            login-route="{{ route('login') }}"
            logout-route="{{ route('logout') }}"
            :user="{{ json_encode(Auth::user()) }}"
            :is-admin="{{ optional(auth()->user())->can('Administer roles & permissions') ? 1 : 0 }}"
            :can-approve-videos="{{ optional(auth()->user())->can('approve videos') ? 1 : 0 }}"
    ></nav-bar>

    <main class="py-4 container mx-auto flex-1">
        @yield('content')
    </main>

    <footer class="bg-grey-light shadow pin-b w-full py-4">
        <add-missing-video add-video-route="{{ route('addVideo') }}"
                           :user="{{ json_encode(Auth::user()) }}"></add-missing-video>
    </footer>
</div>


<!-- Scripts -->
<script>
    let user = {!! Auth::user() ? : '[]' !!};
</script>
<script src="{{ asset('js/app.js') }}" defer></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=155995138377047&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
