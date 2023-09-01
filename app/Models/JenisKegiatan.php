<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatan extends Model
{
    use HasFactory;
    protected $table = 'jenis_kegiatan';
    protected $fillable = ['id','nama','keterangan','created_at','updated_at'];
}
