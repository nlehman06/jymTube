@extends('layouts.app')

@section('content')

    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3">
            <h1 class="font-title font-hairline mb-6 text-center">Login to JymTube</h1>
            <div class="border-teal p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4 flex flex-col items-center justify-center">
                        <a href="{{ url('/auth/facebook') }}" class="btn w-full text-white bg-orange-light">
                            Facebook
                        </a>
                    </div>

                    <div class="mb-4">
                        <label class="font-bold text-grey-darker block mb-2">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email"
                               class="input-text {{ $errors->has('email') ? ' border-red' : '' }}"
                               name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="text-red-dark">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="mb-4">
                        <label class="font-bold text-grey-darker block mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="input-text {{ $errors->has('password') ? 'border-red' : '' }}"
                               name="password" required>

                        @if ($errors->has('password'))
                            <span class="text-red-dark">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-orange">
                            {{ __('Login') }}
                        </button>

                        <a class="no-underline inline-block align-baseline font-bold text-sm text-blue hover:text-blue-dark float-right"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                </form>

            </div>
            <div class="text-center">
                <p class="text-grey-dark text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="no-underline text-blue font-bold">Create an Account</a>.
                </p>
            </div>
        </div>
    </div>

@endsection
