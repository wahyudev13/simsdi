# Dokumentasi Validasi Error Modal Bukti Verifikasi Ijazah

## Overview
Modal Tambah Bukti Verifikasi Ijazah telah diperbaiki untuk menampilkan validasi error dengan lebih baik dan konsisten.

## Struktur HTML Modal

### Modal Tambah Bukti Verifikasi Ijazah
```html
<div class="modal fade" id="modal-add-bukti" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Bukti Verifikasi Ijazah</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Error container untuk semua error -->
                <div id="error_list_bukti" class="alert alert-danger d-none">
                    <ul class="mb-0"></ul>
                </div>
                
                <form method="POST" id="form-tambah-bukti" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id-ijazah-bukti" name="ijazah_id">
                    
                    <div class="form-group">
                        <label for="file-bukti" class="col-form-label">
                            File <span class="badge badge-secondary">.pdf</span>
                            <label class="text-danger">*</label>
                        </label>
                        <input type="file" class="form-control" id="file-bukti" name="file">
                        <small>Ukuran maksimal 2MB</small>
                        <!-- Error untuk file bukti -->
                        <div id="error_file-bukti" class="invalid-feedback d-none"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ket-bukti" class="col-form-label">Keterangan</label>
                        <input type="text" class="form-control" id="ket-bukti" name="ket_bukti">
                        <!-- Error untuk keterangan -->
                        <div id="error_ket-bukti" class="invalid-feedback d-none"></div>
                    </div>
                    
                    <p class="text-danger">*Wajib Diisi</p>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add_bukti">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
```

## Validasi yang Didukung

### 1. **Field Wajib**
- `file`: File bukti verifikasi wajib diupload
- `ijazah_id`: ID ijazah wajib ada (hidden field)

### 2. **Format File**
- Hanya file PDF yang diizinkan
- Ukuran maksimal 2MB

### 3. **Pesan Error**
- `file.required`: "File Bukti Verifikasi Wajib diisi"
- `file.mimes`: "Format File yang diizinkan: pdf"
- `file.max`: "File Maksimal 2MB"

## Controller Response Format

### Success Response
```json
{
    "status": 200,
    "message": "Bukti Verifikasi Berhasil Disimpan",
    "data": {
        "id": 1,
        "ijazah_id": 123,
        "file": "verif_ijazah_123_1234567890.pdf",
        "keterangan": "Verifikasi dari universitas"
    }
}
```

### Error Response
```json
{
    "status": 400,
    "error": {
        "file": [
            "File Bukti Verifikasi Wajib diisi"
        ]
    }
}
```

## JavaScript Implementation

### Form Submission Handler
```javascript
$('#form-tambah-bukti').on('submit', function(e) {
    e.preventDefault();
    handleFormSubmission(this, "{{ route('verif.ijazah.store') }}", {
        successCallback: () => {
            $('#modal-add-bukti').modal('hide');
            ijazahTable.ajax.reload();
        },
        errorContainer: '#error_list_bukti'
    });
});
```

### Error Display Function
```javascript
function showErrors(errors, container) {
    const $container = $(container);
    $container.html("").addClass("alert alert-danger").removeClass("d-none");
    
    // Clear all field-specific errors first
    $('.invalid-feedback').addClass('d-none').html('');
    $('.form-control, .custom-select').removeClass('is-invalid error-field');

    // Create ul element if it doesn't exist
    let $ul = $container.find('ul');
    if ($ul.length === 0) {
        $ul = $('<ul class="mb-0"></ul>');
        $container.append($ul);
    }
    $ul.empty();

    $.each(errors, function(key, error_value) {
        // Add to general error list
        $ul.append('<li>' + error_value + '</li>');
        
        // Show field-specific error
        const fieldId = key;
        const $field = $('#' + fieldId);
        const $errorDiv = $('#error_' + fieldId);
        
        if ($field.length > 0 && $errorDiv.length > 0) {
            $field.addClass('is-invalid error-field');
            $errorDiv.removeClass('d-none').html(error_value).addClass('error-message');
        }
    });
}
```

### Auto-clear Error Events
```javascript
// Clear validation errors when user changes file
$(document).on('change', 'input[type="file"]', function() {
    const fieldId = $(this).attr('id');
    if (fieldId) {
        $(this).removeClass('is-invalid error-field');
        $('#error_' + fieldId).addClass('d-none').html('').removeClass('error-message');
    }
});

// Clear validation errors when user types in text input
$(document).on('input', 'input[type="text"]', function() {
    const fieldId = $(this).attr('id');
    if (fieldId) {
        $(this).removeClass('is-invalid error-field');
        $('#error_' + fieldId).addClass('d-none').html('').removeClass('error-message');
    }
});
```

