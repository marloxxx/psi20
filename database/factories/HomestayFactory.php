<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Homestay>
 */
class HomestayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => 1,
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'description' => $this->faker->text,
            'total_rooms' => $this->faker->randomNumber(2),
            'price_per_night' => $this->faker->randomNumber(5),
            'is_available' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'owner_name' => $this->faker->name,
            'owner_phone_number' => $this->faker->phoneNumber,
            'is_approved' => 'approved',
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
