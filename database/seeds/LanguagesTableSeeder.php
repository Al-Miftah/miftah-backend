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

            ],
            [
                'name' => 'Kussasi',

            ],
            [
                'name' => 'Ewe',

            ],
            [
                'name' => 'Fante',

            ],
            [
                'name' => 'Mamprusi',

            ]
        ];

        foreach ($languages as $language) {
            Topic::firstOrCreate(
                ['slug' => str_slug($language['name'])],
                ['name' => $language['name']]
            );
        }
    }
}
