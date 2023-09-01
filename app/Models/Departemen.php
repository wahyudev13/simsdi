<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "departemen";
    protected $fillable = [
        'dep_id',
        'nama'
    ];
}
