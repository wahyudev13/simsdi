<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FileSTR extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'file_str';
    protected $fillable = ['id','id_pegawai','nama_file_str_id','no_reg_str','kompetensi','file','tgl_ed','pengingat','status','created_at','updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['no_reg_str', 'kompetensi', 'file', 'tgl_ed', 'pengingat', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "STR file {$eventName}")
            ->useLogName('filestr');
    }
}