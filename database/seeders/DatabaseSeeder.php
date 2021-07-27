<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            FilmSeeder::class,
            TrailerSeeder::class,
            PrioritySeeder::class,
            ReviewSeeder::class,
            IgnoredSeeder::class,
        ]);
    }
}
