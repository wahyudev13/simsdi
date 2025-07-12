# SIP Script Component Usage

This component provides a reusable SIP (Surat Izin Praktik) functionality that can be used across different pages.

## Basic Usage

```php
@include('components.sip-script', [
    'tableId' => 'tbSIP',
    'strRoute' => 'pengguna.str.get',
    'sipRoute' => 'pengguna.getSIP',
    'sipStoreRoute' => 'pengguna.sip.store',
    'sipEditRoute' => 'pengguna.sip.edit',
    'sipUpdateRoute' => 'pengguna.sip.update',
    'sipDestroyRoute' => 'pengguna.sip.destroy',
    'strSelectedRoute' => 'pengguna.str.selected.get',
    'enablePaging' => true,
    'enableSearch' => true,
    'enableInfo' => true,
    'showActions' => true,
    'showStatusActions' => false,
    'modalParent' => '#modaladdSIP',
    'editModalParent' => '#modaleditSIP'
])
```

## Parameters

### Required Parameters
- `tableId`: The ID of the DataTable element (default: 'tbSIP')
- `strRoute`: Route for getting STR data
- `sipRoute`: Route for getting SIP data
- `sipStoreRoute`: Route for storing SIP data
- `sipEditRoute`: Route for editing SIP data
- `sipUpdateRoute`: Route for updating SIP data
- `sipDestroyRoute`: Route for deleting SIP data
- `strSelectedRoute`: Route for getting selected STR data

### Optional Parameters
- `enablePaging`: Enable/disable pagination (default: true)
- `enableSearch`: Enable/disable search functionality (default: true)
- `enableInfo`: Enable/disable table info (default: true)
- `showActions`: Show/hide action buttons (default: true)
- `showStatusActions`: Show/hide status management buttons (default: false)
- `modalParent`: Parent modal for Select2 dropdown (default: '#modaladdSIP')
- `editModalParent`: Parent modal for edit Select2 dropdown (default: '#modaleditSIP')
- `sipExpRoute`: Route for SIP expiration management (optional)
- `sipDesexpRoute`: Route for deleting SIP expiration (optional)
- `sipStatusRoute`: Route for updating SIP status (optional)
- `idpegawai`: ID of the employee (optional, for specific employee data)

## Examples

### For Pengguna Page (page-izin.blade.php)
```php
@include('components.sip-script', [
    'tableId' => 'tbSIP',
    'strRoute' => 'pengguna.str.get',
    'sipRoute' => 'pengguna.getSIP',
    'sipStoreRoute' => 'pengguna.sip.store',
    'sipEditRoute' => 'pengguna.sip.edit',
    'sipUpdateRoute' => 'pengguna.sip.update',
    'sipDestroyRoute' => 'pengguna.sip.destroy',
    'strSelectedRoute' => 'pengguna.str.selected.get',
    'enablePaging' => true,
    'enableSearch' => true,
    'enableInfo' => true,
    'showActions' => true,
    'showStatusActions' => false,
    'modalParent' => '#modaladdSIP',
    'editModalParent' => '#modaleditSIP'
])
```

### For Karyawan Page (sip.blade.php)
```php
@include('components.sip-script', [
    'tableId' => 'tbSIP',
    'strRoute' => 'file.str.get',
    'sipRoute' => 'berkas.getSIP',
    'sipStoreRoute' => 'berkas.sip.store',
    'sipEditRoute' => 'berkas.sip.edit',
    'sipUpdateRoute' => 'berkas.sip.update',
    'sipDestroyRoute' => 'berkas.sip.destroy',
    'strSelectedRoute' => 'selected.str.get',
    'sipExpRoute' => 'berkas.sip.exp',
    'sipDesexpRoute' => 'berkas.sip.desexp',
    'sipStatusRoute' => 'berkas.sip.status',
    'enablePaging' => false,
    'enableSearch' => false,
    'enableInfo' => false,
    'showActions' => true,
    'showStatusActions' => true,
    'modalParent' => '#modaladdSIP',
    'editModalParent' => '#modaleditSIP',
    'idpegawai' => 'idpegawai'
])
```

## Features

1. **DataTable Integration**: Full DataTable functionality with configurable options
2. **Select2 Integration**: Dropdown selection for STR data
3. **CRUD Operations**: Create, Read, Update, Delete SIP documents
4. **File Management**: Upload and view SIP documents
5. **Status Management**: Optional status management for SIP documents
6. **Expiration Management**: Optional expiration date management
7. **Modal Integration**: Works with Bootstrap modals
8. **Permission Support**: Built-in permission checking support

## Requirements

- jQuery
- DataTables
- Select2
- Bootstrap
- PDFObject (for document viewing)
- CSRF token support 