<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranKesanLab extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "saran_kesan_lab";
    protected $fillable = [
        'no_rawat',
        'tgl_periksa',
        'jam',
        'saran',
        'kesan'
    ];
}
