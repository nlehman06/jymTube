<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="flex p-3">

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
                <a href="{{ route('register') }}"
                   class="px-4 font-title font-bold text-lg no-underline text-grey-darker ml-8">
                    Sign Up
                </a>
                <a href="{{ route('login') }}" class="px-4 font-title font-bold text-lg text-orange no-underline">
                    Sign In
                </a>
            @endguest
        </div>
    </div>
</nav>

<div class="container mx-auto">
    <div class="flex flex-col items-center h-48 justify-center">
        <p class="font-title font-bold text-5xl text-grey-darker">Welcome to JymTube</p>
        <a href="/home" class="btn btn-orange">Browse</a>
    </div>
</div>

</body>
</html>
