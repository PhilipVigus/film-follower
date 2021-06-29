<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Priority;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        foreach (Film::all() as $film) {
            $user = User::first();

            $film->followers()->sync([$user->id]);

            if (rand(0, 1)) {

                $user->priorities()->save(Priority::factory()->create(['film_id' => $film->id]));

                $user->films()
                    ->updateExistingPivot(
                        $film,
                        ['status' => Film::SHORTLISTED]
                    )
                ;
            }        }
    }
}
