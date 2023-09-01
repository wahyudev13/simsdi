<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSertifPelatihan extends Model
{
    use HasFactory;
    protected $table = 'sertif_pelatihan';
    protected $fillable = [
        'id',
        'id_pegawai',
        'berkas_id',
        'nm_kegiatan',
        'tgl_kegiatan',
        'tmp_kegiatan',
        'penyelenggara',
        'file',
        'created_at',
        'updated_at'
    ];
}
