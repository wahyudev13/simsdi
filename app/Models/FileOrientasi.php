<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileOrientasi extends Model
{
    use HasFactory;
    protected $table = 'file_orientasi';
    protected $fillable = ['id','nama_file_id','id_pegawai','nomor','tgl_mulai','tgl_selesai','file','created_at','updated_at'];
}
