<?php

namespace Database\Seeders;

use Exception;
use App\Models\Tag;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        $films = Film::factory()->count(50)->create();

        foreach ($films as $film) {
            $user = User::first();

            $film->followers()->sync([$user->id]);

            $tagIds = Tag::inRandomOrder()->limit(mt_rand(1, 5))->get()->pluck('id');

            $film->tags()->attach($tagIds);
        }
    }
}
