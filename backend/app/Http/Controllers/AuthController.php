<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Requests\AuthRequest;
use Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Create user
     *
     * @param  \App\Http\Requests\AuthRequest  $request
     * @return [string] message
     */
    public function register(AuthRequest $request)
    {
        return $this->authService->register($request);
    }

    /**
     * Login user and create token
     *
     * @param  \App\Http\Requests\AuthRequest  $request
     * @return [string] message
     */
    public function login(AuthRequest $request)
    {
        return $this->authService->login($request);
    }

    /**
     * Get the authenticated User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return $this->authService->user($request);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return [string] message
     */
    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }
}
