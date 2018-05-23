@extends('layouts.app')

@section('title', '| Edit Permission')

@section('content')
    <div class="flex justify-between">
        <div class="text-3xl font-title mb-6">Edit {{ $permission->name }}</div>
        <form method="post" action="{{ route('permissions.destroy', $permission->id) }}">
            @csrf
            @method('delete')
            <input type="submit" class="btn btn-link" value="Delete Permission">
        </form>
    </div>

    <form method="post" action="{{ route('permissions.update', $permission->id) }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input type="text" id="name" name="name" class="input-text" value="{{ old('name', $permission->name) }}">
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-orange" value="Update">
        </div>
    </form>

@endsection