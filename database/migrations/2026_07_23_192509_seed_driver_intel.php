<?php

use App\IntelCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the Driver-to-Driver demo data. On-device there is no `db:seed`,
 * so demo content ships as a migration — it runs once per install and is
 * safe on updates (inserts only, keyed off a fresh empty table).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('intel_locations')->exists()) {
            return;
        }

        $now = now();

        DB::table('intel_locations')->insert([
            [
                'id' => 1,
                'name' => 'Shell Gas Station',
                'address' => '123 Highway 401 Eastbound',
                'is_open' => true,
                'rating' => 4.5,
                'bathroom_code' => '1234#',
                'code_verified_at' => $now->copy()->subHours(2),
                'distance_km' => 12.0,
                'pin_category' => IntelCategory::CleanBathroom->value,
                'map_x' => 165,
                'map_y' => 140,
                'tags' => json_encode(['Gas', 'Clean Bathrooms']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Maple Court Apartments',
                'address' => '124 Maple St',
                'is_open' => true,
                'rating' => 3.0,
                'bathroom_code' => null,
                'code_verified_at' => null,
                'distance_km' => 2.4,
                'pin_category' => IntelCategory::BuildingAccess->value,
                'map_x' => 110,
                'map_y' => 330,
                'tags' => json_encode(['Access', 'Dog Alert']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => '5th & Main Fuel Stop',
                'address' => '500 Main St',
                'is_open' => true,
                'rating' => 4.0,
                'bathroom_code' => null,
                'code_verified_at' => null,
                'distance_km' => 5.1,
                'pin_category' => IntelCategory::DogAlert->value,
                'map_x' => 250,
                'map_y' => 255,
                'tags' => json_encode(['Gas', 'Restroom']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('intel_posts')->insert([
            [
                'intel_location_id' => 2,
                'category' => IntelCategory::DogAlert->value,
                'note' => '124 Maple St - Aggressive dog loose in front yard. Avoid!',
                'driver_handle' => 'Driver #892',
                'helpful_count' => 12,
                'created_at' => $now->copy()->subMinutes(2),
                'updated_at' => $now->copy()->subMinutes(2),
            ],
            [
                'intel_location_id' => 2,
                'category' => IntelCategory::BuildingAccess->value,
                'note' => 'Apt 4B - Side Gate Unlocked. Use code 4492 for lobby.',
                'driver_handle' => 'Driver #104',
                'helpful_count' => 5,
                'created_at' => $now->copy()->subMinutes(15),
                'updated_at' => $now->copy()->subMinutes(15),
            ],
            [
                'intel_location_id' => 3,
                'category' => IntelCategory::CleanBathroom->value,
                'note' => 'Gas Station at 5th & Main. Clean, no key needed.',
                'driver_handle' => 'Driver #44',
                'helpful_count' => 28,
                'created_at' => $now->copy()->subHour(),
                'updated_at' => $now->copy()->subHour(),
            ],
            [
                'intel_location_id' => null,
                'category' => IntelCategory::TrafficParking->value,
                'note' => 'Construction blocking alley behind 800 Block. Park on street.',
                'driver_handle' => 'Driver #210',
                'helpful_count' => 3,
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ],
            [
                'intel_location_id' => 1,
                'category' => IntelCategory::CleanBathroom->value,
                'note' => 'Pumps 3 & 4 are out of order. Bathrooms were spotless though. Code works.',
                'driver_handle' => 'Mike T.',
                'helpful_count' => 12,
                'created_at' => $now->copy()->subHours(3),
                'updated_at' => $now->copy()->subHours(3),
            ],
            [
                'intel_location_id' => 1,
                'category' => IntelCategory::GasPrice->value,
                'note' => 'Coffee is actually hot here. Plenty of parking out back for larger rigs right now.',
                'driver_handle' => 'Sarah J.',
                'helpful_count' => 5,
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now->copy()->subDay(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('intel_posts')->delete();
        DB::table('intel_locations')->delete();
    }
};
