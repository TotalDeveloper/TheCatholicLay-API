<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class GetUsersByOrganization
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     */
    public function __invoke($_, array $args)
    {
        $organization_id = $args['organization_id'];
        return User::whereHas('organizations', function ($q) use ($organization_id) {
            $q->where('id', $organization_id);
        })->get();
    }
}
