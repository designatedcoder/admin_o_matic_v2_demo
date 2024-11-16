<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        Gate::allowIf(fn (User $user) => $user->isAbleTo('access-admins'));

        return Inertia::render('Admin/Admins/Index', [
            'admins' => User::where('is_admin', 1)->with('roles:id,name')->get(),
            'roles' => Role::get(['id', 'name'])
        ])->rootView('admin');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) {
        Gate::allowIf(fn (User $user) => $user->isAbleTo('update-admins'));

        $request->validate([
            'selectedRoles' => ['required']
        ], [
            'selectedRoles.required' => 'The roles field is required.'
        ]);

        $currentRole = $user->roles[0];

        if (!isset($request->selectedRoles[0]['id'])) { // has been changed
           $adminRole = Role::where('id', $request->selectedRoles['id'])->first();
        } else {    // has not been changed
           $adminRole = Role::where('id', $request->selectedRoles[0]['id'])->first();
        }

        // they are already an admin
        if ($currentRole->id != 5 && $adminRole->id != 5) {
           $user->syncRoles([$adminRole->id]);
        }

        // they are already an admin and are getting demoted to user
        elseif ($currentRole->id != 5 && $adminRole->id == 5) {
            $user->syncRoles([$adminRole->id]);
            $user->update(['is_admin' => 0]);
        }

        // they are already a user but are given admin role
        elseif ($currentRole->id == 5 && $adminRole->id != 5) {
            $user->syncRoles([$adminRole->id]);
        }

        // they are already a user but is_admin == 1
        else {
            $user->update(['is_admin' => 0]);
        }

        return to_route('admin.admins.index');
    }
}
