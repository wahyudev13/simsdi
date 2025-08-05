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
- ✅ **Log aktivitas FileIjazah (Berkas Ijazah)**
- ✅ **Log aktivitas VerifIjazah (Bukti Verifikasi Ijazah)**

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

## FileIjazah Activity Logging

### Model Configuration
Model `FileIjazah` telah dikonfigurasi untuk logging otomatis:

```php
class FileIjazah extends Model
{
    use HasFactory, LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id_pegawai', 'nama_file_id', 'nomor', 'asal', 'thn_lulus', 'file'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Berkas Ijazah {$eventName}")
            ->useLogName('file_ijazah');
    }
}
```

### Controller Logging Implementation

#### 1. Akses Halaman
```php
// Log akses halaman berkas kepegawaian
ActivityLogHelper::log(
    'Mengakses halaman berkas kepegawaian',
    [
        'pegawai_id' => $id,
        'pegawai_nama' => $pegawai->nama ?? 'Unknown',
        'pegawai_nik' => $pegawai->nik ?? 'Unknown',
        'page' => 'berkas-kepegawaian'
    ],
    'file_ijazah'
);
```

#### 2. Pengambilan Data
```php
// Log pengambilan data ijazah
ActivityLogHelper::log(
    'Mengambil data berkas ijazah',
    [
        'pegawai_id' => $auth,
        'total_berkas' => $berkas->count(),
        'action' => 'get_ijazah'
    ],
    'file_ijazah'
);
```

#### 3. Create Operation
```php
// Log berhasil upload berkas ijazah
ActivityLogHelper::log(
    'Berhasil menambahkan berkas ijazah baru',
    [
        'pegawai_id' => $request->id_pegawai,
        'nama_file_id' => $request->nama_file_id,
        'nomor_ijazah' => $request->nomor,
        'asal' => $request->asal,
        'tahun_lulus' => $request->thn_lulus,
        'file_name' => $filenameSimpan,
        'file_size' => $request->file('file')->getSize(),
        'action' => 'create_ijazah'
    ],
    'file_ijazah'
);
```

#### 4. Update Operation
```php
// Log update berkas ijazah dengan file baru
ActivityLogHelper::log(
    'Berhasil mengubah berkas ijazah dengan file baru',
    [
        'ijazah_id' => $request->id,
        'pegawai_id' => $request->id_pegawai,
        'old_file' => $oldData->file ?? 'unknown',
        'new_file' => $filenameSimpan,
        'old_nomor' => $oldData->nomor ?? 'unknown',
        'new_nomor' => $request->nomor,
        'old_asal' => $oldData->asal ?? 'unknown',
        'new_asal' => $request->asal,
        'old_thn_lulus' => $oldData->thn_lulus ?? 'unknown',
        'new_thn_lulus' => $request->thn_lulus,
        'file_size' => $request->file('file')->getSize(),
        'action' => 'update_ijazah_with_file'
    ],
    'file_ijazah'
);
```

#### 5. Delete Operation
```php
// Log hapus berkas ijazah dengan bukti verifikasi
ActivityLogHelper::log(
    'Berhasil menghapus berkas ijazah dan bukti verifikasi',
    [
        'ijazah_id' => $request->id,
        'pegawai_id' => $dokumen->id_pegawai ?? 'unknown',
        'nomor_ijazah' => $dokumen->nomor ?? 'unknown',
        'asal' => $dokumen->asal ?? 'unknown',
        'file_deleted' => $dokumen->file ?? 'unknown',
        'verifikasi_id' => $dokumenbukti->id ?? 'unknown',
        'verifikasi_file_deleted' => $dokumenbukti->file ?? 'unknown',
        'verifikasi_exists' => true,
        'action' => 'delete_ijazah_with_verifikasi'
    ],
    'file_ijazah'
);
```

#### 6. Error Logging
```php
// Log validasi gagal
ActivityLogHelper::log(
    'Validasi gagal saat menambahkan berkas ijazah',
    [
        'pegawai_id' => $request->id_pegawai ?? 'unknown',
        'errors' => $validated->messages(),
        'action' => 'validation_failed'
    ],
    'file_ijazah'
);
```

### VerifIjazah Activity Logging Implementation

#### 1. Create Operation
```php
// Log berhasil upload bukti verifikasi ijazah
ActivityLogHelper::log(
    'Berhasil menambahkan bukti verifikasi ijazah',
    [
        'ijazah_id' => $request->ijazah_id,
        'pegawai_id' => $ijazah->id_pegawai,
        'file_name' => $filenameSimpan, // Format: VERIF_IJAZAH_ijazahId_nip_tanggal_hash.pdf
        'original_filename' => $filenameWithExt,
        'file_size' => $fileSize,
        'file_size_formatted' => $fileSizeFormatted,
        'keterangan' => $request->ket_bukti,
        'action' => 'create_verifikasi_ijazah'
    ],
    'verifikasi_ijazah'
);
```

