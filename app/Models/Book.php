<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    
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
        return $this->belongsToMany(Category::class, 'book_category');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($book) {
            $book->detail()->delete();
        });
    }
}
