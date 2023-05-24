<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WithoutModelEvents::class;
        Event::factory()
            ->count(20)
            ->create();
        Image::factory()
            ->count(100)
            ->create();
    }
}
