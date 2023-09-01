<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSIP extends Model
{
    use HasFactory;
    protected $table = 'file_sip';
    protected $fillable = ['id','id_pegawai','nama_file_sip_id','no_sip','no_reg','tgl_ed_str','bikes','file','created_at','updated_at'];

}
