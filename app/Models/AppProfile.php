<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'reading_spot_id', 'app_name', 'logo', 'favicon',
        'primary_color', 'secondary_color',
        'about', 'terms', 'privacy_policy',
        'contact_email', 'contact_phone',
        'facebook', 'instagram', 'twitter', 'youtube',
    ];

    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }

    /**
     * Profil aplikasi yang dipakai untuk branding tampilan (nama, logo, favicon,
     * warna). Diambil dari reading spot pertama — deployment ini pada dasarnya
     * single-tenant per sekolah. Dibungkus try/catch supaya kegagalan DB tidak
     * membuat SELURUH halaman 500 (dipakai lewat View::composer di semua halaman).
     */
    public static function current(): self
    {
        try {
            return Cache::remember('app_profile.current', 300, function () {
                $spotId = \App\Models\ReadingSpot::orderBy('id')->value('id');
                if (!$spotId) {
                    return new self(['app_name' => config('app.name')]);
                }
                return static::firstOrCreate(
                    ['reading_spot_id' => $spotId],
                    ['app_name' => config('app.name')]
                );
            });
        } catch (\Throwable $e) {
            return new self(['app_name' => config('app.name')]);
        }
    }

    public static function forgetCache(): void
    {
        Cache::forget('app_profile.current');
    }
}
