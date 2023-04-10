<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\Schema\Result;
use App\Services\Mutations\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;

/**
 * Register controller.
 *
 * @category Register
 * @package  App\Http\Controllers\Api\V1\Mutation
 * @author   Levi <levi@billowsoftware.com.au>
 * @license  billowsoftware.com MIT
 * @link     billowsoftware.com
 */
class RegisterController extends Controller
{
    /**
     * Handle the register incoming request.
     *
     * @param Request $request The http request.
     *
     * @return JsonResponse
     *
     * @OA\POST(
     *     path="/api/register",
     *     operationId="doRegister",
     *     tags={"Authentication"},
     *     summary="",
     *     description="Create a new users.<br><br>
           NOTE: It will send an sms verification code to the user.<br>
           Now verify the users phone number via /api/phone-verification endpoint"
     * )
     * Returns new user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $args = $request->only([
            'user_name',
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'phone_number',
            'password'
        ]);
        $result = Register::run($args);

        return response()->json(
            $result['result'],
            $result['status']
        );
    }
}
