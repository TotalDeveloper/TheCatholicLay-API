<?php

namespace App\GraphQL\Mutations;

use App\Services\Mutations\ResetPassword as Service;
use Illuminate\Support\Arr;

class ResetPassword
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        // TODO implement the resolver
    	$response = Service::run($args);

    	return [
    		'success' => Arr::get($response, 'result.success'),
    		'message' => Arr::get($response, 'result.message')
    	];
    }
}
