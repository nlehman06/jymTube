@extends('layouts.app')

@section('content')


    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-3/4 lg:w-1/2">
            <h1 class="font-title font-hairline mb-6 text-center">Congrats!</h1>
            <div class="border-teal p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg">
                <p class="my-8">
                    You're now an official member of JymTube!
                </p>

                <div class="flex items-center justify-between">
                    <a class="btn btn-orange" href="{{ route('home') }}">
                        Let's get started!
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection