@extends('layouts.app')

@section('title', '| Create Category')

@section('content')
    <div class="text-3xl font-title mb-6">Add Category</div>

    <form method="post" action="{{ route('categories.store') }}">
        @csrf

        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input type="text" id="name" name="name" class="input-text" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-orange" value="Add">
        </div>
    </form>
@endsection