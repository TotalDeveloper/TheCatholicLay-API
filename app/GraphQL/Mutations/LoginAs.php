<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Str;

final class LoginAs
{
    public function __invoke($_, array $args)
    {
        $user = \App\Models\User::find($args['id']);
        if ($user) {
            $token = $user->createToken($user->email, Str::random(40))->plainTextToken;
            return [ "token" => $token ];
        }

        return null;
    }
}
