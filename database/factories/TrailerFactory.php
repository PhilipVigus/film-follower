<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\Trailer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrailerFactory extends Factory
{
    /** @var string */
    protected $model = Trailer::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence;

        return [
            'film_id' => Film::factory(),
            'guid' => $this->faker->unique()->url,
            'title' => $title,
            'slug' => Str::slug($title),
            'type' => $this->faker->word,
            'image' => $this->faker->imageUrl,
            'link' => $this->faker->unique()->url,
            'uploaded_at' => $this->faker->dateTimeThisDecade(),
        ];
    }
}