## CSS Styling

### Error Container Styling
```css
.alert-danger {
    border-color: #dc3545;
    background-color: #f8d7da;
    color: #721c24;
}

.alert-danger ul {
    margin-bottom: 0;
    padding-left: 1.5rem;
}

.alert-danger li {
    margin-bottom: 0.25rem;
}
```

### Field Error Styling
```css
.invalid-feedback {
    display: block !important;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-control.is-invalid,
.custom-select.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.error-field {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}
```

## Modal Cleanup

### Modal Hidden Event
```javascript
$('#modal-add-bukti').on('hidden.bs.modal', function() {
    $(this).find('.form-control, .custom-file-input').val("");
    clearValidationErrors();
});
```

### Clear Validation Errors Function
```javascript
function clearValidationErrors() {
    $('.alert-danger').addClass('d-none').find('ul').empty();
    $('.invalid-feedback').addClass('d-none').html('').removeClass('error-message');
    $('.form-control, .custom-select').removeClass('is-invalid error-field');
}
```

## Testing Scenarios

### 1. **Validasi File Wajib**
1. Buka modal Tambah Bukti Verifikasi Ijazah
2. Klik "Simpan" tanpa memilih file
3. Pastikan error "File Bukti Verifikasi Wajib diisi" muncul
4. Pastikan field file mendapat border merah

### 2. **Validasi Format File**
1. Pilih file dengan format selain PDF (misal: .jpg, .docx)
2. Klik "Simpan"
3. Pastikan error "Format File yang diizinkan: pdf" muncul

### 3. **Validasi Ukuran File**
1. Pilih file PDF dengan ukuran lebih dari 2MB
2. Klik "Simpan"
3. Pastikan error "File Maksimal 2MB" muncul

### 4. **Auto-clear Error**
1. Submit form dengan error
2. Pilih file yang benar
3. Pastikan error hilang otomatis
4. Ketik di field keterangan
5. Pastikan error field keterangan hilang

### 5. **Modal Cleanup**
1. Submit form dengan error
2. Tutup modal
3. Buka modal lagi
4. Pastikan semua error hilang
5. Pastikan form kosong

## Error Handling Flow

### 1. **Form Submission**
```javascript
// User submit form
$('#form-tambah-bukti').on('submit', function(e) {
    e.preventDefault();
    // ... handle submission
});
```

### 2. **Server Validation**
```php
// Controller validation
$validated = Validator::make($request->all(),[
    'file' => 'required|mimes:pdf|max:2048',
],[
    'file.required' => 'File Bukti Verifikasi Wajib diisi',
    'file.mimes' => 'Format File yang diizinkan: pdf',
    'file.max' => 'File Maksimal 2MB'
]);
```

### 3. **Error Response**
```json
{
    "status": 400,
    "error": {
        "file": ["File Bukti Verifikasi Wajib diisi"]
    }
}
```

### 4. **Client-side Error Display**
```javascript
// Display errors
if (response.status == 400) {
    showErrors(response.error, '#error_list_bukti');
}
```

### 5. **Auto-clear on User Action**
```javascript
// Clear error when user changes file
$(document).on('change', 'input[type="file"]', function() {
    // ... clear error logic
});
```

## Best Practices

### 1. **Consistent Error Display**
- Gunakan format error yang sama dengan modal lain
- Tampilkan error di container umum dan field spesifik
- Gunakan styling yang konsisten

### 2. **User Experience**
- Auto-clear error saat user mulai memperbaiki
- Modal cleanup yang proper
- Pesan error yang jelas dan informatif

### 3. **Validation Rules**
- Validasi di client dan server
- Pesan error dalam Bahasa Indonesia
- Format file dan ukuran yang jelas

### 4. **Error Recovery**
- Form re-enabled jika terjadi error
- Button kembali normal
- Data tidak hilang jika modal ditutup

## Integration with Existing System

### 1. **DataTable Integration**
- Modal bukti verifikasi terintegrasi dengan DataTable ijazah
- Reload DataTable setelah berhasil simpan
- Update status verifikasi di DataTable

### 2. **Activity Logging**
- Log aktivitas berhasil upload bukti verifikasi
- Log aktivitas validasi gagal
- Log aktivitas hapus bukti verifikasi

### 3. **File Management**
- File disimpan dengan nama yang terstruktur
- Validasi file upload menggunakan FileHelper
- Penghapusan file saat data dihapus 