<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'member_id', 'book_id', 'reserved_at', 'expires_at',
        'queue_position', 'status', 'notes',
    ];

    protected $casts = ['reserved_at' => 'datetime', 'expires_at' => 'datetime'];

    public function member() { return $this->belongsTo(Member::class); }
    public function book()   { return $this->belongsTo(Book::class); }
}
