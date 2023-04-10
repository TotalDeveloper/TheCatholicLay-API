<?php

namespace App\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\Team;
use App\Models\User;
use App\Models\UserInvite;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

final class UserAcceptInvitation
{
    /**
     * @param null $_
     * @param array{} $args
     */
    public function __invoke($_, array $args)
    {
        $token = Arr::get($args, 'token');
        $userInvite = UserInvite::where('token', '=', $token)->first();
        if ($userInvite) {

            // 1. Check if not yet on the given organization on the invite.
            //    If so add to organization.
            $organization = Organization::find($userInvite->organization_id);
            if ($organization) {
               // 
            }
            
            // 2. Check if not yet on the given team on the invite.
            //    If so add to team.
            $team = Team::find($userInvite->team_id);
            if ($team) {
                // 
            }

            $userInvite->status = 'accepted';
            $userInvite->save();

            $from = auth()->user();
            $to = User::find($userInvite->admin_id);
            $message = [
                "type" => config('constant.channels.notification.actions.USER_INVITE_ACCEPTED'),
                "payload" => [
                    "from" => $from,
                    "to" => $to,
                    "data" => $userInvite,
                ]
            ];
            Redis::publish(config('constant.channels.notification.name'), json_encode($message));
            
            return $userInvite;
        }

        return null;
    }
}

// TODO:
//   Filtering name
//   Team module
//   Contacts
//   Form filtering