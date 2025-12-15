<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'borrower_id',
        'equipment_id',
        'borrow_date',
        'return_date',
        'status'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
    ];

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
