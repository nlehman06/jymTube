@extends('layouts.app')

@section('content')
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-1/3">
            <h1 class="font-title font-hairline mb-6 text-center">Register</h1>
            <div class="border-teal p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg">
                <form method="POST" action="{{ route('register') }}">
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
                        <label class="font-bold text-grey-darker block mb-2">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password"
                               class="input-text {{ $errors->has('password-confirm') ? 'border-red' : '' }}"
                               name="password_confirmation" required>

                        @if ($errors->has('password-confirm'))
                            <span class="text-red-dark">
                                <strong>{{ $errors->first('password-confirm') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-orange">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
