<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-M-Y'
    ];
}
