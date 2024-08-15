<?php

namespace App\Repositories\Contracts;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * The RepositoryInterface interface defines the contract for repository classes.
 */
interface ResourceRepositoryInterface
{
    /**
     * Retrieve all records owned by the user from the repository.
     *
     * @param int $userId The ID of the user.
     * @return AnonymousResourceCollection An array of records owned by the user.
     */
    public function findAllById(int $userId): AnonymousResourceCollection;

    /**
     * Create a new record in the repository.
     *
     * @param array $data The data to create the record.
     * @return mixed The created record.
     */
    public function create(array $data): mixed;

    /**
     * Find a record by its ID in the repository.
     *
     * @param int $id The ID of the record to find.
     * @param int $userId The ID of the user.
     * @return mixed The found record.
     */
    public function find(int $id, int $userId): mixed;

    /**
     * Update a record in the repository.
     *
     * @param int $id The ID of the record to update.
     * @param array $data The data to update the record.
     * @param int $userId The ID of the user.
     * @return mixed The updated record.
     */
    public function update(int $id, array $data, int $userId): mixed;

    /**
     * Delete a record from the repository.
     *
     * @param int $id The ID of the record to delete.
     * @param int $userId The ID of the user.
     * @return mixed The deleted record.
     */
    public function delete(int $id, int $userId): mixed;
}
