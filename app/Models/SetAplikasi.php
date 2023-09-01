<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetAplikasi extends Model
{
    use HasFactory;
    protected $table = "set_aplikasi";
    protected $fillable = ['id','nama_instansi','no_telp','email','alamat','logo','created_at','updated_at'];
}
