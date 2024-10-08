<?php

namespace App\Services\Auth;

use App\Http\Exceptions\NullValueException;
use App\Http\Requests\v1\UserRequest;
use App\Http\Resources\v1\UserResource;
use App\Repositories\Resources\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Http\Services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * UserService constructor.
     * @param \App\Repositories\Resources\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @return UserResource
     * @throws NullValueException
     */
    public function show(int $id): UserResource
    {
        $id = Auth::user()->id;
        $user = $this->userRepository->getById($id);
        return new UserResource($user);
    }

    /**
     * Update a user.
     *
     * @param \App\Http\Requests\v1\UserRequest $request
     * @param int $id
     * @return UserResource
     * @throws NullValueException
     */
    public function update(UserRequest $request, int $id): UserResource
    {
        $data = $request->validated();
        $user = $this->userRepository->update($id, $data);
        return new UserResource($user);
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return JsonResponse
     * @throws NullValueException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userRepository->delete($id);
        return response()->json(null, 204);
    }
}
