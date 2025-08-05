<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Generate filename untuk berkas ijazah
     * Format: IJAZAH_nomor_nip_tanggal_hash.extension
     */
    public static function generateIjazahFilename($nomor, $asal, $extension, $pegawaiId = null)
    {
        // Ambil NIP pegawai dari database jika pegawaiId diberikan
        $nip = $pegawaiId;
        if ($pegawaiId) {
            $pegawai = \App\Models\Pegawai::find($pegawaiId);
            $nip = $pegawai ? $pegawai->nik : $pegawaiId;
        }
        
        // Bersihkan nomor ijazah dari karakter khusus
        $cleanNomor = preg_replace('/[^A-Za-z0-9]/', '', $nomor);
        
        // Generate tanggal dalam format Ymd
        $currentDate = date('Ymd');
        
        // Generate hash dari nama asal dan timestamp
        $hash = substr(md5($asal . time()), 0, 6);
        
        return 'IJAZAH_' . $cleanNomor . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
    }

    /**
     * Generate filename untuk berkas STR
     * Format: STR_nomorSTR_nip_tanggal_hash.extension
     */
    public static function generateSTRFilename($nomor, $asal, $extension, $pegawaiId = null)
    {
        // Ambil NIP pegawai dari database jika pegawaiId diberikan
        $nip = $pegawaiId;
        if ($pegawaiId) {
            $pegawai = \App\Models\Pegawai::find($pegawaiId);
            $nip = $pegawai ? $pegawai->nik : $pegawaiId;
        }
        
        // Bersihkan nomor STR dari karakter khusus
        $cleanNomor = preg_replace('/[^A-Za-z0-9]/', '', $nomor);
        
        // Generate tanggal dalam format Ymd
        $currentDate = date('Ymd');
        
        // Generate hash dari nama asal dan timestamp
        $hash = substr(md5($asal . time()), 0, 6);
        
        return 'STR_' . $cleanNomor . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
    }

    /**
     * Generate filename untuk berkas SIP
     * Format: SIP_nomorSIP_nip_tanggal_hash.extension
     */
    public static function generateSIPFilename($nomor, $asal, $extension, $pegawaiId = null)
    {
        // Ambil NIP pegawai dari database jika pegawaiId diberikan
        $nip = $pegawaiId;
        if ($pegawaiId) {
            $pegawai = \App\Models\Pegawai::find($pegawaiId);
            $nip = $pegawai ? $pegawai->nik : $pegawaiId;
        }
        
        // Bersihkan nomor SIP dari karakter khusus
        $cleanNomor = preg_replace('/[^A-Za-z0-9]/', '', $nomor);
        
        // Generate tanggal dalam format Ymd
        $currentDate = date('Ymd');
        
        // Generate hash dari nama asal dan timestamp
        $hash = substr(md5($asal . time()), 0, 6);
        
        return 'SIP_' . $cleanNomor . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
    }

    /**
     * Generate filename untuk berkas umum
     * Format: PREFIX_identifier_nip_tanggal_hash.extension
     */
    public static function generateFilename($prefix, $identifier, $description, $extension, $pegawaiId = null)
    {
        // Ambil NIP pegawai dari database jika pegawaiId diberikan
        $nip = $pegawaiId;
        if ($pegawaiId) {
            $pegawai = \App\Models\Pegawai::find($pegawaiId);
            $nip = $pegawai ? $pegawai->nik : $pegawaiId;
        }
        
        // Bersihkan identifier dari karakter khusus
        $cleanIdentifier = preg_replace('/[^A-Za-z0-9]/', '', $identifier);
        
        // Generate tanggal dalam format Ymd
        $currentDate = date('Ymd');
        
        // Generate hash dari description dan timestamp
        $hash = substr(md5($description . time()), 0, 6);
        
        return strtoupper($prefix) . '_' . $cleanIdentifier . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
    }

    /**
     * Generate filename dengan format yang sama seperti FileSTRController
     * Format: PREFIX_nomor_nip_tanggal_hash.extension
     */
    public static function generateFilenameWithNIP($prefix, $nomor, $pegawaiId, $originalName, $extension)
    {
        // Ambil NIP pegawai dari database
        $pegawai = \App\Models\Pegawai::find($pegawaiId);
        $nip = $pegawai ? $pegawai->nik : $pegawaiId;
        
        // Bersihkan nomor dari karakter khusus
        $cleanNomor = preg_replace('/[^A-Za-z0-9]/', '', $nomor);
        
        // Generate tanggal dalam format Ymd
        $currentDate = date('Ymd');
        
        // Generate hash dari original name dan timestamp
        $hash = substr(md5($originalName . time()), 0, 6);
        
        return strtoupper($prefix) . '_' . $cleanNomor . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
    }

    /**
     * Format file size ke human readable format
     */
    public static function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Validate file extension
     */
    public static function validateFileExtension($filename, $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'])
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowedExtensions);
    }

    /**
     * Get file extension from filename
     */
    public static function getFileExtension($filename)
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Get file name without extension
     */
    public static function getFileNameWithoutExtension($filename)
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    /**
     * Clean filename untuk keamanan
     */
    public static function cleanFilename($filename)
    {
        // Hapus karakter berbahaya
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Hapus multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);
        
        // Trim underscores di awal dan akhir
        $filename = trim($filename, '_');
        
        return $filename;
    }

    /**
     * Get file size safely with error handling
     */
    public static function getFileSizeSafely($file)
    {
        try {
            if ($file && $file->isValid()) {
                return $file->getSize();
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to get file size: ' . $e->getMessage());
        }
        return 0;
    }

    /**
     * Get formatted file size safely
     */
    public static function getFormattedFileSizeSafely($file)
    {
        $size = self::getFileSizeSafely($file);
        return self::formatFileSize($size);
    }

    /**
     * Generate filename untuk bukti verifikasi ijazah
     * Format: VERIF_IJAZAH_ijazahId_nip_tanggal_hash.extension
     */
    public static function generateVerifIjazahFilename($ijazahId, $extension, $pegawaiId = null)
    {
        // Ambil NIP pegawai dari database jika pegawaiId diberikan
        $nip = $pegawaiId;
        if ($pegawaiId) {
            $pegawai = \App\Models\Pegawai::find($pegawaiId);
            $nip = $pegawai ? $pegawai->nik : $pegawaiId;
        }
        
        // Generate tanggal dalam format Ymd
        $currentDate = date('Ymd');
        
        // Generate hash dari ijazahId dan timestamp
        $hash = substr(md5($ijazahId . time()), 0, 6);
        
        return 'VERIF_IJAZAH_' . $ijazahId . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
    }

    /**
     * Validate file upload
     */
    public static function validateFileUpload($file)
    {
        if (!$file) {
            return ['valid' => false, 'message' => 'File tidak ditemukan'];
        }

        if (!$file->isValid()) {
            return ['valid' => false, 'message' => 'File upload gagal atau file tidak valid'];
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian',
                UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
                UPLOAD_ERR_NO_TMP_DIR => 'Tidak ada temporary directory',
                UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension'
            ];
            
            $message = $errorMessages[$file->getError()] ?? 'Error upload file tidak diketahui';
            return ['valid' => false, 'message' => $message];
        }

        return ['valid' => true, 'message' => 'File valid'];
    }
} 