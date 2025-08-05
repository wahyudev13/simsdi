<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FileIjazah extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'file_ijazah';
    protected $fillable = ['id','id_pegawai','nama_file_id','nomor','asal','thn_lulus','file','created_at','updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id_pegawai', 'nama_file_id', 'nomor', 'asal', 'thn_lulus', 'file'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Berkas Ijazah {$eventName}")
            ->useLogName('file_ijazah');
    }

    public function pegawai() {
        return $this->belongsTo(Pegawai::class,'id_pegawai','id');
    }
}
