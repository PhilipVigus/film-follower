<?php

namespace Database\Seeders;

use Exception;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            throw new Exception("You can't run this seeder in production!");
        }

        User::factory()->create(['name' => 'guest', 'email' => 'guest@user.com']);
        User::factory()->create(['name' => 'Phil', 'email' => config('film-follower.admin-email')]);
    }
}
