<?php

namespace App\Http\Controllers;

use function compact;
use Illuminate\Http\Request;
use function response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return response()->view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return response()->view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|unique:roles|max:10',
            'permissions' => 'required'
        ]);

        $role = Role::create(['name' => $data['name']]);

        $permissions = $data['permissions'];

        foreach ($permissions as $permission)
        {
            $thisPermission = Permission::where('id', $permission)->firstOrFail();

            $role->givePermissionTo($thisPermission);
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role' . $role->name . ' added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return response()->view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'        => 'required|unique:roles,name,' . $role->id . '|max:10',
            'permissions' => 'required'
        ]);

        $role->update(['name' => $data['name']]);

        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission)
        {
            $role->revokePermissionTo($permission);
        }

        foreach ($data['permissions'] as $permission)
        {
            $thisPermission = Permission::where('id', $permission)->firstOrFail();

            $role->givePermissionTo($thisPermission);
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role' . $role->name . ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role deleted!');
    }
}
