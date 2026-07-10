<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'user_id', 'reading_spot_id', 'hold_at', 'expires_at', 'status', 'notes',
    ];

    protected $casts = [
        'hold_at'    => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()        { return $this->belongsTo(User::class); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
    public function offlineBookCopies() { return $this->morphToMany(OfflineBookCopy::class, 'borrowable'); }

    public function scopeActive($q) { return $q->where('status', 'active'); }
}
