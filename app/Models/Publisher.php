<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publisher';
    
    protected $guarded = [];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
