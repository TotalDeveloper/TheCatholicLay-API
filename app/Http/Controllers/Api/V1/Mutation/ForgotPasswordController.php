<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\Schema\Result;
use App\Rules\IsEmailExists;
use App\Rules\IsPhoneNumberExists;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\Mutations\ForgotPassword;

/**
 * @OA\POST(
 *     path="/api/forgot-password",
 *     operationId="doForgotPassword",
 *     tags={"Authentication"},
 *     summary="",
 *     description="Change users password.",
 *     @OA\Response(
 *         response=200,
 *         description="Your password is successfully changed!"
 *     )
 * )
 *
 * Returns list of projects
 */
class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $args = $request->only([
            'email',
            'phone_number',
            'new_password',
            'confirm_password',
            'verification_code'
        ]);

        $response = ForgotPassword::run($args);

        return response()->json(
            $response['result'],
            $response['status']
        );
    }
}
