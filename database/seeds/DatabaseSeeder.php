<?php

use Illuminate\Database\Seeder;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            RolesAndPermissionsSeeder::class, 
            UserSeeder::class, 
            TopicSeeder::class, 
            TagSeeder::class,
        ];
        $this->call($seeders);
    }
}
