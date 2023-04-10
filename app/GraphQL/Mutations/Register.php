<?php

namespace App\GraphQL\Mutations;

use App\Services\Mutations\Register as Service;
use Illuminate\Support\Arr;

class Register
{
    /**
     * Return a value for the field.
     *
     * @param  @param  null  $root Always null, since this field has no parent.
     * @param array<string, mixed> $args The field arguments passed by the client.
     * @return mixed
     */
    public function __invoke($_, array $args): array
    {
        $response = Service::run($args);

        return [
            'success' => Arr::get($response,'result.success'),
            'message' => Arr::get($response,'result.message'),
            'user' => Arr::get($response, 'result.data')
        ];
    }
}
