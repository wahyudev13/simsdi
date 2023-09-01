<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifStr extends Model
{
    use HasFactory;
    protected $table = "verif_str";
    protected $fillable = ['id','str_id','file_verif','keterangan','created_at','updated_at'];
}
