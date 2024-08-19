<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Exceptions\NullValueException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id The ID of the user to display.
     * @return UserResource The user resource.
     * @throws NullValueException
     */
    public function show(int $id): UserResource
    {
        return $this->userService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request The request object containing the user data.
     * @param int $id The ID of the user to update.
     * @return UserResource The updated user resource.
     * @throws NullValueException
     */
    public function update(UserRequest $request, int $id): UserResource
    {
        return $this->userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id The ID of the user to remove.
     * @return Response
     * @throws NullValueException
     */
    public function destroy(int $id): Response
    {
        $this->userService->destroy($id);
        return response()->noContent();
    }
}
