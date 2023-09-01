<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileTranskrip extends Model
{
    use HasFactory;
    protected $table = 'file_transkrip';
    protected $fillable = ['id','id_pegawai','nama_file_trans_id','nomor_transkrip','file','created_at','updated_at'];
}
