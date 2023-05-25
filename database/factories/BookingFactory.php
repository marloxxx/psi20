<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = \App\Models\User::pluck('id')->toArray();
        $homestays = \App\Models\Homestay::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'code' => $this->faker->word,
            'adults' => $this->faker->numberBetween(1, 10),
            'children' => $this->faker->numberBetween(1, 10),
            'check_in' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
            'check_out' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
            'homestay_id' => $this->faker->randomElement($homestays),
            'total_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'payment_proof' => $this->faker->imageUrl(640, 480),
            // 'snap_token' => $this->faker->word,
            'payment_status' => $this->faker->randomElement(['1', '2', '3', '4']),
        ];
    }
}
