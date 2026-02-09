<?php

namespace App\Repositories;

use App\Models\BikeType;

class BikeTypeRepository
{
    public function query()
    {
        return BikeType::query();
    }

    public function all($request = null)
    {
        $query = BikeType::query();

        if ($request) {
            // Filters
            $query->when(! empty($request['name']), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request['name'] . '%');
            });

            $query->when(! empty($request['code']), function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request['code'] . '%');
            });

            // Sorting
            $sort = $request['sort'] ?? 'latest';

            match ($sort) {
                'latest' => $query->latest(),
                'oldest' => $query->oldest(),
                'asc'    => $query->orderBy('name', 'asc'),
                'desc'   => $query->orderBy('name', 'desc'),
                default  => $query->latest(),
            };
        }

        return $query->paginate(15);
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
