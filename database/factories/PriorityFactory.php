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
        $priorities = [Priority::LOW, Priority::MEDIUM, Priority::HIGH];

        return [
            'user_id' => User::factory(),
            'film_id' => Film::factory(),
            'priority' => $priorities[mt_rand(0, 2)],
            'comment' => $this->faker->sentence,
        ];
    }
}
