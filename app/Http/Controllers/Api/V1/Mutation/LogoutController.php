<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\Schema\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class LogoutController extends Controller
{
    /**
     * @OA\POST(
     *     path="/api/logout",
     *     operationId="doLogout",
     *     tags={"Authentication"},
     *     summary="",
     *     description="Revoke the token of the authenticated user."
     * )
     * Returns Token.
     *
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = new Result();
        try {
            /** @var $user User */
            $user = Auth::user();
            $user->tokens()->delete();

            $result->success = true;
            $result->message = $user->currentAccessToken();
            $result->data = $user;
        } catch (Exception $exception) {
            Log::error('LogoutController:' . $exception->getMessage());
        }

        return response()->json($result->convertToArray());
    }
}
