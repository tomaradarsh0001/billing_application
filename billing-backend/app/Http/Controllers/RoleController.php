<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); 
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all(); 
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $permissions = is_array($request->permissions) ? $request->permissions : [];

    $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

    $role = Role::create(['name' => $request->name]);

    if (!empty($validPermissions)) {
        $role->syncPermissions($validPermissions);
    }
      

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role')); 
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id, 
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function checkRoleName(Request $request)
{
    $roleName = $request->input('name');
    
    $exists = Role::where('name', $roleName)
        ->where('id', '!=', $request->route('role'))
        ->exists();
        
    return response()->json(['exists' => $exists]);
}

}
