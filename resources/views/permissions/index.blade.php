@extends('layouts.app')

@section('title', '| Permissions')

@section('content')

    <div class="flex justify-between">
        <div class="text-3xl font-title">Available Permissions</div>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-orange">Users</a>
            <a href="{{ route('roles.index') }}" class="btn btn-orange">Roles</a>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
            <tr>
                <th>Permissions</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-orange mr-2">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ URL::to('permissions/create') }}" class="btn btn-orange">Add Permission</a>
@endsection