<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Http\Requests\LoginRequest;
use App\Services\LoginTokenService;
use App\Http\Controllers\Controller;
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
}
