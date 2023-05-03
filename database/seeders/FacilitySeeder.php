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
            'icon' => 'fas fa-swimming-pool'
        ]);
        Facility::create([
            'name' => 'Free Wifi',
            'icon' => 'fas fa-wifi'
        ]);
        Facility::create([
            'name' => 'Free Parking',
            'icon' => 'fas fa-parking'
        ]);
        Facility::create([
            'name' => 'Free Breakfast',
            'icon' => 'fas fa-utensils'
        ]);
        Facility::create([
            'name' => 'Pet Allowed',
            'icon' => 'fas fa-dog'
        ]);
        Facility::create([
            'name' => 'TV',
            'icon' => 'fas fa-tv'
        ]);
    }
}
