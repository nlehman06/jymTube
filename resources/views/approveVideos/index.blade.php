@extends('layouts.app')

@section('content')

    <div class="flex flex-col">
        @foreach($videos as $video)
            <div class="card py-2">
                <div class="card-image"
                     title="{{ $video->title }}" style="background-image: url({{ $video->picture }})"></div>
                <div class="card-body">
                    <div class="mb-8">
                        <div class="card-title">{{ $video->title }}</div>
                        <p class="card-description">{{ $video->description }}</p>
                    </div>
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-full mr-4"
                             src="{{ $video->from_profile }}"
                             alt="Profile Picture">
                        <div class="text-sm">
                            <p class="text-black leading-none">{{ $video->from_name }}</p>
                            <p class="text-grey-dark">
                                {{ $video->created_at->format('m/d/y') }}
                            </p>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <a href="{{ route('approveVideos.edit', $video->id) }}" class="btn btn-orange">
                                Categorize
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection