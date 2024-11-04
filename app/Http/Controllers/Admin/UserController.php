<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::where('is_admin', 0)->with('roles:id,name')->latest()->get(),
            'roles' => Role::get(['id', 'name'])
        ])->rootView('admin');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user) {
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

        if ($currentRole->id != 5 && $adminRole->id != 5) {
           $user->update(['is_admin' => 1]);
        }
        elseif ($currentRole->id == 5 && $adminRole->id != 5) {
            $user->syncRoles([$adminRole->id]);
            $user->update(['is_admin' => 1]);
        }
        return to_route('admin.users.index');
    }
}
