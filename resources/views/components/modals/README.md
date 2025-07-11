# Modal Components

Folder ini berisi semua modal view yang dipisah dari file `modal-view.blade.php` untuk meningkatkan maintainability dan readability.

## Struktur File

### Modal View Components
- `modal-ijazah-view.blade.php` - Modal untuk menampilkan Ijazah PDF
- `modal-transkrip-view.blade.php` - Modal untuk menampilkan Transkrip PDF
- `modal-str-view.blade.php` - Modal untuk menampilkan STR PDF
- `modal-sip-view.blade.php` - Modal untuk menampilkan SIP PDF
- `modal-riwayat-view.blade.php` - Modal untuk menampilkan Riwayat Pekerjaan PDF
- `modal-identitas-view.blade.php` - Modal untuk menampilkan Berkas Identitas PDF
- `modal-orientasi-view.blade.php` - Modal untuk menampilkan Sertifikat Orientasi PDF
- `modal-lainlain-view.blade.php` - Modal untuk menampilkan Berkas Lain-Lain PDF
- `modal-verifikasi-ijazah-view.blade.php` - Modal untuk menampilkan Bukti Verifikasi Ijazah
- `modal-verifikasi-str-view.blade.php` - Modal untuk menampilkan Bukti Verifikasi STR
- `modal-spk-view.blade.php` - Modal untuk menampilkan SPK PDF
- `modal-uraian-view.blade.php` - Modal untuk menampilkan Uraian Tugas PDF

## Cara Penggunaan

### Di file blade utama
```blade
@include('components.modal-view')
```

### Atau include individual modal
```blade
@include('components.modals.modal-ijazah-view')
@include('components.modals.modal-str-view')
// dst.
```

## Keuntungan Struktur Ini

1. **Maintainability** - Setiap modal dalam file terpisah, mudah diubah tanpa mempengaruhi modal lain
2. **Readability** - File lebih kecil dan mudah dibaca
3. **Reusability** - Modal dapat digunakan di file lain dengan mudah
4. **Organization** - Struktur folder yang rapi dan terorganisir

## ID Modal

Setiap modal memiliki ID unik:
- `modalIjazah`
- `modalTranskrip`
- `modalSTR`
- `modalSIP`
- `modalRiwayat`
- `modalLain`
- `modal-orientasi`
- `modal-lainlain`
- `modal-verijazah`
- `modal-verstr`
- `modal-view-spk`
- `modal-view-uraian` 