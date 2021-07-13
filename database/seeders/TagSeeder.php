<?php

namespace Database\Seeders;

use Exception;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        Tag::factory()->count(50)->create();
    }
}
