<?php

namespace App\GraphQL\Mutations;
use App\Models\Field;

class DeleteFieldsByFormId
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $result = Field::where('form_id', $args['form_id'])->get();
        Field::where('form_id', $args['form_id'])->delete();
        return $result;
    }
}
