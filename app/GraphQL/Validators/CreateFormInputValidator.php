<?php

namespace App\GraphQL\Validators;

use App\Models\Form;
use App\Models\FormTemplate;
use App\Models\Organization;
use Log;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateFormInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $count = FormTemplate::query()
                        ->whereHas('organizations', function ($query) {
                            return $query->whereIn('id', $this->arg('organizations.connect', $this->arg('organizations.sync', [])));
                        })
                        ->whereHas('form', function ($query) use ($value) {
                            return $query->where('name', 'ilike', $value);
                        })
                        ->count();

                    if ($count) {
                        $fail('The name is taken.');
                    }
                }
            ]
        ];
    }
}
