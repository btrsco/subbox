<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Register the seeders for each environment.
     *
     * @var array|array[]
     */
    public array $seeders
        = [
            'universal'   => [
                Universal\UserSeeder::class,
            ],
            'production'  => [
                Production\UserSeeder::class,
            ],
            'development' => [
                Development\UserSeeder::class,
                Development\EmailSubscriberSeeder::class,
                Development\BlogSeeder::class,
                Development\PostSeeder::class,
                Development\SubscriptionSeeder::class,
            ],
        ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call($this->seeders['universal']);

        app()->environment(['production', 'staging'])
            ? $this->call($this->seeders['production'])
            : $this->call($this->seeders['development']);
    }
}
