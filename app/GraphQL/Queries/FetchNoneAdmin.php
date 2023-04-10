<?php

namespace App\GraphQL\Queries;

use App\Models\User;

class FetchNoneAdmin
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        return User::doesntHave('admin')->get();
    }
}
