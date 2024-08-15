<?php

namespace App\Services\Auth;

use App\Http\Exceptions\NullValueException;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
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
     * @param UserRepository $userRepository
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
        $user = $this->userRepository->find($id);
        return new UserResource($user);
    }

    /**
     * Update a user.
     *
     * @param UserRequest $request
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
