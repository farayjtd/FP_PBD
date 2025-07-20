<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublisherController;

Route::get('/', fn() => view('dashboard'))->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('publisher', PublisherController::class);
Route::resource('member', MemberController::class);
Route::resource('category', CategoryController::class);
Route::resource('book', BookController::class);
Route::resource('borrowing', BorrowingController::class);