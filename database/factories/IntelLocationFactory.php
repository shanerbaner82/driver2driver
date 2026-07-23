<?php

namespace Database\Factories;

use App\IntelCategory;
use App\Models\IntelLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IntelLocation>
 */
class IntelLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' Gas Station',
            'address' => $this->faker->streetAddress(),
            'is_open' => true,
            'rating' => $this->faker->randomFloat(1, 2.5, 5.0),
            'bathroom_code' => null,
            'code_verified_at' => null,
            'distance_km' => $this->faker->randomFloat(1, 0.5, 30),
            'pin_category' => $this->faker->randomElement(IntelCategory::cases()),
            'map_x' => $this->faker->numberBetween(20, 300),
            'map_y' => $this->faker->numberBetween(60, 480),
            'tags' => ['Gas'],
        ];
    }

    /** A location with a crowd-verified restroom door code. */
    public function withBathroomCode(): static
    {
        return $this->state(fn (): array => [
            'bathroom_code' => (string) $this->faker->numberBetween(1000, 9999).'#',
            'code_verified_at' => now()->subHours(2),
            'tags' => ['Gas', 'Clean Bathrooms'],
        ]);
    }
}
