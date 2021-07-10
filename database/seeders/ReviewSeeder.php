<?php

namespace Database\Seeders;

use Exception;
use App\Models\Film;
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        $user = User::first();

        foreach (Film::all() as $film) {
            if (mt_rand(0, 1)) {
                $user->reviews()->save(Review::factory()->create(['film_id' => $film->id]));

                $user->films()
                    ->updateExistingPivot(
                        $film,
                        ['status' => Film::WATCHED]
                    )
                ;
            }
        }
    }
}
