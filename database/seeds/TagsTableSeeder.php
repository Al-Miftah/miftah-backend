<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['name' => 'Marriage'],
            ['name' => 'Stealing'],
            ['name' => 'Zakat'],
            ['name' => 'Salat'],
            ['name' => 'Fasting'],
            ['name' => 'Divorce'],
            ['name' => 'Quran'],
            ['name' => 'Niqab'],
            ['name' => 'Hijab'],
            ['name' => 'Nawafil'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => str_slug($tag['name'])],
                ['name' => $tag['name']]
            );
        }
    }
}
