<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class EmailSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailSubscribers = \App\Models\EmailSubscriber::factory()
            ->count(50)
            ->faked()
            ->create();
    }
}
