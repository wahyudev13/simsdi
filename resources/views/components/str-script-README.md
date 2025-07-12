# STR Script Component

This is a reusable STR (Surat Tanda Register) script component that can be used across different pages in the application.

## Usage

Include the component in your Blade template:

```php
@include('components.str-script', [
    'config' => [
        'tableId' => 'tbSTR',
        'getRoute' => 'berkas.getSTR',
        'storeRoute' => 'berkas.str.store',
        'editRoute' => 'berkas.str.edit',
        'updateRoute' => 'berkas.str.update',
        'destroyRoute' => 'berkas.str.destroy',
        'statusRoute' => 'berkas.str.status',
        'verifStoreRoute' => 'verif.str.store',
        'verifDestroyRoute' => 'verif.str.destroy',
        'enableStatusControl' => true,
        'enablePaging' => false,
        'enableSearch' => false,
        'enableInfo' => false,
        'serverSide' => true,
        'idPegawai' => 'idpegawai',
        'showActions' => true,
        'permissions' => [
            'view' => auth()->user()->can('user-str-view'),
            'edit' => auth()->user()->can('user-str-edit'),
            'delete' => auth()->user()->can('user-str-delete')
        ]
    ]
])
```

## Configuration Options

### Required Options
- `tableId`: The ID of the DataTable element
- `getRoute`: Route name for fetching STR data
- `storeRoute`: Route name for storing new STR
- `editRoute`: Route name for editing STR
- `updateRoute`: Route name for updating STR
- `destroyRoute`: Route name for deleting STR
- `verifStoreRoute`: Route name for storing verification proof
- `verifDestroyRoute`: Route name for deleting verification proof

### Optional Options
- `statusRoute`: Route name for updating STR status (default: null)
- `enableStatusControl`: Enable status control dropdown (default: true)
- `enablePaging`: Enable DataTable paging (default: false)
- `enableSearch`: Enable DataTable search (default: false)
- `enableInfo`: Show DataTable info (default: false)
- `serverSide`: Enable server-side processing (default: true)
- `idPegawai`: ID of employee (default: 'idpegawai')
- `showActions`: Show action buttons (default: true)
- `permissions`: Array of permission checks for actions

## Features

### 1. DataTable Management
- Configurable paging, searching, and info display
- Server-side processing support
- Automatic table reload after operations

### 2. CRUD Operations
- Create new STR documents
- View STR documents (PDF viewer)
- Edit existing STR documents
- Delete STR documents
- Status management (active, proses, nonactive, changed, lifetime)

### 3. Verification System
- Upload verification proof
- View verification proof
- Delete verification proof

### 4. Utility Functions
- Centralized message display
- Form reset functionality
- AJAX setup management
- Table reload management

### 5. Permission System
- Role-based access control for actions
- Configurable permission checks
- Graceful handling of missing permissions

## Examples

### For Karyawan Page (Admin View)
```php
@include('components.str-script', [
    'config' => [
        'tableId' => 'tbSTR',
        'getRoute' => 'berkas.getSTR',
        'storeRoute' => 'berkas.str.store',
        'editRoute' => 'berkas.str.edit',
        'updateRoute' => 'berkas.str.update',
        'destroyRoute' => 'berkas.str.destroy',
        'statusRoute' => 'berkas.str.status',
        'verifStoreRoute' => 'verif.str.store',
        'verifDestroyRoute' => 'verif.str.destroy',
        'enableStatusControl' => true,
        'enablePaging' => false,
        'enableSearch' => false,
        'enableInfo' => false,
        'serverSide' => true,
        'idPegawai' => 'idpegawai',
        'showActions' => true
    ]
])
```

### For Pengguna Page (User View)
```php
@include('components.str-script', [
    'config' => [
        'tableId' => 'tbSTR',
        'getRoute' => 'pengguna.getSTR',
        'storeRoute' => 'pengguna.str.store',
        'editRoute' => 'pengguna.str.edit',
        'updateRoute' => 'pengguna.str.update',
        'destroyRoute' => 'pengguna.str.destroy',
        'statusRoute' => 'pengguna.str.status',
        'verifStoreRoute' => 'pengguna.verif.str.store',
        'verifDestroyRoute' => 'pengguna.verif.str.destroy',
        'enableStatusControl' => false,
        'enablePaging' => true,
        'enableSearch' => true,
        'enableInfo' => true,
        'serverSide' => true,
        'idPegawai' => null,
        'showActions' => true,
        'permissions' => [
            'view' => auth()->user()->can('user-str-view'),
            'edit' => auth()->user()->can('user-str-edit'),
            'delete' => auth()->user()->can('user-str-delete')
        ]
    ]
])
```

## Dependencies

Make sure the following are included in your page:
- jQuery
- DataTables
- Bootstrap (for modals and styling)
- PDFObject (for PDF viewing)
- FontAwesome (for icons)

## Required HTML Elements

The component expects these HTML elements to exist:
- `#success_message` - For displaying success/error messages
- `#modaladdSTR` - Add STR modal
- `#modaleditSTR` - Edit STR modal
- `#modalSTR` - View STR modal
- `#modal-add-bukti-str` - Add verification modal
- `#modal-verstr` - View verification modal
- `#view-str-modal` - PDF viewer modal
- `#view-verstr-modal` - Verification PDF viewer modal
- `#ket-verif-str` - Verification description element

## Form IDs

The component expects these form IDs:
- `#form-tambah-str` - Add STR form
- `#form-edit-str` - Edit STR form
- `#form-tambah-bukti-str` - Add verification form

## Benefits

1. **Code Reusability**: Single component for multiple pages
2. **Maintainability**: Centralized logic and updates
3. **Consistency**: Uniform behavior across pages
4. **Flexibility**: Configurable options for different use cases
5. **Security**: Built-in permission system
6. **Performance**: Optimized AJAX calls and utility functions 