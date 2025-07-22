<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    public function definition(): array
    {
        $borrowedDate = fake()->dateTimeBetween('-1 year', 'now');
        $isReturned = fake()->boolean(70);
        return [
            'member_id' => Member::inRandomOrder()->first()->id ?? Member::factory(),
            'book_id' => Book::inRandomOrder()->first()->id ?? Book::factory(),
            'borrowed' => $borrowedDate->format('Y-m-d'),
            'returned' => $isReturned ? fake()->dateTimeBetween($borrowedDate, 'now')->format('Y-m-d') : null,
            'status' => $isReturned ? 'returned' : 'borrowed',
        ];
    }
}
