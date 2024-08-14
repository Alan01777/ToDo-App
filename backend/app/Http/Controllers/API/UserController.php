<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Auth\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id The ID of the user to display.
     * @return \App\Http\Resources\UserResource The user resource.
     */
    public function show(int $id)
    {
        return $this->userService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request The request object containing the user data.
     * @param int $id The ID of the user to update.
     * @return \App\Http\Resources\UserResource The updated user resource.
     */
    public function update(UserRequest $request, int $id)
    {
        return $this->userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id The ID of the user to remove.
     * @return null
     */
    public function destroy(int $id)
    {
        return $this->userService->destroy($id);
    }
}
