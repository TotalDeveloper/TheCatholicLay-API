<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class MeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/me",
     *     operationId="doMe",
     *     tags={"Users"},
     *     summary="",
     *     description="Returns authenticated user.",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     * Returns RegisterRequest
     */

    /**
     * Handle the incoming request.
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var $user User */
        $user = Auth::user();
        $data = ($user) ? $user->toArray() : [];

        return response()->json($data);
    }
}
