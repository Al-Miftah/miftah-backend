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
                'title' => 'Ramadan',
            ],
            [
                'title' => 'Fasting',
            ],
            [
                'title' => 'Marriage',
            ],
            [
                'title' => 'Fiqh',
            ],
            [
                'title' => 'Divorce',
            ],
            [
                'title' => 'Dua',
            ],
            [
                'title' => 'Hajj',
            ],
            [
                'title' => 'Islamic Finance',
            ],
            [
                'title' => 'History',
            ],
            [
                'title' => 'Hadith',
            ],
            [
                'title' => 'Quran',
            ],
            [
                'title' => 'Names of Allah',
            ],
            [
                'title' => 'Parenting',
            ],
            [
                'title' => 'Salah',
            ],
            [
                'title' => 'Seera',
            ],
            [
                'title' => 'Prophets',
            ],
            [
                'title' => 'Nawafil',
            ],
            [
                'title' => 'Women',
            ],
            [
                'title' => 'Zakat',
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
