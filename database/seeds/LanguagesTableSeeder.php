<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'name' => 'Waale',
                
            ],
            [
                'name' => 'Dagbani',

            ],
            [
                'name' => 'Hausa',

            ],
            [
                'name' => 'Twi',

            ],
            [
                'name' => 'Frafra'
            ],
            [
                'name' => 'Sisaale',

            ]
        ];
    }
}
