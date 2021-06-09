<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    protected $model = Film::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence;

        return [
            'guid' => $this->faker->unique()->url,
            'title' => $title,
            'slug' => Str::slug($title),
        ];
    }
}
