<?php

namespace App\Http\Repositories\Contracts;

/**
 * The RepositoryInterface interface defines the contract for repository classes.
 */
interface RepositoryInterface
{
    /**
     * Retrieve all records from the repository.
     *
     * @return array
     */
    public function findall();

    /**
     * Create a new record in the repository.
     *
     * @param array $data The data to create the record.
     * @return mixed
     */
    public function create($data);

    /**
     * Find a record by its ID in the repository.
     *
     * @param int $id The ID of the record to find.
     * @return mixed
     */
    public function find($id);

    /**
     * Update a record in the repository.
     *
     * @param int $id The ID of the record to update.
     * @param array $data The data to update the record.
     * @return mixed
     */
    public function update($id, $data);

    /**
     * Delete a record from the repository.
     *
     * @param int $id The ID of the record to delete.
     * @return mixed
     */
    public function delete($id);
}