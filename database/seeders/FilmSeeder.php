<?php

namespace Database\Seeders;

use Exception;
use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        Film::factory()->count(50)->create();
    }
}
