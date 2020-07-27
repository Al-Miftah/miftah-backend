<?php

use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TopicSeeder extends Seeder
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
                'description' => ''
            ],
            [
                'title' => 'Fasting',
                'description' => ''
            ],
            [
                'title' => 'Marriage in the 21st century',
                'description' => ''
            ],
            [
                'title' => 'Fiqh',
                'description' => ''
            ],
            [
                'title' => 'Divorce',
                'description' => ''
            ],
            [
                'title' => 'Dua',
                'description' => ''
            ],
            [
                'title' => 'Hajj',
                'description' => ''
            ],
            [
                'title' => 'Islamic Finance',
                'description' => ''
            ],
            [
                'title' => 'History',
                'description' => ''
            ],
            [
                'title' => 'Hadith',
                'description' => ''
            ],
            [
                'title' => 'Benefits of reciting Quran',
                'description' => ''
            ],
            [
                'title' => 'Names of Allah',
                'description' => ''
            ],
            [
                'title' => 'Parenting',
                'description' => ''
            ],
            [
                'title' => 'Salah',
                'description' => ''
            ],
            [
                'title' => 'Seera',
                'description' => ''
            ],
            [
                'title' => 'Prophets',
                'description' => ''
            ],
            [
                'title' => 'Nawafil',
                'description' => ''
            ],
            [
                'title' => 'Women',
                'description' => ''
            ],
            [
                'title' => 'Zakat',
                'description' => ''
            ]
        ];

        foreach ($topics as $topic) {
            Topic::firstOrCreate(
                ['slug' => Str::slug($topic['title'])],
                ['title' => $topic['title']]
            );
        }
    }
}
