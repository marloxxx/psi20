<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // assign role to user
        $users = \App\Models\User::where('id', '>', 1)->get();
        foreach ($users as $user) {
            $user->assignRole('customer');
        }
    }
}
