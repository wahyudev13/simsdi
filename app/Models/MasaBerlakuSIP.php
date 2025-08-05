<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasaBerlakuSIP extends Model
{
    use HasFactory;
    protected $table = "masa_berlaku_sip";
    protected $fillable = ['id','sip_id','tgl_ed','status','created_at','updated_at'];
}
