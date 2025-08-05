# Dokumentasi Implementasi Loading State

## Overview
Sistem ini telah ditambahkan loading indicator untuk memberikan feedback visual kepada pengguna saat aplikasi sedang memproses data.

## Fitur Loading State yang Ditambahkan

### 1. **Loading Button untuk Form Submission**
- Button "Simpan" dan "Update" akan berubah menjadi loading state saat form disubmit
- Menampilkan spinner dan teks "Menyimpan..." atau "Mengupdate..."
- Button akan disabled selama proses berlangsung

### 2. **Loading State untuk Edit Button**
- Button "Edit" akan menampilkan loading saat mengambil data
- Menampilkan spinner dan teks "Loading..."
- Button akan disabled selama proses berlangsung

### 3. **Loading State untuk Delete Operation**
- Menampilkan pesan "Menghapus data..." saat proses delete
- Button delete akan disabled selama proses berlangsung

### 4. **Loading State untuk DataTable**
- Menampilkan spinner dan teks "Memuat data..." saat DataTable sedang memuat data
- Menggunakan konfigurasi DataTable processing

### 5. **Form Disabled State**
- Semua input form akan disabled selama proses submission
- Menambahkan class `form-disabled` untuk visual feedback

## Struktur HTML Loading Button

### Modal Tambah Transkrip
```html
<button type="submit" class="btn btn-primary" id="add_transkrip">Simpan</button>
<button type="button" class="btn btn-primary d-none" id="add_transkrip_loading" disabled>
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="ml-2">Menyimpan...</span>
</button>
```

### Modal Edit Transkrip
```html
<button type="submit" class="btn btn-primary" id="update_trans">Update</button>
<button type="button" class="btn btn-primary d-none" id="update_trans_loading" disabled>
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="ml-2">Mengupdate...</span>
</button>
```

## JavaScript Functions

### handleFormSubmission(formElement, url, options)
Menangani form submission dengan loading state:
- Menampilkan loading button
- Disable semua input form
- Clear validation errors
- Handle success/error responses
- Re-enable form setelah selesai

### handleDelete(url, data, callback)
Menangani delete operation dengan loading state:
- Menampilkan pesan loading
- Disable delete button
- Handle success/error responses
- Re-enable button setelah selesai

## CSS Styling

### Loading Button Styling
```css
.btn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

.ml-2 {
    margin-left: 0.5rem;
}
```

### Form Disabled State
```css
.form-disabled {
    opacity: 0.6;
    pointer-events: none;
}
```

### Loading Overlay
```css
.loading-overlay {
    position: relative;
}

.loading-overlay::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
```

## DataTable Loading Configuration

### Ijazah DataTable
```javascript
const ijazahTable = $('#tb-ijazah').DataTable({
    processing: true,
    language: {
        processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
    },
    // ... other config
});
```

### Transkrip DataTable
```javascript
const transkripTable = $('#tb-transkrip').DataTable({
    processing: true,
    language: {
        processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
    },
    // ... other config
});
```

## Event Handlers

### Form Submission Loading
```javascript
$('#form-tambah-trans').on('submit', function(e) {
    e.preventDefault();
    handleFormSubmission(this, "{{ route('berkas.transkrip.store') }}", {
        successCallback: () => {
            $('#modal-add-trans').modal('hide');
            transkripTable.ajax.reload();
        },
        loadingSelectors: {
            show: '#add_transkrip',
            hide: '#add_transkrip_loading'
        },
        errorContainer: '#error_list_trans'
    });
});
```

### Edit Button Loading
```javascript
$(document).on('click', '#edit_trans', function(e) {
    e.preventDefault();
    const $button = $(this);
    
    // Show loading state on button
    $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    
    // ... ajax call
});
```

### Delete Operation Loading
```javascript
function handleDelete(url, data, callback) {
    // Show loading message
    showWarning('Menghapus data...');
    
    $.ajax({
        // ... ajax config
        beforeSend: function() {
            $('[data-id="' + data.id + '"]').prop('disabled', true);
        },
        complete: function() {
            $('[data-id="' + data.id + '"]').prop('disabled', false);
        }
    });
}
```

## Error Handling

### Network Error
```javascript
error: function(xhr, status, error) {
    showError('Terjadi kesalahan pada server. Silakan coba lagi.');
    console.error('Ajax error:', error);
}
```

### Server Error
```javascript
error: function(xhr, status, error) {
    showError('Gagal mengambil data. Silakan coba lagi.');
    console.error('Edit error:', error);
}
```

## User Experience Improvements

### 1. **Visual Feedback**
- Loading spinner yang jelas
- Teks loading yang informatif
- Disabled state untuk mencegah multiple submission

### 2. **Error Recovery**
- Form akan re-enabled jika terjadi error
- Button akan kembali ke state normal
- Pesan error yang jelas

### 3. **Consistent Behavior**
- Semua form submission menggunakan pattern yang sama
- Semua delete operation menggunakan pattern yang sama
- Semua edit operation menggunakan pattern yang sama

## Testing Scenarios

### 1. **Form Submission Loading**
1. Buka modal tambah/edit transkrip
2. Isi form dan klik submit
3. Pastikan button berubah menjadi loading state
4. Pastikan form inputs disabled
5. Pastikan loading state hilang setelah response

### 2. **Edit Button Loading**
1. Klik button edit pada DataTable
2. Pastikan button menampilkan loading spinner
3. Pastikan button disabled
4. Pastikan modal muncul setelah data loaded
5. Pastikan button kembali normal

### 3. **Delete Operation Loading**
1. Klik button delete pada DataTable
2. Konfirmasi delete
3. Pastikan pesan "Menghapus data..." muncul
4. Pastikan button delete disabled
5. Pastikan DataTable reload setelah selesai

### 4. **DataTable Loading**
1. Refresh halaman
2. Pastikan DataTable menampilkan loading spinner
3. Pastikan data muncul setelah loading selesai

### 5. **Error Handling**
1. Simulasi network error
2. Pastikan form re-enabled
3. Pastikan button kembali normal
4. Pastikan pesan error ditampilkan

## Best Practices

### 1. **Always Show Loading State**
- Setiap operasi yang membutuhkan waktu harus menampilkan loading
- Gunakan spinner yang konsisten
- Berikan teks yang informatif

### 2. **Disable Interactive Elements**
- Disable button dan form inputs selama loading
- Mencegah multiple submission
- Berikan visual feedback yang jelas

### 3. **Handle Errors Gracefully**
- Re-enable form jika terjadi error
- Tampilkan pesan error yang jelas
- Log error untuk debugging

### 4. **Consistent UX**
- Gunakan pattern yang sama untuk semua operasi
- Konsisten dalam styling dan behavior
- Berikan feedback yang predictable 