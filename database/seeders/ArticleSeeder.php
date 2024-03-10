<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Author;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Pobieranie wszystkie istniejących ID autorów
        $authorIds = Author::pluck('id');

        foreach (range(1, 20) as $index) {
            // geenerowanie losowego ID autora
            $authorId = $faker->randomElement($authorIds);

            Article::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
              /*  'author_id' => $authorId, */
            ]);
        }
    }
}