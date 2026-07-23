<?php

namespace Database\Factories;

use App\IntelCategory;
use App\Models\IntelPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IntelPost>
 */
class IntelPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'intel_location_id' => null,
            'category' => $this->faker->randomElement(IntelCategory::cases()),
            'note' => $this->faker->sentence(8),
            'driver_handle' => 'Driver #'.$this->faker->numberBetween(10, 999),
            'helpful_count' => $this->faker->numberBetween(0, 30),
        ];
    }
}