#### 2. Delete Operation
```php
// Log hapus bukti verifikasi ijazah
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
```

#### 3. Validation Failed
```php
// Log validasi gagal
ActivityLogHelper::log(
    'Validasi gagal saat menambahkan bukti verifikasi ijazah',
    [
        'ijazah_id' => $request->ijazah_id ?? 'unknown',
        'errors' => $validated->messages(),
        'action' => 'validation_failed_verifikasi_ijazah'
    ],
    'verifikasi_ijazah'
);
```

### Logged Activities for FileIjazah

| Activity | Description | Properties Logged |
|----------|-------------|-------------------|
| `index` | Akses halaman berkas kepegawaian | pegawai_id, pegawai_nama, pegawai_nik, page |
| `getIjazah` | Mengambil data berkas ijazah | pegawai_id, total_berkas, action |
| `store` | Menambah berkas ijazah baru | pegawai_id, nama_file_id, nomor_ijazah, asal, tahun_lulus, file_name, file_size, action |
| `edit` | Mengakses form edit | ijazah_id, pegawai_id, nomor_ijazah, action |
| `update` | Mengubah berkas ijazah | ijazah_id, pegawai_id, old/new values, file_size, action |
| `destroy` | Menghapus berkas ijazah | ijazah_id, pegawai_id, file_deleted, verifikasi_exists, action |
| Validation Failed | Validasi gagal | pegawai_id, errors, action |
| Error | Error saat operasi | error details, action |

### Logged Activities for VerifIjazah

| Activity | Description | Properties Logged |
|----------|-------------|-------------------|
| `store` | Menambah bukti verifikasi ijazah | ijazah_id, pegawai_id, file_name (VERIF_IJAZAH_ijazahId_nip_tanggal_hash.pdf), original_filename, file_size, file_size_formatted, keterangan, action |
| `destroy` | Menghapus bukti verifikasi ijazah | verifikasi_id, ijazah_id, file_deleted, keterangan, action |
| Validation Failed | Validasi gagal saat upload | ijazah_id, errors, action |
| Error | Error saat operasi | verifikasi_id, error, action |

### Filtering FileIjazah Logs

Untuk melihat log aktivitas khusus FileIjazah:

```php
// Di ActivityLogController atau view
$fileIjazahLogs = Activity::where('log_name', 'file_ijazah')
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

### Filtering VerifIjazah Logs

Untuk melihat log aktivitas khusus VerifIjazah:

```php
// Di ActivityLogController atau view
$verifIjazahLogs = Activity::where('log_name', 'verifikasi_ijazah')
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

### Security Considerations

1. **File Information**: Log hanya menyimpan nama file, bukan path lengkap
2. **Sensitive Data**: Nomor ijazah dan data pribadi di-log untuk audit trail
3. **Error Handling**: Semua error dan validasi gagal di-log untuk monitoring
4. **User Tracking**: Setiap aktivitas terkait dengan user yang melakukannya

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
- `log_name` - Nama log (user, admin, file_ijazah, dll)
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

## FileHelper Class

### Overview
`FileHelper` adalah class helper yang menyediakan fungsi-fungsi untuk penanganan file yang konsisten di seluruh aplikasi.

### Location
`app/Helpers/FileHelper.php`

### Methods

#### 1. generateIjazahFilename($nomor, $asal, $extension, $pegawaiId = null)
Generate filename untuk berkas ijazah dengan format: `IJAZAH_[NOMOR]_[NIP]_[TANGGAL]_[HASH].[EXTENSION]`

```php
$filename = FileHelper::generateIjazahFilename('123456789', 'Universitas Indonesia', 'pdf', 1);
// Result: IJAZAH_123456789_123456789012345_20241201_a1b2c3.pdf
```

#### 2. generateSTRFilename($nomor, $asal, $extension, $pegawaiId = null)
Generate filename untuk berkas STR dengan format: `STR_[NOMOR]_[NIP]_[TANGGAL]_[HASH].[EXTENSION]`

```php
$filename = FileHelper::generateSTRFilename('STR123456', 'Konsil Kedokteran', 'pdf', 1);
// Result: STR_STR123456_123456789012345_20241201_a1b2c3.pdf
```

#### 3. generateSIPFilename($nomor, $asal, $extension, $pegawaiId = null)
Generate filename untuk berkas SIP dengan format: `SIP_[NOMOR]_[NIP]_[TANGGAL]_[HASH].[EXTENSION]`

```php
$filename = FileHelper::generateSIPFilename('SIP123456', 'Dinas Kesehatan', 'pdf', 1);
// Result: SIP_SIP123456_123456789012345_20241201_a1b2c3.pdf
```

