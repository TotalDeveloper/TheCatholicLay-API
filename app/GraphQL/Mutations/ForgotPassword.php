<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use App\Services\Mutations\ForgotPassword as Service;

class ForgotPassword
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        $response = Service::run($args);
        return [
            'success' => Arr::get($response, 'result.success'),
            'message' => Arr::get($response, 'result.message')
        ];
    }
}
