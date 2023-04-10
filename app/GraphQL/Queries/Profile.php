<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class Profile
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $user = User::find($args['user_id']);
        return $user->profile;
    }
}
