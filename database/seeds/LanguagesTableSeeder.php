<?php

use App\Models\Language;
use Illuminate\Support\Str;
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
            Language::firstOrCreate(
                ['slug' => Str::slug($language['name'])],
                ['name' => $language['name']]
            );
        }
    }
}
