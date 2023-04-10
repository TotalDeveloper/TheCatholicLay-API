<?php

namespace App\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInvite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateInviteRegister
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     */
    public function __invoke($_, array $args): array
    {
        /*
        How to call this graphql.
        mutation {
          createInviteRegister(input:{
            invite_token: "56bb0a02-b5a7-11ec-af0d-42e8acef7024",
            email: "levlar.logeco@gmail.com",
            user_name: "levilogics",
            first_name: "Levlar",
            middle_name: "Esguerra",
            last_name: "Logeco",
            password: "Qqww1122!"
          }) {
            success
            message
          }
        }
        */

        DB::beginTransaction();
        try {
            $invite = UserInvite::where("token", $args['input']['invite_token'])->first();
            if ($invite && ($invite->status === 'accepted')) {

                // Invite already accepted here.
                DB::commit();
                return [
                    'success' => 'true',
                    'message' => $args['input']['email'] . '\'s invitation is already accepted!'
                ];
            } else if ($invite && ($invite->status === 'pending')) {

                // Create a new user and set the parent as the one who invite.
                // Mark email sa verified sa the invite link is sent via email.
                $user = new User();
                $user->name = $args['input']['first_name'] . ' ' . $args['input']['last_name'];
                $user->email = $invite->email;
                $user->password = Hash::make($args['input']['password']);
                $user->parent_id = $invite->admin_id;
                $user->email_verified_at = Carbon::now();
                $user->save();

                // Set the organization provided on invite details.
                // Set the invited as GUEST, for now all invited are automatically GUEST.
                $user->organizations()->attach(Organization::find($invite->organization_id));
                $user->roles()->attach(Role::find(Role::GUEST));

                // Add profile data.
                $profile = new Profile();
                $profile->id = $user->id;
                $profile->first_name = $args['input']['first_name'];
                $profile->middle_name = $args['input']['middle_name']; // This will be filled on profile update.
                $profile->date_of_birth = null;
                $profile->last_name = $args['input']['last_name'];
                $profile->save();

                // Mark invite as accepted to not allow next submit.
                $invite->status = "accepted";
                $invite->save();
            }
            DB::commit();

            auth()->loginUsingId($user->id, TRUE);
            return [
                'success' => 'true',
                'message' => $user->createToken($args['device_name'])->plainTextToken
            ];
        } catch (\Exception $ex) {

            DB::rollBack();
            return [
                'success' => 'false',
                'message' => $ex->getMessage()
            ];
        }
    }
}
