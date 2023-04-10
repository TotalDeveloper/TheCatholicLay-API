<?php

namespace App\GraphQL\Queries;

final class GetAbilities
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): array
    {
        $user = auth()->user();
        if ($user) {
            $result = [];
            foreach($user->abilities() as $key => $value) {
                $result[] = $value;
            }
            return $result;
        }

        // Fallback result.
        return [];
    }
}
