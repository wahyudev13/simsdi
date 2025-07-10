<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles, LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['username'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Admin {$eventName}")
            ->useLogName('admin');
    }
}
