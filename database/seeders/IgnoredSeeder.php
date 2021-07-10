<?php

namespace Database\Seeders;

use Exception;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;

class IgnoredSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        $user = User::first();

        foreach ($user->filmsToShortlist as $film) {
            if (mt_rand(0, 1)) {
                $user->films()
                    ->updateExistingPivot(
                        $film,
                        ['status' => Film::IGNORED]
                    )
                ;
            }
        }
    }
}
