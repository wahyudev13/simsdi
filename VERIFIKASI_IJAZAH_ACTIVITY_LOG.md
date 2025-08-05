# Log Aktivitas Verifikasi Ijazah

## Overview
Implementasi log aktivitas untuk modul Verifikasi Ijazah menggunakan Spatie Laravel Activitylog untuk mencatat semua aktivitas terkait bukti verifikasi ijazah.

## Features
- ✅ Log upload bukti verifikasi ijazah
- ✅ Log hapus bukti verifikasi ijazah
- ✅ Log validasi gagal
- ✅ Log error saat operasi
- ✅ Tracking file information
- ✅ User activity tracking

## File Naming Convention

### Verifikasi Ijazah File Format
File bukti verifikasi ijazah menggunakan format penamaan yang konsisten:
```
VERIF_IJAZAH_{ijazahId}_{nip}_{tanggal}_{hash}.pdf
```

**Contoh:** `VERIF_IJAZAH_123_123456789012345_20241201_a1b2c3.pdf`

**Komponen:**
- `VERIF_IJAZAH` - Prefix untuk bukti verifikasi ijazah
- `{ijazahId}` - ID ijazah yang diverifikasi
- `{nip}` - NIP pegawai pemilik ijazah
- `{tanggal}` - Tanggal upload dalam format Ymd (YYYYMMDD)
- `{hash}` - Hash 6 karakter untuk keunikan
- `.pdf` - Extension file

### FileHelper Method
```php
FileHelper::generateVerifIjazahFilename($ijazahId, $extension, $pegawaiId)
```

## Model Configuration

### VerifIjazah Model
```php
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
```

## Controller Implementation

### VerifIjazahController
```php
<?php

namespace App\Http\Controllers;

use App\Models\VerifIjazah;
use App\Helpers\ActivityLogHelper;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;

use Illuminate\Http\Request;

class VerifIjazahController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'file.required' => 'File Bukti Verifikasi Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);
        
        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                // Get ijazah data to get pegawai_id
                $ijazah = FileIjazah::find($request->ijazah_id);
                if (!$ijazah) {
                    return response()->json([
                        'status' => 400,
                        'error' => ['ijazah_id' => ['Data ijazah tidak ditemukan']]
                    ]);
                }

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = FileHelper::generateVerifIjazahFilename($request->ijazah_id, $extension, $ijazah->id_pegawai);
                
                // Move file to destination
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Ijazah/Verifikasi'), $filenameSimpan);
    
                $upload = VerifIjazah::create([
                    'ijazah_id' => $request->ijazah_id,
                    'file' => $filenameSimpan,
                    'keterangan' => $request->ket_bukti
                ]);

                // Get file size safely
                $fileSize = 0;
                $fileSizeFormatted = '0 bytes';
                try {
                    if ($request->file('file')->isValid()) {
                        $fileSize = $request->file('file')->getSize();
                        $fileSizeFormatted = FileHelper::formatFileSize($fileSize);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with upload
                    \Log::warning('Failed to get file size: ' . $e->getMessage());
                }

                // Log aktivitas berhasil upload bukti verifikasi
                ActivityLogHelper::log(
                    'Berhasil menambahkan bukti verifikasi ijazah',
                    [
                        'ijazah_id' => $request->ijazah_id,
                        'pegawai_id' => $ijazah->id_pegawai,
                        'file_name' => $filenameSimpan,
                        'original_filename' => $filenameWithExt,
                        'file_size' => $fileSize,
                        'file_size_formatted' => $fileSizeFormatted,
                        'keterangan' => $request->ket_bukti,
                        'action' => 'create_verifikasi_ijazah'
                    ],
                    'verifikasi_ijazah'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Bukti Verifikasi Berhasil Disimpan',
                    'data' => $upload
                ]);
            }
           
        }else {
            // Log aktivitas validasi gagal
            ActivityLogHelper::log(
                'Validasi gagal saat menambahkan bukti verifikasi ijazah',
                [
                    'ijazah_id' => $request->ijazah_id ?? 'unknown',
                    'errors' => $validated->messages(),
                    'action' => 'validation_failed_verifikasi_ijazah'
                ],
                'verifikasi_ijazah'
            );

            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $dokumen = VerifIjazah::where('id', $request->id)->first();
    
        $delete = VerifIjazah::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Ijazah/Verifikasi/'.$dokumen->file);
            
            // Log aktivitas berhasil hapus bukti verifikasi
            ActivityLogHelper::log(
                'Berhasil menghapus bukti verifikasi ijazah',
                [
                    'verifikasi_id' => $request->id,
                    'ijazah_id' => $dokumen->ijazah_id ?? 'unknown',
                    'file_deleted' => $dokumen->file ?? 'unknown',
                    'keterangan' => $dokumen->keterangan ?? 'unknown',
                    'action' => 'delete_verifikasi_ijazah'
                ],
                'verifikasi_ijazah'
            );

            return response()->json([
                'message' => 'Data Bukti Verifikasi Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            // Log aktivitas error saat hapus
            ActivityLogHelper::log(
                'Error saat menghapus bukti verifikasi ijazah',
                [
                    'verifikasi_id' => $request->id,
                    'error' => 'Database delete operation failed',
                    'action' => 'delete_error_verifikasi_ijazah'
                ],
                'verifikasi_ijazah'
            );

            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }
}
```

