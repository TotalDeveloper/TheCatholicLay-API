<?php

namespace App\GraphQL\Mutations;

use App\Services\Mutations\VerifyPhone;
use Illuminate\Support\Arr;

class VerifyPhoneNumber
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $response = VerifyPhone::run($args);

        return [
            'success' => Arr::get($response, 'result.success'),
            'message' => Arr::get($response, 'result.message')
        ];
    }
}
