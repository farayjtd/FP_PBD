<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    use HasFactory;

    protected $table = 'book_details';
    
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
