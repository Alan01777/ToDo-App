<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array $data The user data.
     * @return mixed The created user.
     */
    public function create($data);

    /**
     * Find a user by ID.
     *
     * @param int $userId The user ID.
     * @return mixed The found user.
     */
    public function find($userId);

    /**
     * Update a user.
     *
     * @param int $userId The user ID.
     * @param array $data The updated user data.
     * @return mixed The updated user.
     */
    public function update($userId, $data);

    /**
     * Delete a user.
     *
     * @param int $userId The user ID.
     * @return bool True if the user was deleted successfully, false otherwise.
     */
    public function delete($userId);
}