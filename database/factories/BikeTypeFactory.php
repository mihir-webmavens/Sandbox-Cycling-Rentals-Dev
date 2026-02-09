<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BikeType>
 */
class BikeTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $baseImagePath = 'bike-types/default/';
        $bikeTypeNames = [
            'Mountain Bike',
            'Road Bike',
            'Hybrid Bike',
            'City Bike',
            'Electric Bike',
            'Cruiser Bike',
            'BMX Bike',
            'Touring Bike',
            'Folding Bike',
            'Fat Tire Bike',
            'Gravel Bike',
            'Commuter Bike',
            'Track Bike',
            'Fixie Bike',
            'Cargo Bike',
            'Tandem Bike',
            'Downhill Bike',
            'Enduro Bike',
            'Trail Bike',
            'Cross-Country Bike',
            'All-Mountain Bike',
            'Sport Bike',
            'Adventure Bike',
            'Urban Bike',
            'Mini Velo Bike',
            'Quad Bike',
            'Recumbent Bike',
            'Freestyle Bike',
            'Hardtail Mountain Bike',
            'Full Suspension Bike',
            'Electric Mountain Bike',
            'Electric Road Bike',
            'Electric Commuter Bike',
            'Kids Bike',
            'Balance Bike',
            'Tricycle Bike',
            'Women’s Comfort Bike',
            'Mens Performance Bike',
            'Fitness Bike',
            'Speed Bike',
            'Shock Absorber Bike',
            'Classic Vintage Bike',
            'Retro Cruiser Bike',
            'Flat Bar Road Bike',
            'Cyclocross Bike',
            'Snow Bike',
            'Ice Bike',
            'Beach Cruiser',
            'Compact Folding Bike',
            'Ultra Light Road Bike',
            'Steel Frame Bike',
            'Carbon Frame Bike',
            'Aluminum Hybrid Bike',
            'Bikepacking Bike',
            'Performance Touring Bike',
            'Long-Distance Endurance Bike',
            'High-Performance Gravel Bike',
            'Electric Folding Bike',
            'Suspension Commuter Bike',
            'Step-Through City Bike',
            'Sport Hybrid Bike',
            'Comfort Hybrid Bike',
            'Aero Road Bike',
            'Time Trial Bike',
            'Utility Cargo Bike',
            'Heavy-Duty Cargo Bike',
            'Mountain Trail Pro Bike',
            'Cliff Climber Mountain Bike',
            'Speedster Road Bike',
            'Eco Electric Commuter Bike',
            'Urban Performance Bike',
            'Comfort Cruiser Bike',
            'Extreme Downhill Bike',
            'Adventure Gravel Bike',
            'Trailblazer Mountain Bike',
            'Cross-Terrain Bike',
            'All-Terrain Pro Bike',
            'High-Speed Commuter Bike',
            'City Runner Bike',
            'Ultra Racing Road Bike',
            'Hybrid Sport Pro Bike',
            'Versa Ride Hybrid Bike',
            'Prime Electric Road Bike',
            'Metro City Commuter Bike',
            'Explorer Hybrid Bike',
            'MaxRide Mountain Bike',
            'Velocity Road Bike',
            'Summit Trail Bike',
            'Freedom Cruiser Bike',
            'TrailKing Mountain Bike',
            'Urban Flex Bike',
            'StormRider Mountain Bike',
            'Pro-Endurance Road Bike',
            'WindCutter Aero Bike',
            'PathFinder Hybrid Bike',
            'RockMaster Mountain Bike',
            'StonePath Gravel Bike',
            'FireTrail Mountain Bike',
            'SpeedTrail Gravel Bike',
            'TerrainX Mountain Bike',
        ];
        $name = $this->faker->unique()->randomElement($bikeTypeNames);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'code'        => strtoupper($this->faker->unique()->bothify('BT###')),
            'description' => $this->faker->sentence(),
            'features'    => $this->faker->words(3, true),
            'status'      => $this->faker->randomElement([0, 1]),
        ];
    }
}
