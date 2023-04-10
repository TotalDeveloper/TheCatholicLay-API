<?php

namespace App\GraphQL\Mutations;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class SyncAuth
{
    /**
     * @param null $_
     * @param array{} $args
     */
    public function __invoke($_, array $args): array
    {
        $name = $args['name'];
        $email = $args['email'];
        $password = $args['password'];
        $token = $args['token'];
        $role = $args['role']; // Admin
        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            $admin = new Admin();
            $admin->id = $user->id;
            $admin->save();

            $organization = new Organization();
            $organization->name = "Default";
            $organization->admin_id = $user->id;
            $organization->save();

            $group = new Group();
            $group->name = 'Default';
            $group->admin_id = $user->id;
            $group->organization_id = $organization->id;
            $group->save();

            if ($role === 'admin') {
                $user->assignRole(Role::find(Role::ADMIN));
            } else if ($role === 'guest') {
                $user->assignRole(Role::find(Role::GUEST));
            }
        }
        $token = $user->createToken($args['email'], $token)->plainTextToken;
        return [
            "name" => $user->name,
            "email" => $user->email,
            "token" => Str::after($token, "|")
        ];
    }
}
