<?php

namespace Database\Seeders\Universal;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Example User',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
