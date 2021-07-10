<?php

namespace Database\Seeders;

use Exception;
use App\Models\Film;
use App\Models\User;
use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        $user = User::first();

        foreach ($user->filmsToShortlist as $film) {
            if (mt_rand(0, 1)) {
                $user->priorities()->save(Priority::factory()->create(['film_id' => $film->id]));

                $user->films()
                    ->updateExistingPivot(
                        $film,
                        ['status' => Film::SHORTLISTED]
                    )
                ;
            }
        }
    }
}
