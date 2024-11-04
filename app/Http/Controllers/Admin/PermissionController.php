<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Inertia::render('Admin/Permissions/Index', [
            'permissions' => Permission::latest()->get()
        ])->rootView('admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'display_name' => ['required', 'max:25', 'unique:permissions,display_name'],
            'description' => ['required', 'max:255']
        ]);

        Permission::create([
            'name' => Str::lower(Str::slug($request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return to_route('admin.permissions.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission) {
        $request->validate([
            'display_name' => ['required', 'max:25'],
            'description' => ['required', 'max:255']
        ]);

       $permission->update([
            'name' => Str::lower(Str::slug($request->display_name)),
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return to_route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission) {
        $permission->delete();
        return to_route('admin.permissions.index');
    }
}
