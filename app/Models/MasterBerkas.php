<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBerkas extends Model
{
    use HasFactory;
    protected $table = "master_berkas_pegawai";
    protected $fillable = ['id','kode','kategori','nama_berkas','created_at','updated_at'];
}
