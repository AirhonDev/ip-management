<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private UserService $service;

    /**
     * @param UserService $service
     *
     */

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Logs a user in the system.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = $this->service->authenticateUser($request->email, $request->password);

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('Api Token')->plainTextToken;
        $user->token = $token;

        return new UserResource($user);
    }
}
