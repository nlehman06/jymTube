@extends('layouts.app')

@section('title', '| Categories')

@section('content')
    <div class="font-title text-3xl">Categories</div>

    @foreach($categories as $category)
        <div class="text-2xl">{{ $category->name }}</div>
    @endforeach
@endsection