# Modal Components Documentation

This directory contains reusable modal components that can be used across all blade files in the application.

## Available Components

### 1. Modal Bukti Verifikasi STR (`modal-bukti-str.blade.php`)

A specific modal component for adding STR verification proof.

**Usage:**
```php
@include('components.modal-bukti-str')
```

**Features:**
- File upload for PDF verification documents
- Optional description field
- Form validation
- Bootstrap modal styling

### 2. Generic Modal Bukti Verifikasi (`modal-bukti-verifikasi.blade.php`)

A flexible modal component that can be used for different types of verification with customizable parameters.

**Usage:**
```php
@include('components.modal-bukti-verifikasi', [
    'type' => 'str',
    'title' => 'STR',
    'id_field' => 'str_id'
])
```

**Parameters:**
- `type` (string): The type of verification (e.g., 'str', 'ijazah', 'sip')
- `title` (string): The title to display in the modal header
- `id_field` (string): The name of the hidden input field for the document ID

**Examples:**

For STR verification:
```php
@include('components.modal-bukti-verifikasi', [
    'type' => 'str',
    'title' => 'STR',
    'id_field' => 'str_id'
])
```

For Ijazah verification:
```php
@include('components.modal-bukti-verifikasi', [
    'type' => 'ijazah',
    'title' => 'Ijazah',
    'id_field' => 'ijazah_id'
])
```

For SIP verification:
```php
@include('components.modal-bukti-verifikasi', [
    'type' => 'sip',
    'title' => 'SIP',
    'id_field' => 'sip_id'
])
```

## Benefits

1. **Reusability**: Use the same modal across multiple pages
2. **Maintainability**: Update the modal in one place
3. **Consistency**: Ensure consistent UI/UX across the application
4. **Flexibility**: The generic component allows customization for different use cases

## JavaScript Integration

When using these components, make sure to include the necessary JavaScript for form handling and modal functionality. The modal IDs and form IDs are automatically generated based on the component parameters.

## Styling

The components use Bootstrap classes and are compatible with the existing application styling. No additional CSS is required. 