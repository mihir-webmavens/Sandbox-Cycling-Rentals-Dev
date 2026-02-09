<?php

namespace Database\Seeders;

use App\Models\BikeType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BikeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (BikeType::exists()) {
            BikeType::query()->forceDelete();
            DB::statement('ALTER TABLE bike_types AUTO_INCREMENT = 1;');
        }

        BikeType::factory()->count(15)->create();
    }
}
