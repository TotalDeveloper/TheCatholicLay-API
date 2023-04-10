<?php

namespace App\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\User;

class DeleteUserBelongsToManyOrganization
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     * @return User
     */
    public function __invoke($_, array $args): User
    {
        // TODO implement the resolver
        $user = User::find($args['user_id']);
        $organization = Organization::find($args['organization_id']);
        $user->organizations()->detach($organization->id);

        return $user;
    }
}
