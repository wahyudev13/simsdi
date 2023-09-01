<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeriksaLab extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "detail_periksa_lab";
    protected $fillable = [
        'no_rawat',
        'kd_jenis_prw',
        'tgl_periksa',
        'jam',
        'id_template',
        'nilai',
        'nilai_rujukan',
        'keterangan',
        'bagian_rs',
        'bhp',
        'bagian_perujuk',
        'bagian_dokter',
        'bagian_laborat',
        'kso',
        'menejemen',
        'biaya_item'
    ];
}
