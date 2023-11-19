<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Http\Requests\LoginRequest;
use App\Services\LoginTokenService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\SuccessResource;

class AuthController extends Controller
{
    use RegisterService, LoginTokenService;
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $this->createUser($data);
        $response['message'] = 'You are successfully registered!';
        return new SuccessResource($response);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        return $this->loginToken($credentials);
    }
    public function user(Request $request)
    {
        $response['data'] = new UserResource($request->user());
        return new SuccessResource($response);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response['message'] = 'Successfully Logout!';
        return new SuccessResource($response);
    }
}
