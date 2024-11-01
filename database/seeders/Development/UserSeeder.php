<?php

namespace Database\Seeders\Development;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(24)
            ->faked()
            ->create();
    }
}
