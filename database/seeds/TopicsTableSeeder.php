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
                'title' => 'Ramadan 2019 series',
            ],
            [
                'title' => 'Marriage in Islam series',
            ],
            [
                'title' => '99 names of Allah series',
            ],
            [
                'title' => 'The companions of the prophet series',
            ],
            [
                'title' => 'Tafsir of Suratul Baqara series',
            ],
            [
                'title' => 'The life of the project series',
            ],
            [
                'title' => 'Wives of the prophet series',
            ],
            [
                'title' => 'Purification of the soul series',
            ],
            [
                'title' => 'Tafsir of suratul Maryam series',
            ],
            [
                'title' => 'Benefits of reciting the Quran series',
            ]
        ];

        foreach ($topics as $topic) {
            Topic::firstOrCreate(
                ['slug' => str_slug($topic['title'])],
                ['title' => $topic['title']]
            );
        }
    }
}
