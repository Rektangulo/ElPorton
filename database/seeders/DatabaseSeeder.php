<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		$this->call([
            RoleSeeder::class,
			ImageSeeder::class,
			TagSeeder::class,
			CategorySeeder::class,
			MenuSeeder::class,
			AdminUserSeeder::class,
			ReservationSeeder::class,
			ContactMessageSeeder::class,
        ]);
    }
}
