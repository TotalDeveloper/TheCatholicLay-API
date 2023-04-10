<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\Schema\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use App\Services\Mutations\VerifyPhone;

class PhoneVerificationController extends Controller
{
    /**
     * @OA\POST(
     *     path="/api/phone-verification",
     *     operationId="doPhoneVerification",
     *     tags={"Authentication"},
     *     summary="",
     *     description="Verify phone number entered on registration."
     * )
     * Returns Result
     *
     * Handle the incoming request.
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $args = $request->only(['verification_code']);
        $response = VerifyPhone::run($args);

        return response()->json($response['result'], $response['status']);
    }
}
