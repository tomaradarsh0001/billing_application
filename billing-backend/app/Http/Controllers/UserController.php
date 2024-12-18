<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // List users
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    // Edit user
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
        ]);

        $user->syncRoles($request->roles);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // Manage roles
    public function manageRoles()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    // Assign roles
    public function assignRoles(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Roles updated successfully.');
    }
}
