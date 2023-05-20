<?php

namespace Database\Seeders;

use App\Models\Homestay;
use App\Models\HomestayHasFacility;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomestaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Homestay::factory()
            ->count(20)
            ->create();
        HomestayHasFacility::factory()
            ->count(100)
            ->create();
        Image::factory()
            ->count(100)
            ->create();
    }
}
