<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileIdentitas extends Model
{
    use HasFactory;
    protected $table = 'file_identitas';
    protected $fillable = ['id','id_pegawai','nama_file_lain_id','file','created_at','updated_at'];
}
