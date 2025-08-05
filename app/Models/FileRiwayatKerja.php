<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileRiwayatKerja extends Model
{
    use HasFactory;
    protected $table = 'file_riwayat_pekerjaan';
    protected $fillable = ['id','id_pegawai','nama_file_riwayat_id','nomor','file','tgl_ed','status','created_at','updated_at'];
}
