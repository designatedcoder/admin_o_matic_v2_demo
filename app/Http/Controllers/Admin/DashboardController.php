<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle incoming request.
     */
    public function __invoke() {
        $user = User::where('is_admin', 0)->whereDate('created_at', '>', now()->subDays(3));
        return Inertia::render('Admin/Dashboard', [
            'userCount' => $user->count(),
        ])->rootView('admin');
    }
}
