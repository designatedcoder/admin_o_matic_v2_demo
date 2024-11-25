<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::allowIf(fn (User $user) => $user->isAbleTo('access-roles'));

        return Inertia::render('Admin/Roles/Index', [
            'roles' => Role::with('permissions:id,name')->paginate(5),
            'permissions' => Permission::get(['id', 'name'])
        ])->rootView('admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        Gate::allowIf(fn (User $user) => $user->isAbleTo('create-roles'));

        $request->validate([
            'display_name' => ['required', 'max:25', 'unique:roles,display_name'],
            'description' => ['required', 'max:255'],
            'selectedPermissions' => ['required']
        ], [
            'selectedPermissions.required' => 'The permissions field is required.'
        ]);

        $role = Role::create([
            'name' => Str::lower(Str::slug($request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        if ($request->has('selectedPermissions')) {
            $role->givePermissions(collect($request->selectedPermissions)->pluck('id')->toArray());
        }

        return to_route('admin.roles.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role) {
        Gate::allowIf(fn (User $user) => $user->isAbleTo('update-roles'));

        $request->validate([
            'display_name' => ['required', 'max:25'],
            'description' => ['required', 'max:255'],
            'selectedPermissions' => ['required']
        ], [
            'selectedPermissions.required' => 'The permissions field is required.'
        ]);

        $role->update([
            'name' => Str::lower(Str::slug($request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        if ($request->has('selectedPermissions')) {
            $role->syncPermissions(collect($request->selectedPermissions)->pluck('id')->toArray());
        }

        return to_route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) {
        Gate::allowIf(fn (User $user) => $user->isAbleTo('delete-roles'));

        $role->delete();
        return to_route('admin.roles.index');
    }
}
