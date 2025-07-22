<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publisher_id' => Publisher::inRandomOrder()->first()->id ?? Publisher::factory(),
            'year' => fake()->year(),
            'isbn' => fake()->isbn13(),
            'stock' => rand(0, 20),
        ];
    }
}
