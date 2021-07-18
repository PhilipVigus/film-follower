<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\IgnoredTrailerTitlePhrases;
use Illuminate\Database\Eloquent\Factories\Factory;

class IgnoredTrailerTitlePhrasesFactory extends Factory
{
    protected $model = IgnoredTrailerTitlePhrases::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'phrase' => $this->faker->sentence(),
        ];
    }
}