## Logged Activities

### 1. Create Operation (Upload Bukti Verifikasi)
**Description:** `Berhasil menambahkan bukti verifikasi ijazah`

**Properties:**
- `ijazah_id` - ID ijazah yang diverifikasi
- `pegawai_id` - ID pegawai pemilik ijazah
- `file_name` - Nama file yang disimpan (format: VERIF_IJAZAH_ijazahId_nip_tanggal_hash.pdf)
- `original_filename` - Nama file asli
- `file_size` - Ukuran file dalam bytes
- `file_size_formatted` - Ukuran file dalam format yang mudah dibaca (KB, MB, dll)
- `keterangan` - Keterangan bukti verifikasi
- `action` - `create_verifikasi_ijazah`

### 2. Delete Operation (Hapus Bukti Verifikasi)
**Description:** `Berhasil menghapus bukti verifikasi ijazah`

**Properties:**
- `verifikasi_id` - ID bukti verifikasi yang dihapus
- `ijazah_id` - ID ijazah terkait
- `file_deleted` - Nama file yang dihapus
- `keterangan` - Keterangan bukti verifikasi
- `action` - `delete_verifikasi_ijazah`

### 3. Validation Failed
**Description:** `Validasi gagal saat menambahkan bukti verifikasi ijazah`

**Properties:**
- `ijazah_id` - ID ijazah (jika tersedia)
- `errors` - Pesan error validasi
- `action` - `validation_failed_verifikasi_ijazah`

### 4. Error Operation
**Description:** `Error saat menghapus bukti verifikasi ijazah`

**Properties:**
- `verifikasi_id` - ID bukti verifikasi
- `error` - Detail error
- `action` - `delete_error_verifikasi_ijazah`

## Database Schema

### verif_ijazah Table
```sql
CREATE TABLE verif_ijazah (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    ijazah_id BIGINT NOT NULL,
    file VARCHAR(255) NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (ijazah_id) REFERENCES file_ijazah(id)
);
```

### activity_log Table (Relevant Fields)
```sql
CREATE TABLE activity_log (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    log_name VARCHAR(255) NULL,
    description TEXT NOT NULL,
    subject_type VARCHAR(255) NULL,
    subject_id BIGINT NULL,
    causer_type VARCHAR(255) NULL,
    causer_id BIGINT NULL,
    properties JSON NULL,
    event VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Query Examples

### Get All Verifikasi Ijazah Activities
```php
use Spatie\Activitylog\Models\Activity;

$verifIjazahLogs = Activity::where('log_name', 'verifikasi_ijazah')
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

### Get Today's Verifikasi Ijazah Activities
```php
$todayLogs = Activity::where('log_name', 'verifikasi_ijazah')
    ->whereDate('created_at', today())
    ->get();
```

