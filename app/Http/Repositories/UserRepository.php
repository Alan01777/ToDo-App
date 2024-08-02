<?php

namespace App\Http\Repositories;

use App\Http\Exceptions\NullValueException;
use App\Http\Repositories\Contracts\RepositoryInterface;
use App\Models\User;

class UserRepository implements RepositoryInterface
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
     * Get all users with their associated tasks.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of users.
     * @throws NullValueException If no users are found.
     */
    public function findall()
    {
        $users = $this->user->with('tasks')->paginate(25);
        if ($users->total() === 0) {
            throw new NullValueException('No users found!');
        }
        return $users;
    }

    /**
     * Create a new user.
     *
     * @param array $data The data for creating the user.
     * @return User The created user.
     */
    public function create($data)
    {
        return $this->user->create($data);
    }

    /**
     * Find a user by ID.
     *
     * @param int $id The ID of the user to find.
     * @return User The found user.
     * @throws NullValueException If no user is found with the given ID.
     */
    public function find($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            throw new NullValueException('No user found with id' . $id);
        }
        return $user;
    }

    /**
     * Update a user by ID.
     *
     * @param int $id The ID of the user to update.
     * @param array $data The data for updating the user.
     * @return User The updated user.
     * @throws NullValueException If no user is found with the given ID.
     */
    public function update($id, $data)
    {
        $user = $this->user->find($id);
        if (!$user){
            throw new NullValueException('No user found with id: ' . $id);
        }
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id The ID of the user to delete.
     * @throws NullValueException If no user is found with the given ID.
     */
    public function delete($id)
    {
        $user = $this->user->find($id);
        if(!$user){
            throw new NullValueException('No user found with id' . $id);
        }
        $user->delete();
    }
}
