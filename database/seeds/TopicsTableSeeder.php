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
                'name' => 'Marriage',
                'slug' => 'marriage'
            ],
            [
                'name' => 'Stealing',
                'slug' => 'stealing'
            ],
            [
                'name' => 'Zakat',
                'slug' => 'zakat'
            ],
            [
                'name' => 'Salat',
                'slug' => 'salat'
            ],
            [
                'name' => 'Faith',
                'slug' => 'faith'
            ],
            [
                'name' => 'Hajj',
                'slug' => 'hajj'
            ]
        ];

        foreach ($topics as $topic) {
            Topic::firstOrCreate(
                ['slug' => $topic['slug']],
                $topic
            );
        }
    }
}
