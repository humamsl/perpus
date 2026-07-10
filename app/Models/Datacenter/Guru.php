<?php

namespace App\Models\Datacenter;

use Illuminate\Database\Eloquent\Model;

/**
 * Mirror read/write langsung ke tabel `guru` (PTK) di database Data Center
 * (koneksi 'mysql_datacenter'). Bukan model milik Perpus.
 */
class Guru extends Model
{
    protected $connection = 'mysql_datacenter';
    protected $table = 'guru';
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
}
