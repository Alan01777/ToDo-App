<?php

namespace App\Repositories;

use App\Http\Exceptions\NullValueException;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    private $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user The User model instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new user.
     *
     * @param array $data The data for creating the user.
     * @return User The created user.
     */
    public function create($data)
    {
        $user = new $this->user([
            'name'  => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->save();

        return $user;
    }

    /**
     * Find a user by ID.
     *
     * @param int $userId The ID of the user to find.
     * @return User The found user.
     * @throws NullValueException If no user is found with the given ID.
     */
    public function find($userId)
    {
        $user = $this->user->with('tasks')->where('id', $userId)->first();
        if (!$user) {
            throw new NullValueException('No user found with id' . $userId);
        }
        return $user;
    }

    /**
     * Update a user by ID.
     *
     * @param int $userId The ID of the user to update.
     * @param array $data The data for updating the user.
     * @return User The updated user.
     * @throws NullValueException If no user is found with the given ID.
     */
    public function update($userId, $data)
    {
        $user = $this->user->find($userId);
        if (!$user) {
            throw new NullValueException('No user found with id: ' . $userId);
        }
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user by ID.
     *
     * @param int $userId The ID of the user to delete.
     * @throws NullValueException If no user is found with the given ID.
     */
    public function delete($userId)
    {
        $user = $this->user->find($userId);
        if (!$user) {
            throw new NullValueException('No user found with id' . $userId);
        }
        $user->delete();
    }
}
