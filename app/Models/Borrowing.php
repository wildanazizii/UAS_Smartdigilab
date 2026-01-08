<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'borrower_id',
        'equipment_id',
        'request_letter_path',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
