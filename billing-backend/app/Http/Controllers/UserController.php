<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:16',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        $previousRoles = $user->roles->pluck('id')->toArray();
        $user->roles()->sync($validated['roles']);
        $removedRoles = array_diff($previousRoles, $validated['roles']);

        if ($removedRoles) {
            foreach ($removedRoles as $roleId) {
                $role = Role::find($roleId);
                if ($role) {
                    $user->permissions()->detach($role->permissions);
                }
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function perandroles(User $user)
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $userPermissions = $user->permissions->pluck('id')->toArray();

        $specificPermissionId = 0;
        if (!in_array($specificPermissionId, $userPermissions)) {
            $userPermissions[] = $specificPermissionId;
        }

        return view('users.perandroles', compact('roles', 'permissions', 'userPermissions', 'user'));
    }



    public function updateperandroles(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $user->roles()->sync($validated['roles']);
        $user->permissions()->sync($validated['permissions']);
        $user->permissions()->syncWithoutDetaching([]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // public function updateperandroles(Request $request, User $user)
    // {
    //     $validated = $request->validate([
    //         'roles' => 'array',
    //         'permissions' => 'array',
    //     ]);
    //     $userRoles = $validated['roles'];
    //     $userPermissions = $validated['permissions'];
    //     $assignedPermissions = collect();
    //     foreach ($userRoles as $roleId) {
    //         $role = Role::find($roleId);
    //         $assignedPermissions = $assignedPermissions->merge($role->permissions->pluck('id'));
    //     }
    //     $userPermissions = collect($userPermissions)->intersect($assignedPermissions)->toArray();
    //     $user->roles()->sync($userRoles);
    //     $user->permissions()->sync($userPermissions);
    //     $user->permissions()->syncWithoutDetaching([]);

    //     return redirect()->route('users.index')->with('success', 'User updated successfully.');
    // }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function manageRoles()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function assignRoles(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Roles updated successfully.');
    }


    public function managePermissions(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.permissions', compact('role', 'permissions'));
    }

    public function addPermission(Request $request, Role $role)
    {
        $selectedPermissions = $request->input('permissions', []);
        $role->permissions()->sync($selectedPermissions);
        return redirect()->route('roles.index', $role->id)->with('success', 'Permissions updated successfully!');
    }

    public function removePermission(Request $request, Role $role)
    {
        $permissionId = $request->input('permission_id');

        if ($permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $role->permissions()->detach($permission);

            return redirect()->route('roles.permissions', $role->id)->with('success', 'Permission removed successfully!');
        }

        return redirect()->route('roles.permissions', $role->id)->with('error', 'No permission selected for removal.');
    }

    public function checkEmail($email)
    {
       $exists = User::where('email', $email)->exists();
       return response()->json(['exists' => $exists]);
    }

    public function checkEmailEdit(Request $request)
{
    $email = $request->input('email'); 
    $userId = $request->input('id'); 
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['exists' => false]); 
    }
    $exists = User::where('email', $email)
        ->where('id', '!=', $userId) 
        ->exists();

    return response()->json(['exists' => $exists]);
}


}
