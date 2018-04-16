<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-grey-lightest font-body text-orange-darkest min-h-screen">
<div id="app">

    <nav class="flex bg-grey-lightest p-3 shadow">

        <div class="container mx-auto">
            <div class="flex items-center justify-between flex-no-wrap">
                <div class="font-title text-orange-dark flex-none mr-6 w-1/4 text-3xl">JymTube</div>
                <div class="text-white flex-grow">
                    <div class="relative">
                        <input type="text" placeholder="IMPROVE YOURSELF"
                               class="w-full rounded shadow appearance-none border font-title text-orange-darkest bg-orange-lightest text-xl pl-3 py-2 pr-10">
                        <button class="btn btn-orange absolute pin-t pin-r mt-px mr-px text-xl">
                            Search
                        </button>
                    </div>
                </div>
                @auth
                    <div class="text-orange-darker flex-none w-1/4 flex justify-center items-center">
                        <img src="{{ auth()->user()->avatar }}" class="rounded-full mr-3">
                        <span class="text-lg">{{ auth()->user()->nickName }}</span>
                    </div>
                @endauth
                @guest
                    <div></div>
                @endguest
            </div>
        </div>
    </nav>

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
<script src="{{ asset('js/manifest.js') }}" defer></script>
<script src="{{ asset('js/vendor.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
