<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface 
{
    public function store(array $data);
    public function toggle(int $id): bool;
    public function delete(int $id): bool;
}