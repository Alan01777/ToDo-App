<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Create user
     *
     * @param AuthRequest $request
     * @return JsonResponse [string] message
     */
    public function register(AuthRequest $request): JsonResponse
    {
        return $this->authService->register($request);
    }

    /**
     * Login user and create token
     *
     * @param AuthRequest $request
     * @return JsonResponse [string] message
     */
    public function login(AuthRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request): JsonResponse
    {
        return $this->authService->user($request);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout($request);
    }
}
