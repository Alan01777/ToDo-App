<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Auth\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param UserService $userService
     * @param int $id
     * @return \App\Http\Resources\UserResource
     */
    public function show(UserService $userService, int $id)
    {
        return $userService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param UserService $userService
     * @param int $id
     * @return \App\Http\Resources\UserResource
     */
    public function update(UserRequest $request, UserService $userService, int $id)
    {
        return $userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserService $userService
     * @param int $id
     * @return null
     */
    public function destroy(UserService $userService, int $id)
    {
        return $userService->destroy($id);
    }
}
