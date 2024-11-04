<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Inertia::render('Admin/Roles/Index', [
            'roles' => Role::with('permissions:id,name')->get(),
            'permissions' => Permission::get(['id', 'name'])
        ])->rootView('admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
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
        $role->delete();
        return to_route('admin.roles.index');
    }
}
