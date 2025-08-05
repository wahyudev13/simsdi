<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class VerifIjazah extends Model
{
    use HasFactory, LogsActivity;
    
    protected $table = "verif_ijazah";
    protected $fillable = ['id','ijazah_id','file','keterangan','created_at','updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['ijazah_id', 'file', 'keterangan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Bukti Verifikasi Ijazah {$eventName}")
            ->useLogName('verifikasi_ijazah');
    }

    public function ijazah()
    {
        return $this->belongsTo(FileIjazah::class, 'ijazah_id', 'id');
    }
}
