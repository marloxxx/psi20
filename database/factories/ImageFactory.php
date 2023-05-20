<?php

namespace Database\Factories;

use App\Models\Homestay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // get all homestay id
        $homestay_ids = Homestay::pluck('id')->toArray();
        return [
            'homestay_id' => $this->faker->randomElement($homestay_ids),
            'name' => $this->faker->name,
            'size' => $this->faker->randomNumber(),
            'image_path' => $this->faker->imageUrl(),
            'is_primary' => $this->faker->boolean,
        ];
    }
}
