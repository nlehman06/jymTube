@extends('layouts.app')

@section('title', '| Create Permissions')

@section('content')
    <div class="text-3xl font-title mb-6">Add Permission</div>

    <form method="post" action="{{ route('permissions.store') }}">
        @csrf

        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input type="text" id="name" name="name" class="input-text" value="{{ old('name') }}">
        </div>

        @if(!$roles->isEmpty())
            <div class="text-xl font-title my-4">Assign Permission to Roles</div>
            @foreach($roles as $role)
                <div>
                    <input type="checkbox" name='roles[]' id="role_{{ $role->id }}" value="{{ $role->id }}">
                    <label class="label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        @endif

        <div class="form-group">
            <input type="submit" class="btn btn-orange" value="Add">
        </div>
    </form>

@endsection