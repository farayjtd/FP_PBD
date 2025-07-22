<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Member;
use App\Models\Book;
use App\Models\BookDetail;
use App\Models\Borrowing;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Publisher::factory(1000)->create();
        Category::factory(20)->create();

        Member::factory(2000)->create();

        Book::factory(10000)->create()->each(function ($book) {
            BookDetail::factory()->create(['book_id' => $book->id]);

            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $book->categories()->attach($categories);
        });

        Borrowing::factory(1000)->create();
    }
}