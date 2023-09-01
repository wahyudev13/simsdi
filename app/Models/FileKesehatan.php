<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileKesehatan extends Model
{
    use HasFactory;
    protected $table = 'file_kesehatan';
    protected $fillable = ['id','id_pegawai','nama_file_kesehatan_id','nama_pemeriksaan','tgl_pemeriksaan','file','created_at','updated_at'];
}
