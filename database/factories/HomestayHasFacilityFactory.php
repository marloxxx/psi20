<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\Homestay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomestayHasFacility>
 */
class HomestayHasFacilityFactory extends Factory
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
        // get all facility id
        $facility_ids = Facility::pluck('id')->toArray();
        return [
            'homestay_id' => $this->faker->randomElement($homestay_ids),
            'facility_id' => $this->faker->randomElement($facility_ids),
        ];
    }
}
