<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Member;
use App\Models\Publisher;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalBooks' => Book::count(),
            'totalPublishers' => Publisher::count(),
            'totalMembers' => Member::count(),
            'totalCategories' => Category::count(),
            'totalBorrowed' => Borrowing::where('status', 'borrowed')->count(),
            'totalReturned' => Borrowing::where('status', 'returned')->count(),
        ]);
    }
}
