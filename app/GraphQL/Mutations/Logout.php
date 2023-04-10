<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

class Logout
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return User
     */
    public function __invoke($_, array $args): User
    {
        /* @var $user User */
        $user = auth('sanctum')->user();
        if ($user) {
            $user->tokens()->delete();
        }

        return $user;
    }
}
