<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Exception;

final class ChangePassword
{
    /**
     * @param null $_
     * @param array{} $args
     */
    public function __invoke($_, array $args): array
    {
        $currentPassword = $args['currentPassword'];
        $newPassword = $args['newPassword'];
        $reTypePassword = $args['reTypePassword'];

        try {
            if (Hash::check($currentPassword, Auth::user()->password)) {
                $user = auth('sanctum')->user();
                $user->password = Hash::make($newPassword);
                $user->save();
            }
            return [
                'success' => 0,
                'message' => 'Password was successfully changed',
            ];
        } catch (Exception $exception) {
            //
        }

        return [
            'success' => -1,
            'message' => 'Password was not successfully changed.'
        ];
    }
}
