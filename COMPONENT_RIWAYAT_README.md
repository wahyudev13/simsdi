# Komponen Riwayat Script

## Deskripsi
Komponen `riwayat-script.blade.php` adalah komponen Blade yang menyediakan fungsionalitas DataTable dan AJAX untuk mengelola data riwayat kerja. Komponen ini mengikuti pola yang sama dengan `sip-script.blade.php` untuk menjaga konsistensi dalam pengembangan.

## Fitur
- DataTable dengan server-side processing
- CRUD operations (Create, Read, Update, Delete)
- Status management untuk dokumen
- Modal integration
- Event-driven loading untuk tab-based interface
- Configurable options melalui props

## Props yang Tersedia

### Basic Configuration
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `tableId` | string | `'tbRiwayat'` | ID tabel DataTable |
| `modalParent` | string | `'#modaladdRiwayat'` | ID modal untuk tambah data |
| `editModalParent` | string | `'#modaleditRiwayat'` | ID modal untuk edit data |

### Route Configuration
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `riwayatRoute` | string | `'berkas.riwayat.getRiwayat'` | Route untuk mengambil data |
| `riwayatStoreRoute` | string | `'berkas.riwayat.store'` | Route untuk menyimpan data |
| `riwayatEditRoute` | string | `'berkas.riwayat.edit'` | Route untuk mengambil data edit |
| `riwayatUpdateRoute` | string | `'berkas.riwayat.update'` | Route untuk update data |
| `riwayatDestroyRoute` | string | `'berkas.riwayat.destroy'` | Route untuk hapus data |
| `riwayatStatusRoute` | string | `'berkas.riwayat.update.status'` | Route untuk update status |

### DataTable Configuration
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `enablePaging` | boolean | `false` | Aktifkan paging DataTable |
| `enableSearch` | boolean | `false` | Aktifkan pencarian DataTable |
| `enableInfo` | boolean | `false` | Aktifkan info DataTable |

### UI Configuration
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `showActions` | boolean | `true` | Tampilkan kolom aksi |
| `showStatusActions` | boolean | `true` | Tampilkan aksi status |

## Cara Penggunaan

### Basic Usage
```php
@include('components.riwayat-script')
```

### Custom Configuration
```php
@include('components.riwayat-script', [
    'tableId' => 'customTableId',
    'enablePaging' => true,
    'enableSearch' => true,
    'showStatusActions' => false,
    'riwayatRoute' => 'custom.route.get',
    'riwayatStoreRoute' => 'custom.route.store'
])
```

### Minimal Configuration
```php
@include('components.riwayat-script', [
    'tableId' => 'tbRiwayatCustom',
    'enablePaging' => true
])
```

## Struktur HTML yang Diperlukan

### Tabel
```html
<table class="table table-bordered" id="tbRiwayat" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama File</th>
            <th>Nomor</th>
            <th>Masa Berlaku</th>
            <th>Update</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>
```

### Modal Tambah Data
```html
<div class="modal fade" id="modaladdRiwayat" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-tambah-rw">
                <!-- Form fields -->
                <button type="submit" id="add_riwayat">Tambah</button>
                <button type="button" id="add_riwayat_disabled" class="d-none">Loading...</button>
            </form>
        </div>
    </div>
</div>
```

### Modal Edit Data
```html
<div class="modal fade" id="modaleditRiwayat" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-edit-riwayat">
                <!-- Form fields -->
                <button type="submit" id="update_riwayat">Update</button>
                <button type="button" id="update_riwayat_disabled_edit" class="d-none">Loading...</button>
            </form>
        </div>
    </div>
</div>
```

### Modal View Dokumen
```html
<div class="modal fade" id="modalRiwayat" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="view-riwayat-modal"></div>
        </div>
    </div>
</div>
```

## Event Handling

### Tab Loading
Komponen ini menggunakan custom event `loadTabData` untuk memuat data berdasarkan tab yang aktif:

```javascript
document.addEventListener('loadTabData', function(e) {
    if (e.detail.tabId === '#riwayat') {
        // Data akan dimuat otomatis
    }
});
```

### Success Message
Komponen menggunakan elemen dengan ID `#success_message` untuk menampilkan pesan sukses:

```html
<div id="success_message"></div>
```

## Dependencies

### CSS
- Bootstrap CSS
- DataTables Bootstrap 4 CSS
- FontAwesome CSS

### JavaScript
- jQuery
- DataTables
- PDFObject (untuk view dokumen)
- Bootstrap JavaScript

## Error Handling

Komponen ini menangani error dengan menampilkan pesan error dalam elemen dengan ID:
- `#error_list_rw` untuk form tambah
- `#error_list_rw_edit` untuk form edit

## Contoh Response API

### Success Response
```json
{
    "status": 200,
    "message": "Data berhasil disimpan",
    "data": {...}
}
```

### Error Response
```json
{
    "status": 400,
    "error": {
        "field_name": ["Error message"]
    }
}
```

## Migration dari Script Lama

Jika Anda menggunakan script riwayat kerja yang lama, berikut adalah langkah-langkah migrasi:

1. **Ganti include script:**
   ```php
   // Dari
   @include('pages.Karyawan.js.riwayatkerja')
   
   // Ke
   @include('components.riwayat-script')
   ```

2. **Pastikan struktur HTML sesuai** dengan yang dijelaskan di atas

3. **Update route names** jika diperlukan melalui props

4. **Test functionality** untuk memastikan semua fitur berjalan dengan baik

## Troubleshooting

### DataTable tidak muncul
- Pastikan ID tabel sesuai dengan prop `tableId`
- Periksa apakah route `riwayatRoute` mengembalikan data yang benar
- Pastikan jQuery dan DataTables sudah dimuat

### Modal tidak berfungsi
- Pastikan ID modal sesuai dengan props `modalParent` dan `editModalParent`
- Periksa apakah Bootstrap JavaScript sudah dimuat

### AJAX error
- Periksa CSRF token
- Pastikan route yang digunakan sudah terdaftar
- Periksa response dari server

## Contributing

Saat menambahkan fitur baru ke komponen ini:
1. Update dokumentasi props
2. Tambahkan contoh penggunaan
3. Test dengan berbagai konfigurasi
4. Pastikan backward compatibility 