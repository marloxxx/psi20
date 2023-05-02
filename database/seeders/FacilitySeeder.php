<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::create([
            'name' => 'Swimming Pool',
        ]);
        Facility::create([
            'name' => 'Free Wifi',
        ]);
        Facility::create([
            'name' => 'Free Parking',
        ]);
        Facility::create([
            'name' => 'Free Breakfast',
        ]);
        Facility::create([
            'name' => 'Spa',
        ]);
    }
}
