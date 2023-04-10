<?php

namespace App\GraphQL\Mutations;

use App\Models\Role;
use App\Models\User;

class AssignRole
{
    public function __invoke($_, array $args)
    {
        $user = User::find($args['user_id']);
        $role = Role::find($args['role_id']);
        $user->assignRole($role);

        return $user;
    }
}
