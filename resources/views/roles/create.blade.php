@extends('layouts.app')

@section('title', '| Create Role')

@section('content')
    <div class="text-3xl font-title mb-6">Add Role</div>

    <form method="post" action="{{ route('roles.store') }}">
        @csrf

        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input type="text" id="name" name="name" class="input-text" value="{{ old('name') }}">
        </div>

        <div class="text-xl font-title my-4">Assign Permissions</div>
        @foreach($permissions as $permission)
            <div>
                <input type="checkbox" name='permissions[]' id="permission_{{ $permission->id }}"
                       value="{{ $permission->id }}">
                <label class="label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
        @endforeach

        @if ($errors->any())
            <div class="text-red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <input type="submit" class="btn btn-orange" value="Add">
        </div>
    </form>

@endsection