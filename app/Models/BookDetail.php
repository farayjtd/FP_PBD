<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $table = 'book_detail';
    
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
