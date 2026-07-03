<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'phone',
        'two_factor_secret', 'two_factor_enabled', 'is_active',
        'last_login_at', 'last_login_ip',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret'];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'password'           => 'hashed',
            'two_factor_enabled' => 'boolean',
            'is_active'          => 'boolean',
            'last_login_at'      => 'datetime',
        ];
    }

    public function member()    { return $this->hasOne(Member::class); }
    public function reviews()   { return $this->hasMany(Review::class); }
    public function wishlist()  { return $this->belongsToMany(Book::class, 'wishlists')->withPivot('created_at')->orderByPivot('created_at', 'desc'); }
    public function bookmarks() { return $this->hasMany(EbookBookmark::class); }
    public function activities(){ return $this->hasMany(ActivityLog::class); }
    public function readingSpots() {
        return $this->belongsToMany(ReadingSpot::class, 'reading_spot_user')
                    ->withPivot(['role','is_active','joined_at']);
    }
    public function holds()     { return $this->hasMany(Hold::class); }
    public function checkouts() { return $this->hasMany(Checkout::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
}
