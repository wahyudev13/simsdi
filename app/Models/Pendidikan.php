<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = "pendidikans";
    protected $fillable = ['id','tingkat','index','gapok1','kenaikan','maksimal','created_at','updated_at'];
}
