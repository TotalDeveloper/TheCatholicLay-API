<?php

namespace App\GraphQL\Mutations;

use App\Events\UserInviteEvent;
use App\Models\UserInvite;
use Illuminate\Support\Arr;

final class UserResendInvitation
{
    public function __invoke($_, array $args)
    {
        $token = Arr::get($args, 'token');
        $userInvite = UserInvite::where('token', '=', $token)->first();
        if ($userInvite) {
            UserInviteEvent::dispatch($userInvite);
            return $userInvite;
        }

        return null;
    }
}