### Get Verifikasi Ijazah Uploads
```php
$uploads = Activity::where('log_name', 'verifikasi_ijazah')
    ->where('description', 'like', '%menambahkan%')
    ->get();
```

### Get Verifikasi Ijazah Deletes
```php
$deletes = Activity::where('log_name', 'verifikasi_ijazah')
    ->where('description', 'like', '%menghapus%')
    ->get();
```

### Get Activities for Specific Ijazah
```php
$ijazahActivities = Activity::where('log_name', 'verifikasi_ijazah')
    ->whereJsonContains('properties->ijazah_id', $ijazahId)
    ->get();
```

## Statistics

### ActivityLogController Stats
```php
$stats = [
    'verifikasi_ijazah_activities' => Activity::where('log_name', 'verifikasi_ijazah')
        ->whereDate('created_at', $today->toDateString())->count(),
    'verifikasi_ijazah_uploads' => Activity::where('log_name', 'verifikasi_ijazah')
        ->where('description', 'like', '%menambahkan%')
        ->whereDate('created_at', $today->toDateString())->count(),
    'verifikasi_ijazah_deletes' => Activity::where('log_name', 'verifikasi_ijazah')
        ->where('description', 'like', '%menghapus%')
        ->whereDate('created_at', $today->toDateString())->count(),
];
```

## Security Considerations

### 1. File Information
- Log hanya menyimpan nama file, bukan path lengkap
- File size di-log untuk monitoring
- Original filename di-log untuk audit trail

### 2. Data Protection
- ID ijazah di-log untuk tracking
- Keterangan di-log untuk konteks
- Tidak ada data sensitif yang di-log

### 3. Error Handling
- Semua error dan validasi gagal di-log
- Error details disimpan untuk debugging
- Failed operations tetap di-track

### 4. User Tracking
- Setiap aktivitas terkait dengan user yang melakukannya
- IP address dan user agent di-log
- Timestamp yang akurat

## Monitoring

### Dashboard Widgets
- Total verifikasi ijazah activities hari ini
- Upload vs delete ratio
- Failed validations count
- Recent activities timeline

### Alerts
- Multiple failed validations
- Large file uploads
- Unusual delete patterns
- System errors

## Best Practices

### 1. File Handling
- Validate file type and size before upload
- Generate unique filenames
- Clean up files when records are deleted
- Log file operations for audit

### 2. Error Logging
- Log all validation errors
- Log system errors with context
- Include user information in error logs
- Use consistent error messages

### 3. Performance
- Use pagination for large log datasets
- Index database columns properly
- Regular cleanup of old logs
- Monitor log table size

### 4. Security
- Validate all inputs
- Sanitize file names
- Check file permissions
- Monitor for suspicious activities

## Troubleshooting

### Common Issues

1. **File Upload Fails**
   - Check file permissions
   - Verify upload directory exists
   - Check file size limits
   - Validate file type

2. **Log Not Created**
   - Check ActivityLogHelper import
   - Verify log_name parameter
   - Check database connection
   - Review error logs

3. **Performance Issues**
   - Add database indexes
   - Use pagination
   - Implement log rotation
   - Monitor query performance

### Debug Commands
```bash
# Check activity log table
php artisan tinker
>>> Spatie\Activitylog\Models\Activity::where('log_name', 'verifikasi_ijazah')->count()

# Check recent activities
>>> Spatie\Activitylog\Models\Activity::where('log_name', 'verifikasi_ijazah')->latest()->take(5)->get()
```

## Maintenance

### Cleanup Old Logs
```php
// Clear logs older than 30 days
Activity::where('log_name', 'verifikasi_ijazah')
    ->where('created_at', '<', now()->subDays(30))
    ->delete();
```

### Backup Strategy
- Regular backup of activity_log table
- Export important logs to external storage
- Archive old logs for compliance

## Integration

### With FileIjazah Module
- Verifikasi ijazah terkait dengan file ijazah
- Cross-reference activities between modules
- Combined reporting capabilities

### With User Management
- Track user activities across modules
- Permission-based access control
- User activity history

### With Notification System
- Alert on failed validations
- Notify on successful uploads
- Report on system errors 