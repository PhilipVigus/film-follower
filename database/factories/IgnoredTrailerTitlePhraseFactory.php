<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\IgnoredTrailerTitlePhrase;
use Illuminate\Database\Eloquent\Factories\Factory;

class IgnoredTrailerTitlePhraseFactory extends Factory
{
    protected $model = IgnoredTrailerTitlePhrase::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'phrase' => $this->faker->sentence(),
        ];
    }
}
