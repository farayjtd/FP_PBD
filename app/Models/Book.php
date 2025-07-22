<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    
    protected $guarded = [];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function detail()
    {
        return $this->hasOne(BookDetail::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($book) {
            $book->detail()->delete();
        });
    }
}
