<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifIjazah extends Model
{
    use HasFactory;
    protected $table = "verif_ijazah";
    protected $fillable = ['id','ijazah_id','file','keterangan','created_at','updated_at'];
}
