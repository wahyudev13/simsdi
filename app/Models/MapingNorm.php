<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapingNorm extends Model
{
    use HasFactory;
    protected $table = "maping_norm_simrs";
    protected $fillable = ['id','id_pegawai','no_rkm_medis','created_at','updated_at'];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class,'id_pegawai');
    }
}


