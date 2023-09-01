<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "pasien";
    protected $fillable = ['no_rkm_medis','nm_pasien','no_ktp','jk','tmp_lahir','nm_ibu','alamat','pekerjaan',
    'stts_nikah','tgl_daftar','no_tlp','umur'];
}
