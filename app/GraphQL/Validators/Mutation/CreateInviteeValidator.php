<?php

namespace App\GraphQL\Validators\Mutation;

use App\Rules\IsInviteTokenValid;
use App\Rules\IsRecaptchaVerified;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateInviteeValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            "token" => [new IsInviteTokenValid()],
            "recaptcha" => [new IsRecaptchaVerified()],
        ];
    }
}
