<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\Demo\{UserTesterSeeder,
                           KpiTypeTesterSeeder,
                           KpiItemsTesterSeeder};
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(UserTesterSeeder::class);
        $this->call(KpiTypeTesterSeeder::class);
        $this->call(KpiItemsTesterSeeder::class);

    }
}
