<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = [
            [
                'name' => 'Ramadan 2019 series',
            ],
            [
                'name' => 'Marriage in Islam series',
            ],
            [
                'name' => '99 names of Allah series',
            ],
            [
                'name' => 'The companions of the prophet series',
            ],
            [
                'name' => 'Tafsir of Suratul Baqara series',
            ],
            [
                'name' => 'The life of the project series',
            ],
            [
                'name' => 'Wives of the prophet series',
            ],
            [
                'name' => 'Purification of the soul series',
            ],
            [
                'name' => 'Tafsir of suratul Maryam series',
            ],
            [
                'name' => 'Benefits of reciting the Quran series',
            ]
        ];

        foreach ($topics as $topic) {
            Topic::firstOrCreate(
                ['slug' => str_slug($topic['name'])],
                ['name' => $topic['name']]
            );
        }
    }
}
