@extends('layouts.app')

@section('content')


    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-3/4 lg:w-1/2">
            <h1 class="font-title font-hairline mb-6 text-center">Register Email</h1>
            <div class="border-teal p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg">
                <form method="POST" action="{{ route('register.email.store') }}">
                    @csrf
                    <p class="my-8">
                        Ok, we just need your email address and you're all good.
                    </p>
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