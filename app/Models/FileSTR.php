<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class FileSTR extends Model
{
    use HasFactory;

   

    protected $table = 'file_str';
    protected $fillable = ['id','id_pegawai','nama_file_str_id','no_reg_str','kompetensi','file','tgl_ed','pengingat','status','created_at','updated_at'];
}