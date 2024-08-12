<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function create($data);
    public function find($userId);
    public function update($userId, $data);
    public function delete($userId);
}