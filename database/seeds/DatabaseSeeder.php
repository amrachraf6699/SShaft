<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
            UsersTableSeeder::class,
            PagesTableSeeder::class,
            // DonorsTableSeeder::class,
            SettingsTableSeeder::class,
        ]);
    }
}
