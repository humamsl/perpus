<?php

namespace App\Models\Datacenter;

use Illuminate\Database\Eloquent\Model;

class SiswaRombel extends Model
{
    protected $connection = 'mysql_datacenter';
    protected $table = 'siswa_rombel';
    protected $guarded = ['id'];

    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function rombel() { return $this->belongsTo(RombonganBelajar::class, 'rombongan_belajar_id'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
}
