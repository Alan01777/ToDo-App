<?php

namespace App\Repositories\Contracts;

/**
 * The RepositoryInterface interface defines the contract for repository classes.
 */
interface ResourceRepositoryInterface
{
    /**
     * Retrieve all records owned by the user from the repository.
     *
     * @param int $userId The ID of the user.
     * @return array An array of records owned by the user.
     */
    public function findAllbyId($userId);


    // /**
    //  * Find all records by its ID and title.
    //  *
    //  * @param int $id The ID of the record.
    //  * @param string $title The title of the record.
    //  * @return mixed The found record.
    //  */
    // public function findAllbyTitle($id, $title);

    /**
     * Create a new record in the repository.
     *
     * @param array $data The data to create the record.
     * @return mixed The created record.
     */
    public function create($data);

    /**
     * Find a record by its ID in the repository.
     *
     * @param int $id The ID of the record to find.
     * @param int $userId The ID of the user.
     * @return mixed The found record.
     */
    public function find($id, $userId);

    /**
     * Update a record in the repository.
     *
     * @param int $id The ID of the record to update.
     * @param array $data The data to update the record.
     * @param int $userId The ID of the user.
     * @return mixed The updated record.
     */
    public function update($id, $data, $userId);

    /**
     * Delete a record from the repository.
     *
     * @param int $id The ID of the record to delete.
     * @param int $userId The ID of the user.
     * @return mixed The deleted record.
     */
    public function delete($id, $userId);
}
