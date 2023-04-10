<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Login
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     * @throws Error
     * @throws ValidationException
     */
    public function __invoke($_, array $args): array
    {
        $user = User::where('email', '=', $args['email'])->first();
        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($args['email'], Str::random(40))->plainTextToken;
        return [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "token" => $token,
        ];
    }
}
