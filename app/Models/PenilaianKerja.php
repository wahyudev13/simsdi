<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKerja extends Model
{
    use HasFactory;
    protected $table = "penilaian_kerja";
    protected $fillable = ['id','id_pegawai','tgl_penilaian','departemen_id','jabatan','jml_total','keterangan','file','created_at','updated_at'];
}
