<?php

namespace App\Models\Datacenter;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $connection = 'mysql_datacenter';
    protected $table = 'jurusan';
    protected $guarded = ['id'];

    public function rombel() { return $this->hasMany(RombonganBelajar::class); }
}
