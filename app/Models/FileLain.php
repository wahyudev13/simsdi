<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLain extends Model
{
    use HasFactory;
    protected $table = 'file_lain';
    protected $fillable = ['id','id_pegawai','nama_file_id','file','created_at','updated_at'];
}
