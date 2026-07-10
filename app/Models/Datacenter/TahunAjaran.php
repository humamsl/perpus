<?php

namespace App\Models\Datacenter;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $connection = 'mysql_datacenter';
    protected $table = 'tahun_ajaran';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function rombel() { return $this->hasMany(RombonganBelajar::class); }
}
