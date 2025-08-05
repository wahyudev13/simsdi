# Modal Components Documentation

Direktori ini berisi komponen modal yang dapat digunakan kembali di seluruh file blade dalam aplikasi.

## Komponen yang Tersedia

### 1. Modal Bukti Verifikasi STR (`modal-bukti-str.blade.php`)

Komponen modal khusus untuk menambahkan bukti verifikasi STR.

**Penggunaan:**
```php
@include('components.modal-bukti-str')
```

**Fitur:**
- Upload file untuk dokumen verifikasi PDF
- Field deskripsi opsional
- Validasi form
- Styling modal Bootstrap

### 2. Modal Bukti Verifikasi Generik (`modal-bukti-verifikasi.blade.php`)

Komponen modal fleksibel yang dapat digunakan untuk berbagai jenis verifikasi dengan parameter yang dapat disesuaikan.

**Penggunaan:**
```php
@include('components.modal-bukti-verifikasi', [
    'type' => 'str',
    'title' => 'STR',
    'id_field' => 'str_id'
])
```

**Parameter:**
- `type` (string): Jenis verifikasi (misalnya 'str', 'ijazah', 'sip')
- `title` (string): Judul yang ditampilkan di header modal
- `id_field` (string): Nama field input tersembunyi untuk ID dokumen

### 3. Modal Pendidikan (`modal-pendidikan.blade.php`)

Komponen modal lengkap untuk mengelola dokumen pendidikan (ijazah dan transkrip).

**Penggunaan:**
```php
@include('components.modal-pendidikan')
```

**Fitur:**
- Modal tambah ijazah (ID: `modal-add-ijazah`)
- Modal edit ijazah (ID: `modal-edit-ijazah`)
- Modal view ijazah PDF (ID: `modalIjazah`)
- Modal tambah transkrip (ID: `modal-add-trans`)
- Modal edit transkrip (ID: `modaleditTrans`)
- Modal view transkrip PDF (ID: `modalTranskrip`)

### 4. Modal Ijazah (`modal-ijazah.blade.php`)

Komponen modal khusus untuk mengelola dokumen ijazah.

**Penggunaan:**
```php
@include('components.modal-ijazah')
```

### 5. Modal Transkrip (`modal-transkrip.blade.php`)

Komponen modal khusus untuk mengelola dokumen transkrip.

**Penggunaan:**
```php
@include('components.modal-transkrip')
```

### 6. Modal View PDF (`modal-view-pdf.blade.php`)

Modal generik untuk menampilkan dokumen PDF dengan parameter dinamis.

**Penggunaan:**
```php
@include('components.modal-view-pdf', ['title' => 'Judul Dokumen'])
```

## Contoh Penggunaan

Lihat file `example-usage.blade.php` untuk contoh lengkap penggunaan komponen modal pendidikan.

## Variabel yang Diperlukan

Pastikan variabel berikut tersedia di controller:
- `$pegawai` - Data pegawai
- `$master_berkas_pendidikan` - Daftar master berkas pendidikan

## Manfaat

1. **Dapat Digunakan Kembali**: Gunakan modal yang sama di berbagai halaman
2. **Mudah Dipelihara**: Update modal di satu tempat
3. **Konsistensi**: Memastikan UI/UX yang konsisten di seluruh aplikasi
4. **Fleksibilitas**: Komponen generik memungkinkan kustomisasi untuk berbagai kasus penggunaan

## Integrasi JavaScript

Saat menggunakan komponen ini, pastikan untuk menyertakan JavaScript yang diperlukan untuk penanganan form dan fungsionalitas modal. ID modal dan ID form dihasilkan secara otomatis berdasarkan parameter komponen.

## Styling

Komponen menggunakan kelas Bootstrap dan kompatibel dengan styling aplikasi yang ada. Tidak diperlukan CSS tambahan. 