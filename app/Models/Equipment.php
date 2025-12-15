<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';
    
    protected $fillable = [
        'name',
        'code',
        'description',
        'quantity',
        'availability_status'
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
