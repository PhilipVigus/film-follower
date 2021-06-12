<?php

namespace Database\Seeders;

use Exception;
use App\Models\Film;
use App\Models\Trailer;
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
            Trailer::factory(mt_rand(1, 3))->create(['film_id' => $film->id]);
        }
    }
}
