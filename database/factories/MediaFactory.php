<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Media> */
class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'title'    => fake()->unique()->words(3, true),
            'type'     => fake()->randomElement(['Anime', 'Film', 'Series']),
            'genre'    => fake()->randomElement(['Action', 'Drama', 'Romance', 'Comedy']),
            'score'    => fake()->randomFloat(1, 5, 10),
            'episodes' => fake()->numberBetween(1, 200),
            'vibe'     => fake()->randomElement(['High Energy', 'Melancholy', 'Binge Mode', 'Chill']),
        ];
    }
}
