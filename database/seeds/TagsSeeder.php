<?php

use Anticafe\Http\Models\Tag;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            "Xbox",
            "Чай и кофе",
            "Настолки",
            "Wi-Fi",
            "Проектор",
            "PlayStation",
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate([
                "slug" => $tag,
               "name" => $tag,
            ]);
        }

    }
}
