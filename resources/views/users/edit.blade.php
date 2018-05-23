@extends('layouts.app')

@section('title', '| Edit User')

@section('content')

    <div class="text-3xl font-title">Edit {{$user->name}}</div>
    <hr>

    <form role="form" action="{{ route('users.update', $user->id) }}" method="POST">
        @method('PATCH')
        @csrf

        <div class="form-group">
            <label for="nickName">Name</label>
            <input type="text" id="nickName" name="nickName" value="{{ $user->nickName }}" class="input-text">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" class="input-text">
        </div>

        <div class="text-2xl font-title"><b>Give Role</b></div>

        @foreach($roles as $role)
            <div>
                <input type="checkbox" name='roles[]' id="role_{{ $role->id }}"
                       value="{{ $role->id }}"
                        {{ ($user->roles->contains('id', $role->id)) ? 'checked' : '' }}>
                <label class="label" for="role_{{ $role->id }}">{{ $role->name }}</label>
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

        <input type="submit" value="Update" class="btn btn-orange">
    </form>


@endsection