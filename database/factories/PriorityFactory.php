<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\User;
use App\Models\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriorityFactory extends Factory
{
    /** @var string */
    protected $model = Priority::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'film_id' => Film::factory(),
            'level' => mt_rand(Priority::LOW, Priority::HIGH),
            'note' => $this->faker->sentence,
        ];
    }
}
