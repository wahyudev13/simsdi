# Laravel Activity Log Implementation

## Overview
Implementasi fitur Activity Log menggunakan package Spatie Laravel Activitylog untuk mencatat semua aktivitas pengguna dalam sistem.

## Features
- ✅ Log aktivitas login/logout
- ✅ Log aktivitas CRUD (Create, Read, Update, Delete)
- ✅ Log aktivitas gagal login
- ✅ Filter dan pencarian log aktivitas
- ✅ Export log ke CSV
- ✅ Hapus log lama otomatis
- ✅ Detail view untuk setiap aktivitas
- ✅ Middleware untuk keamanan akses

## Installation & Setup

### 1. Install Package
```bash
composer require spatie/laravel-activitylog:^4.10
```

### 2. Publish Files
```bash
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
```

### 3. Run Migration
```bash
php artisan migrate
```

## Configuration

### Model Setup
Tambahkan trait `LogsActivity` ke model yang ingin di-log:

```php
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['username', 'id_pegawai'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}")
            ->useLogName('user');
    }
}
```

## Usage

### 1. Basic Logging
```php
use App\Helpers\ActivityLogHelper;

// Log aktivitas sederhana
ActivityLogHelper::log('User accessed dashboard');

// Log dengan properties tambahan
ActivityLogHelper::log('File uploaded', [
    'file_name' => 'document.pdf',
    'file_size' => '2.5MB'
]);
```

### 2. Login/Logout Logging
```php
// Log successful login
ActivityLogHelper::logLogin($user, 'user'); // atau 'admin'

// Log failed login
ActivityLogHelper::logFailedLogin($username, 'user');

// Log logout
ActivityLogHelper::logLogout($user, 'user');
```

### 3. CRUD Operations
```php
// Log create
ActivityLogHelper::logCrud('created', $model, 'Created new user: ' . $user->name);

// Log update
ActivityLogHelper::logCrud('updated', $model, 'Updated user profile');

// Log delete
ActivityLogHelper::logCrud('deleted', $model, 'Deleted user account');
```

### 4. Batch Logging
```php
// Start batch
ActivityLogHelper::startBatch('user_import');

// Log multiple activities
ActivityLogHelper::logInBatch('Imported user 1');
ActivityLogHelper::logInBatch('Imported user 2');

// End batch
ActivityLogHelper::endBatch();
```

## Routes

### Activity Log Management
- `GET /activity-log` - Daftar semua aktivitas
- `GET /activity-log/{id}` - Detail aktivitas
- `POST /activity-log/clear` - Hapus log lama
- `GET /activity-log/export` - Export ke CSV

### Access Control
Semua route activity log dilindungi dengan middleware `activity.log` yang memastikan hanya user dengan permission "Pegawai Admin" yang bisa mengakses.

## Database Tables

### activity_log
- `id` - Primary key
- `log_name` - Nama log (user, admin, dll)
- `description` - Deskripsi aktivitas
- `subject_type` - Model yang di-log
- `subject_id` - ID model
- `causer_type` - Model user yang melakukan aktivitas
- `causer_id` - ID user
- `properties` - JSON properties tambahan
- `event` - Event type (created, updated, deleted, dll)
- `batch_uuid` - UUID untuk batch logging
- `created_at` - Timestamp

## Helper Functions

### ActivityLogHelper Class

#### Methods:
- `log($description, $properties = [], $logName = null)` - Log aktivitas dasar
- `logLogin($user, $userType = 'user')` - Log login berhasil
- `logFailedLogin($username, $userType = 'user')` - Log login gagal
- `logLogout($user, $userType = 'user')` - Log logout
- `logCrud($action, $model, $description = null, $properties = [])` - Log operasi CRUD
- `startBatch($name)` - Mulai batch logging
- `endBatch()` - Akhiri batch logging
- `logInBatch($description, $properties = [], $logName = null)` - Log dalam batch

## View Files

### 1. activity-log.blade.php
Halaman utama untuk menampilkan daftar aktivitas dengan fitur:
- Filter berdasarkan log name, event, tanggal
- Pagination
- Export CSV
- Clear old logs

### 2. activity-log-detail.blade.php
Halaman detail untuk menampilkan informasi lengkap aktivitas:
- Informasi dasar aktivitas
- Properties tambahan
- Perubahan data (untuk event updated)

## Security

### Middleware
- `ActivityLogAccess` - Memastikan hanya admin yang bisa mengakses
- Menggunakan permission "Pegawai Admin"

### Data Protection
- Password tidak di-log
- Sensitive data dapat difilter melalui konfigurasi model

## Configuration File

File konfigurasi: `config/activitylog.php`

### Key Settings:
- `activity_model` - Model untuk activity log
- `table_name` - Nama tabel activity log
- `default_log_name` - Default log name
- `subject_types` - Model yang dapat di-log
- `causer_types` - Model user yang dapat melakukan aktivitas

## Best Practices

### 1. Model Configuration
```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly(['name', 'email']) // Hanya log field tertentu
        ->logOnlyDirty() // Hanya log perubahan
        ->dontSubmitEmptyLogs() // Jangan log jika tidak ada perubahan
        ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}")
        ->useLogName('user');
}
```

### 2. Sensitive Data
Jangan log data sensitif seperti password, token, dll.

### 3. Performance
- Gunakan batch logging untuk operasi bulk
- Regular cleanup old logs
- Index database columns yang sering di-query

### 4. Monitoring
- Monitor ukuran tabel activity_log
- Set up alerts untuk failed login attempts
- Regular backup activity logs

## Troubleshooting

### Common Issues:

1. **Migration Error**
   ```bash
   php artisan migrate:rollback
   php artisan migrate
   ```

2. **Permission Denied**
   - Pastikan user memiliki permission "Pegawai Admin"
   - Check middleware configuration

3. **Large Log Table**
   - Use clear logs feature
   - Set up scheduled cleanup

4. **Performance Issues**
   - Add database indexes
   - Use pagination
   - Implement log rotation

## Maintenance

### Cleanup Old Logs
```php
// Via controller
ActivityLogHelper::clearLogs(30); // Clear logs older than 30 days

// Via command (create custom command)
php artisan activity:cleanup --days=30
```

### Backup Strategy
- Regular backup of activity_log table
- Export important logs to external storage
- Archive old logs

## Support

Untuk bantuan lebih lanjut:
1. Check Spatie Laravel Activitylog documentation
2. Review Laravel logs
3. Check database connection
4. Verify permissions and middleware 