@extends('layouts.app')

@section('title', '| Roles')

@section('content')

    <div class="flex justify-between">
        <div class="text-3xl font-title">Available Roles</div>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-orange">Users</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-orange">Permissions</a>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
            <tr>
                <th>Roles</th>
                <th>Permissions</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                @php
                    //dd($role->permissions);
                @endphp
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions->implode('name', ', ') }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-orange mr-2">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('roles.create') }}" class="btn btn-orange">Add Role</a>
@endsection