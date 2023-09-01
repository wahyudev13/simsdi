<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkRkk extends Model
{
    use HasFactory;
    protected $table = "spk_rkk";
    protected $fillable = ['id','id_pegawai','nomor_spk','departemen_id','kualifikasi','file','created_at','updated_at'];
}
