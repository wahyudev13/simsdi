<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileVaksin extends Model
{
    use HasFactory;
    protected $table = 'file_vaksin';
    protected $fillable = ['id','id_pegawai','dosis','jenis_vaksin','tgl_vaksin','tempat_vaksin',
    'file','created_at','updated_at'];
}
