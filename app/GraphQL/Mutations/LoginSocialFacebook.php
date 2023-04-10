<?php

namespace App\GraphQL\Mutations;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginSocialFacebook
{
    private static function getEmailInput($args) {
        $email = $args['email'] ?? '';
        if ($email === '') {
            $email = $args['id'];
        }
        return $email; 
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @throws Error
     */
    public function __invoke($_, array $args): array
    {
        $response = Http::post(env('SPI_URL') . '/api/api/v1/login/social', [
            'id' => $args['id'], // facebook id from facebook package.
            'name' => $args['name'],
            'email' => self::getEmailInput($args),
            'facebook' => true
        ]);
        $email = $response->collect('data.email')[0] ?? '';
        $name = $response->collect('data.name')[0] ?? 'Anonymous';
        $status = $response->collect('status')[0] ?? ''; // 200 -> OK, 401 -> FAILED
        $access_token = $response->collect('access_token')[0] ?? '';
        if ($status == 200) {

            $user = User::where('facebook_id', $args['id'])
                ->orWhere('email', $args['email'])
                ->first();
            if (!$user) {

                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($args['id']);
                $user->phone_number = "...";
                $user->device_name = "web";
                $user->spi_access_token = $access_token;
                $user->facebook_id = $args['id'];
                $user->save();
                $user->roles()->attach(Role::find(Role::ADMIN));

                $admin = new Admin();
                $admin->user()->associate($user);
                $admin->save();

                $group = new Group();
                $group->name = 'Default';
                $group->admin()->associate($admin);
                $group->save();
            } else {

                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($args['id']);
                $user->phone_number = "...";
                $user->device_name = "web";
                $user->spi_access_token = $access_token;
                $user->facebook_id = $args['id'];
                $user->save();
            }

            Auth::loginUsingId($user->id);
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'token' => $user->createToken($args['id'])->plainTextToken
            ];
        } else {
            throw new Error('Invalid credentials.');
        }
    }
}