#### 4. generateFilename($prefix, $identifier, $description, $extension, $pegawaiId = null)
Generate filename umum dengan format: `[PREFIX]_[IDENTIFIER]_[NIP]_[TANGGAL]_[HASH].[EXTENSION]`

```php
$filename = FileHelper::generateFilename('KTP', '123456789', 'Dokumen_Identitas', 'jpg', 1);
// Result: KTP_123456789_123456789012345_20241201_a1b2c3.jpg
```

#### 5. generateFilenameWithNIP($prefix, $nomor, $pegawaiId, $originalName, $extension)
Generate filename dengan format yang sama seperti FileSTRController: `[PREFIX]_[NOMOR]_[NIP]_[TANGGAL]_[HASH].[EXTENSION]`

```php
$filename = FileHelper::generateFilenameWithNIP('IJAZAH', '123456789', 1, 'document.pdf', 'pdf');
// Result: IJAZAH_123456789_123456789012345_20241201_a1b2c3.pdf
```

#### 6. formatFileSize($bytes)
Format ukuran file ke format yang mudah dibaca (KB, MB, GB)

```php
$size = FileHelper::formatFileSize(1048576); // 1MB in bytes
// Result: "1.00 MB"

$size = FileHelper::formatFileSize(2048); // 2KB in bytes
// Result: "2.00 KB"
```

#### 7. validateFileExtension($filename, $allowedExtensions)
Validasi ekstensi file

```php
$isValid = FileHelper::validateFileExtension('document.pdf', ['pdf', 'doc', 'docx']);
// Result: true

$isValid = FileHelper::validateFileExtension('image.jpg', ['pdf']);
// Result: false
```

#### 8. getFileExtension($filename)
Mendapatkan ekstensi file

```php
$extension = FileHelper::getFileExtension('document.pdf');
// Result: "pdf"
```

#### 9. getFileNameWithoutExtension($filename)
Mendapatkan nama file tanpa ekstensi

```php
$name = FileHelper::getFileNameWithoutExtension('document.pdf');
// Result: "document"
```

#### 10. cleanFilename($filename)
Membersihkan nama file dari karakter berbahaya

```php
$cleanName = FileHelper::cleanFilename('file name with spaces & symbols!.pdf');
// Result: "file_name_with_spaces_symbols.pdf"
```

### Usage Examples

#### Di Controller
```php
use App\Helpers\FileHelper;

// Generate filename untuk ijazah dengan format yang sama seperti FileSTRController
$filename = FileHelper::generateFilenameWithNIP('IJAZAH', $request->nomor, $request->id_pegawai, $request->file('file')->getClientOriginalName(), 'pdf');

// Generate filename untuk ijazah dengan format lama (jika diperlukan)
$filename = FileHelper::generateIjazahFilename($request->nomor, $request->asal, 'pdf', $request->id_pegawai);

// Format file size untuk logging
$fileSize = FileHelper::formatFileSize($request->file('file')->getSize());

// Validate file extension
if (!FileHelper::validateFileExtension($request->file('file')->getClientOriginalName(), ['pdf'])) {
    return response()->json(['error' => 'Invalid file type'], 400);
}
```

#### Di View
```php
<!-- Display formatted file size -->
<span>File Size: {{ \App\Helpers\FileHelper::formatFileSize($file->size) }}</span>

<!-- Display file extension -->
<span>Type: {{ \App\Helpers\FileHelper::getFileExtension($file->name) }}</span>
```

### Security Features

1. **Character Sanitization**: Menghapus karakter berbahaya dari nama file
2. **Extension Validation**: Memvalidasi ekstensi file yang diizinkan
3. **Unique Naming**: Menggunakan timestamp untuk memastikan nama file unik
4. **Consistent Format**: Format nama file yang konsisten dan mudah dikenali

### Best Practices

1. **Always Use Helper**: Gunakan FileHelper untuk semua operasi file naming
2. **Validate Extensions**: Selalu validasi ekstensi file sebelum upload
3. **Clean Filenames**: Bersihkan nama file dari karakter berbahaya
4. **Consistent Format**: Gunakan format yang konsisten untuk setiap jenis dokumen
5. **Log File Operations**: Log semua operasi file untuk audit trail

### Integration with Activity Log

FileHelper terintegrasi dengan sistem activity log untuk mencatat:
- Nama file yang diupload
- Ukuran file yang diformat
- Ekstensi file
- Operasi file (create, update, delete)

```php
// Example logging with FileHelper
ActivityLogHelper::log(
    'File uploaded successfully',
    [
        'file_name' => FileHelper::generateIjazahFilename($nomor, $asal, $extension, $pegawaiId),
        'file_size' => $request->file('file')->getSize(),
        'file_size_formatted' => FileHelper::formatFileSize($request->file('file')->getSize()),
        'file_extension' => FileHelper::getFileExtension($request->file('file')->getClientOriginalName())
    ],
    'file_ijazah'
);
``` 