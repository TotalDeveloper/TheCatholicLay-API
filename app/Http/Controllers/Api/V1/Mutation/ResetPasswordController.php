<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Services\Mutations\ResetPassword;

/**
 *
 * @OA\POST(
 *     path="/api/reset-password",
 *     operationId="doResetPassword",
 *     tags={"Authentication"},
 *     summary="",
 *     description="Changed users password.",
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="UnAuthenticated"
 *     )
 * )
 * Returns Token.
 *
 * Handle the incoming request.
 *
 * @param  Request $request
 * @return JsonResponse
 */
class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = ResetPassword::run($request->only([
                    'email',
                    'phone_number',
                    'password',
                    'new_password',
                    'confirm_password'
                ]
            ));

        return response()->json(
            $response['result'],
            $response['status']
        );
    }
}
