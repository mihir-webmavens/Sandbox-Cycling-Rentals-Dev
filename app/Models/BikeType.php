<?php

namespace App\Models;

use App\Enums\BikeTypeStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeType extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => BikeTypeStatusEnum::class,
        ];
    }
    protected $attributes = [
        'status' => BikeTypeStatusEnum::ACTIVE,
    ];
    protected $fillable = [
        'name',
        'slug',
        'code',
        'image',
        'description',
        'features',
        'status',
    ];
}
