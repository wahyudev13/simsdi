<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileIjazah extends Model
{
    use HasFactory;
    protected $table = 'file_ijazah';
    protected $fillable = ['id','id_pegawai','nama_file_id','nomor','asal','thn_lulus','file','created_at','updated_at'];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class,'id_pegawai','id');
    }
}
