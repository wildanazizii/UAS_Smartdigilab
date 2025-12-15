<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $fillable = [
        'name',
        'nim',
        'contact'
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
