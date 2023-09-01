<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenDiklat extends Model
{
    use HasFactory;
    protected $table = 'absensi_diklat';
    protected $fillable = [
        'id',
        'kegiatan_id',
        'id_pegawai',
        'masuk_at',
        'selesai_at',
        'total_waktu',
        'date',
        'poin',
        'created_at',
        'updated_at'
    ];
    
}
