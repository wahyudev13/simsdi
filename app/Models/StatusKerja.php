<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKerja extends Model
{
    use HasFactory;
    protected $table = "stts_kerjas";
    protected $fillable = ['stts','kategori'];
}
