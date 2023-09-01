<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $guard = "admin";
    protected $table = "admin";
    protected $fillable = 
    [
        'id',
        'username',
        'password',
        'created_at',
        'updated-at'
    ];
}
