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
        $classes = [
            RolesAndPermissionsSeeder::class, 
            UserSeeder::class, 
            TopicSeeder::class, 
            TagSeeder::class,
            PlanSeeder::class
        ];
        $this->call($classes);
    }
}
