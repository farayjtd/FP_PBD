<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    
    protected $guarded = [];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
