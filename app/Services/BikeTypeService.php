<?php

namespace App\Services;

use App\Repositories\BikeTypeRepository;

class BikeTypeService
{
    protected BikeTypeRepository $repository;

    public function __construct(BikeTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all($request = null)
    {
        return $this->repository->all($request);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
