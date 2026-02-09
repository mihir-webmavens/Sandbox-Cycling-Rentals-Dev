<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Mihir',
            'last_name'  => 'Soni',
            'phone'      => '1234567890',
            'country'    => 'US',
            'email'      => 'admin@admin.com',
            'password'   => bcrypt('password'),
        ]);
    }
}
