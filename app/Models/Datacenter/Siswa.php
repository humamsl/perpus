<?php

namespace App\Models\Datacenter;

use Illuminate\Database\Eloquent\Model;

/**
 * Mirror read/write langsung ke tabel `siswa` di database Data Center (koneksi
 * 'mysql_datacenter', lihat config/database.php). Bukan model milik Perpus —
 * jangan tambahkan relasi ke model Perpus (Member/User) di sini.
 */
class Siswa extends Model
{
    protected $connection = 'mysql_datacenter';
    protected $table = 'siswa';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_aktif' => 'boolean',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
            'locked_until' => 'datetime',
        ];
    }

    public function rombelSekarang()
    {
        return $this->hasOne(SiswaRombel::class)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('is_aktif', true));
    }

    public function siswaRombel()
    {
        return $this->hasMany(SiswaRombel::class);
    }
}
