<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'adminUser' => function() {
                $adminUser = auth()->user();

                return $adminUser ? [
                    'can' => [
                        'accessPanel' => $adminUser->isAbleTo(['access-panel']),
                        'accessAdmins' => $adminUser->isAbleTo(['access-admins']),
                        'updateAdmins' => $adminUser->isAbleTo(['update-admins']),
                        'accessRoles' => $adminUser->isAbleTo(['access-roles']),
                        'createRoles' => $adminUser->isAbleTo(['create-roles']),
                        'updateRoles' => $adminUser->isAbleTo(['update-roles']),
                        'deleteRoles' => $adminUser->isAbleTo(['delete-roles']),
                        'accessPermissions' => $adminUser->isAbleTo(['access-permissions']),
                        'createPermissions' => $adminUser->isAbleTo(['create-permissions']),
                        'updatePermissions' => $adminUser->isAbleTo(['update-permissions']),
                        'deletePermissions' => $adminUser->isAbleTo(['delete-permissions']),
                        'accessUsers' => $adminUser->isAbleTo(['access-users']),
                        'updateUsers' => $adminUser->isAbleTo(['update-users']),
                    ],
                ] : null;
            }
        ]);
    }
}
