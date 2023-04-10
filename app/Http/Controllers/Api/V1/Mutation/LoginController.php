<?php

namespace App\Http\Controllers\Api\V1\Mutation;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\Schema\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * @OA\POST(
     *     path="/api/login",
     *     operationId="doLogin",
     *     tags={"Authentication"},
     *     summary="",
     *     description="Returns bearer token.",
     *     @OA\Parameter(
     *         name="Content-Type",
     *         description="",
     *         required=true,
     *         in="header",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $data  = $request->all();
        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if ($validator->fails()) {

            $result = new Result();
            $result->success = false;
            $result->message = $validator->errors();
            $result->data = [];

            return response()->json($result->convertToArray(), 401);
        }

        if (is_numeric($data['username'])) {

            if (!Auth::attempt(['phone_number' => $data['username'], 'password' => $data['password']])) {

                $result = new Result();
                $result->success = false;
                $result->message = 'Invalid credentials.';
                $result->data = [];
                return response()->json($result->convertToArray());
            }
            $user = User::where('phone_number', $data['username'])->first();
        } else {

            if (!Auth::attempt(['email' => $data['username'], 'password' => $data['password']])) {

                $result = new Result();
                $result->success = false;
                $result->message = 'Invalid credentials.';
                $result->data = [];

                return response()->json($result->convertToArray());
            }
            $user = User::where('email', $data['username'])->first();
        }

        $result = new Result();
        $result->success = true;
        $result->message = "You are successfully logged in!";
        $result->data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'token' => $user->createToken($data['device_name'])->plainTextToken
        ];

        return response()->json($result->convertToArray());
    }
}
