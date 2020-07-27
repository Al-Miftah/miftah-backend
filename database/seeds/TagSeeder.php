<?php

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TagSeeder extends Seeder
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
                ['slug' => Str::slug($tag['name'])],
                ['name' => $tag['name']]
            );
        }
    }
}
