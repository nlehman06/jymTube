@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-medium py-4">{{ $video->title }}</h1>

    @includeWhen(
    $video->provider == 'facebook',
    'video.players.facebook',
    ['provider_id' => $video->provider_id])

    @includeWhen(
    $video->provider == 'youtube',
    'video.players.youtube',
    ['provider_id' => $video->provider_id]
    )


    <div class="flex items-center pt-4">
        <img class="w-10 h-10 rounded-full mr-4"
             src="{{ $video->from_profile }}"
             alt="Profile Picture">
        <div class="text-sm">
            <p class="text-black leading-none">{{ $video->from_name }}</p>
            <p class="text-grey-dark">
                {{ $video->created_at->format('m/d/y') }}
            </p>
        </div>
    </div>

    <p class="py-4 max-w-md whitespace-pre-line">{{ $video->description }}</p>

    <tags-input element-id="tags"
                v-model="selectedTags"
                :existing-tags="{
        'web-development': 'Web Development',
        'php': 'PHP',
        'javascript': 'JavaScript',
    }"
                :typeahead="true"></tags-input>
@endsection