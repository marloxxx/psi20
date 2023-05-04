<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            FacilitySeeder::class,
        ]);
        $admin = \App\Models\User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@gmail.com',
            'phone_number' => '0123456789',
            'date_of_birth' => '1990-01-01',
            'password' => Hash::make('password'),
            'profile_picture' => 'profile.png',
        ]);

        $admin->assignRole('admin');

        Setting::create([
            'site_name' => 'Laravel 10',
            'site_logo' => 'logo.png',
            'site_favicon' => 'favicon.png',
            'site_email' => 'help@gmail.com',
            'site_phone' => '6282386143124',
        ]);
    }
}
