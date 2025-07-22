<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookDetail>
 */
class BookDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'shelf_code' => strtoupper(fake()->bothify('A##')),
            'pages' => fake()->numberBetween(100, 600),
            'weight' => fake()->numberBetween(300, 1500),
            'language' => fake()->randomElement(['English', 'Indonesian', 'French']),
            'size' => fake()->randomElement(['A5', 'A4', 'B5']),
            'book_condition' => fake()->randomElement(['new', 'used']),
        ];
    }
}
