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
        factory(App\UsersDashboard::class, 10)->create();
        // $this->call(UserSeeder::class);
    }
}
