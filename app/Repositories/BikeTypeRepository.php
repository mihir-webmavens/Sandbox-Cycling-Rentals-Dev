<?php

namespace App\Repositories;

use App\Models\BikeType;

class BikeTypeRepository
{
    public function query()
    {
        return BikeType::query();
    }

    public function all()
    {
        return BikeType::all();
    }

    public function paginate(?int $perpage = null)
    {
        return BikeType::paginate($perpage ?? config('app.product_per_page'));
    }

    public function find($id)
    {
        return BikeType::findOrFail($id);
    }

    public function create(array $data)
    {
        return BikeType::create($data);
    }

    public function update($id, array $data)
    {
        $record = BikeType::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $record = BikeType::findOrFail($id);
        $record->delete();

        return $record;
    }
}
