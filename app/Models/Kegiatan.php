<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = "kegiatan";
    protected $fillable = [
        'id',
        'departemen_id',
        'nama',
        'jenis_kegiatans_id',
        'tempat',
        'tanggal',
        'tanggal2',
        'created_at',
        'updated_at'
    ];
}
