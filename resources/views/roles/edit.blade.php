@extends('layouts.app')

@section('title', '| Edit Role')

@section('content')
    <div class="flex justify-between">
        <div class="text-3xl font-title mb-6">Edit {{ $role->name }}</div>
        <form method="post" action="{{ route('roles.destroy', $role->id) }}">
            @csrf
            @method('delete')
            <input type="submit" class="btn btn-link" value="Delete Role">
        </form>
    </div>

    <form method="post" action="{{ route('roles.update', $role->id) }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label class="label" for="name">Name</label>
            <input type="text" id="name" name="name" class="input-text" value="{{ old('name', $role->name) }}">
        </div>

        <div class="text-xl font-title my-4">Assign Permissions</div>
        @foreach($permissions as $permission)
            <div>
                <input type="checkbox" name='permissions[]' id="permission_{{ $permission->id }}"
                       value="{{ $permission->id }}"
                        {{ ($role->permissions->contains('id', $permission->id)) ? 'checked' : '' }}>
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
            <input type="submit" class="btn btn-orange" value="Update">
        </div>
    </form>

@endsection