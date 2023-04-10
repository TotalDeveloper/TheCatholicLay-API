<?php

namespace App\GraphQL\Mutations;

use App\Models\UserProfile;
use Illuminate\Support\Arr;

class UpdateProfile
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        UserProfile::where('user_id', '=', Arr::get($args, 'input.user_id'))->update([
            'first_name' => Arr::get($args,'input.first_name'),
            'middle_name' => Arr::get($args,'input.middle_name'),
            'last_name' => Arr::get($args,'input.last_name'),
            'photo' => Arr::get($args,'input.photo'),
            'date_of_birth' => Arr::get($args,'input.date_of_birth')
        ]);

        return UserProfile::where('user_id', '=', Arr::get($args, 'input.user_id'))->first();
    }
}
