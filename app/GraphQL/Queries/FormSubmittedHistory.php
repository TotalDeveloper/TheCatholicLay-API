<?php

namespace App\GraphQL\Queries;

use App\Models\FillupForm;

class FormSubmittedHistory
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        return FillupForm::where('user_id', $args['user_id'])->all();
    }
}
