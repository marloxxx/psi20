<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
        ]);
        Setting::create([
            'site_name' => 'Laravel 10',
            'site_logo' => 'logo.png',
            'site_favicon' => 'favicon.png',
            'site_email' => 'help@gmail.com',
            'site_phone' => '0123456789',
        ]);
    }
}
