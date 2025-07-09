<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "pegawai";
    protected $fillable = ['id','nik','nama','jk','jbtn','jnj_jabatan'];

    public function pengguna() {
        return $this->hasOne(User::class,'id_pegawai','id');
    }

    public function maping_norm_simrs() {
        return $this->hasOne(MapingNorm::class,'id');
    }

    public function file_ijazah() {
        return $this->hasMany(FileIjazah::class,'id');
    }
}
