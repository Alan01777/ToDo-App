<?php

namespace App\Http\Services;

use App\Http\Requests\UserRequest;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\UserResource;

/**
 * Class UserService
 * @package App\Http\Services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users.
     *
     * @return UserResource
     */
    public function index()
    {
        $users = $this->userRepository->findall();
        return UserResource::collection($users);
    }

    /**
     * Store a new user.
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRepository->create($data);
        return new UserResource($user);
    }

    /**
     * Get a specific user by ID.
     *
     * @param int $id
     * @return UserResource
     */
    public function show(int $id)
    {
        $user = $this->userRepository->find($id);
        return new UserResource($user);
    }

    /**
     * Update a user.
     *
     * @param UserRequest $request
     * @param int $id
     * @return UserResource
     */
    public function update(UserRequest $request, int $id)
    {
        $data = $request->validated();
        $user = $this->userRepository->update($id, $data);
        return new UserResource($user);
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->userRepository->delete($id);
        return response()->json(null, 204);
    }
}