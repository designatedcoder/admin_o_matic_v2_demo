<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super-admin' => [
            'panel' => 'a',
            'admins' => 'a,u',
            'roles' => 'a,c,u,d',
            'permissions' => 'a,c,u,d',
            'users' => 'a,u',
            'profile' => 'r,u',
        ],
        'admin' => [
            'panel' => 'a',
            'admins' => 'a,u',
            'roles' => 'a,c,u,d',
            'permissions' => 'a,c,u,d',
            'users' => 'a,u',
            'profile' => 'r,u',
        ],
        'moderator' => [
            'panel' => 'a',
            'admins' => 'a',
            'roles' => 'a',
            'permissions' => 'a',
            'users' => 'a',
            'profile' => 'r,u',
        ],
        'developer' => [
            'panel' => 'a',
            'admins' => 'a',
            'profile' => 'r,u',
        ],
        'user' => [
            'profile' => 'r,u',
        ],
        // 'role_name' => [
        //     'module_1_name' => 'c,r,u,d',
        // ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'a' => 'access',
    ],
];
