<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class VisitorLog extends Model
{
    protected $fillable = ['user_id', 'path', 'method', 'ip_address', 'user_agent', 'referer', 'latitude', 'longitude'];
    protected $casts    = ['latitude' => 'decimal:7', 'longitude' => 'decimal:7'];

    public function user() { return $this->belongsTo(User::class); }

    public function getMapUrlAttribute(): ?string
    {
        if ($this->latitude === null || $this->longitude === null) {
            return null;
        }
        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }

    public static function todayCount(): int
    {
        return static::whereDate('created_at', today())->count();
    }

    public static function monthCount(): int
    {
        return static::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
    }

    /** Jumlah kunjungan per hari, N hari terakhir — terbaru dahulu. */
    public static function dailyCounts(int $days = 30): Collection
    {
        $since = now()->subDays($days - 1)->startOfDay();
        $rows = static::where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as total')
            ->groupBy('d')->pluck('total', 'd');

        return collect(range(0, $days - 1))->map(function ($i) use ($rows) {
            $date = now()->subDays($i)->toDateString();
            return ['date' => $date, 'total' => (int) ($rows[$date] ?? 0)];
        });
    }

    /** Jumlah kunjungan per bulan, N bulan terakhir (rolling) — terlama dahulu, cocok untuk grafik garis. */
    public static function monthlyCounts(int $months = 12): Collection
    {
        $since = now()->subMonths($months - 1)->startOfMonth();
        $rows = static::where('created_at', '>=', $since)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as m, COUNT(*) as total")
            ->groupBy('m')->pluck('total', 'm');

        return collect(range($months - 1, 0))->map(function ($i) use ($rows) {
            $d = now()->subMonths($i);
            $key = $d->format('Y-m');
            return ['label' => $d->translatedFormat('M Y'), 'total' => (int) ($rows[$key] ?? 0)];
        });
    }

    /** Jumlah kunjungan per jam untuk satu tanggal tertentu (0-23). */
    public static function hourlyCounts(string $date): Collection
    {
        $rows = static::whereDate('created_at', $date)
            ->selectRaw('HOUR(created_at) as h, COUNT(*) as total')
            ->groupBy('h')->pluck('total', 'h');

        return collect(range(0, 23))->map(fn ($h) => ['hour' => $h, 'total' => (int) ($rows[$h] ?? 0)]);
    }
}
