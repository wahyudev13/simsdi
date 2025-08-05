<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\MasterBerkas;
use App\Models\VerifStr;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Auth;
use App\Helpers\ActivityLogHelper;
class FileSTRController extends Controller
{
    public function getSTR(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
       
        $getstr = FileSTR::where('id_pegawai',$auth)
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->leftjoin('verif_str','file_str.id','=','verif_str.str_id')
        ->select('file_str.id','file_str.no_reg_str','file_str.kompetensi','file_str.file','file_str.tgl_ed',
        'master_berkas_pegawai.nama_berkas','file_str.updated_at','file_str.status','verif_str.id AS id_verif_str',
        'verif_str.file_verif','verif_str.keterangan')
        ->orderBy('file_str.created_at','desc')
        ->get();

        return DataTables::of($getstr)
        ->editColumn('updated_at',function($getstr) {
            return $getstr->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

   
    public function store(Request $request)
    {
        // Check multiple permissions for both web and admin guards
        $user = auth()->user() ?? auth('admin')->user();
        
        if (!$user) {
            return response()->json([
                'status' => 401,
                'error' => ['auth' => ['User tidak terautentikasi']]
            ]);
        }

        // Admin guard bypass permission check (has all access)
        if (auth('admin')->check()) {
            // Admin can access everything
        } else {
            // For web guard, check specific permissions
            if (!$user->hasAnyPermission(['admin-karyawan-dokumen', 'admin-all-access', 'user-str-create'])) {
                return response()->json([
                    'status' => 403,
                    'error' => ['permission' => ['Anda tidak memiliki izin untuk melakukan aksi ini']]
                ]);
            }
        }

        // Base validation rules
        $baseRules = [
            'nama_file_str_id' => 'required',
            'no_reg_str' => 'required',
            'kompetensi' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ];

        // Add date validation if expiration is enabled
        if ($request->enable_exp_str) {
            $baseRules['tgl_ed'] = 'required';
        }

        $validated = Validator::make($request->all(), $baseRules, [
            'nama_file_str_id.required' => 'Nama File Wajib diisi',
            'no_reg_str.required' => 'Nomor reg Wajib diisi',
            'kompetensi.required' => 'Kompetensi Wajib diisi',
            'tgl_ed.required' => 'Tanggal Berkahir Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }

        if (!$request->hasFile('file')) {
            return response()->json([
                'status' => 400,
                'error' => ['file' => ['File tidak ditemukan']]
            ]);
        }

        // Handle file upload
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName(); // Nama file asli
        $extension = $file->getClientOriginalExtension();
        
        // Ambil NIP pegawai dari database
        $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
        $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
        
        // Bersihkan nomor STR dari karakter khusus
        $noRegStr = preg_replace('/[^A-Za-z0-9]/', '', $request->no_reg_str);
        
        // Format nama file baru: STR_nomorSTR_nip_tanggal_hash
        $currentDate = date('Ymd');
        $hash = substr(md5($originalName . time()), 0, 6);
        $filenameSimpan = 'STR_' . $noRegStr . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
        
        $file->move(public_path('File/Pegawai/Dokumen/STR'), $filenameSimpan);

        // Prepare data for database
        $data = [
            'id_pegawai' => $request->id_pegawai,
            'nama_file_str_id' => $request->nama_file_str_id,
            'no_reg_str' => $request->no_reg_str,
            'kompetensi' => $request->kompetensi,
            'file' => $filenameSimpan
        ];

        // Determine status and dates based on expiration setting
        if ($request->enable_exp_str) {
            $today = Carbon::today()->toDateString();
            $tgl_ed = $request->tgl_ed;

            // Determine status based on dates
            if ($tgl_ed == $today) {
                $status = 'nonactive';
            } elseif ($tgl_ed < $today) {
                $status = 'nonactive';
            } else {
                $status = 'active';
            }

            $data['tgl_ed'] = $tgl_ed;
            $data['status'] = $status;
        } else {
            // STR lifetime (no expiration)
            $data['tgl_ed'] = null;
            $data['status'] = 'lifetime';
        }

        // Create record
        $upload = FileSTR::create($data);

        // Log activity
        ActivityLogHelper::logCrud('created', $upload, 'Created new STR file: ' . $upload->no_reg_str, [
            'file_name' => $filenameSimpan,
            'employee_id' => $request->id_pegawai,
            'competency' => $request->kompetensi,
            'expiration_date' => $request->enable_exp_str ? $request->tgl_ed : 'Lifetime',
            'status' => $data['status']
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'STR Berhasil Disimpan',
            'data' => $upload
        ]);
    }

    public function edit(Request $request)
    {
        // Check multiple permissions for both web and admin guards
        $user = auth()->user() ?? auth('admin')->user();
        
        if (!$user) {
            return response()->json([
                'status' => 401,
                'error' => ['auth' => ['User tidak terautentikasi']]
            ]);
        }

        // Admin guard bypass permission check (has all access)
        if (auth('admin')->check()) {
            // Admin can access everything
        } else {
            // For web guard, check specific permissions
            if (!$user->hasAnyPermission(['admin-karyawan-dokumen', 'admin-all-access', 'user-str-edit'])) {
                return response()->json([
                    'status' => 403,
                    'error' => ['permission' => ['Anda tidak memiliki izin untuk melakukan aksi ini']]
                ]);
            }
        }

        $str_edit = FileSTR::where('id', $request->id)->first();
        if ($str_edit) {
            return response()->json([
                'message' => 'Data STR Ditemukan',
                'code' => 200,
                'data' => $str_edit
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function update(Request $request)
    {
       // Check multiple permissions for both web and admin guards
        $user = auth()->user() ?? auth('admin')->user();
        
        if (!$user) {
            return response()->json([
                'status' => 401,
                'error' => ['auth' => ['User tidak terautentikasi']]
            ]);
        }

        // Admin guard bypass permission check (has all access)
        if (auth('admin')->check()) {
            // Admin can access everything
        } else {
            // For web guard, check specific permissions
            if (!$user->hasAnyPermission(['admin-karyawan-dokumen', 'admin-all-access', 'user-str-edit'])) {
                return response()->json([
                    'status' => 403,
                    'error' => ['permission' => ['Anda tidak memiliki izin untuk melakukan aksi ini']]
                ]);
            }
        }

        // Base validation rules
        $baseRules = [
            'nama_file_str_id' => 'required',
            'no_reg_str' => 'required',
            'kompetensi' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ];

        // Add date validation if expiration is enabled
        if ($request->enable_exp_str_edit) {
            $baseRules['tgl_ed'] = 'required';
        }

        $validated = Validator::make($request->all(), $baseRules, [
            'nama_file_str_id.required' => 'Nama File Wajib diisi',
            'no_reg_str.required' => 'Nomor reg Wajib diisi',
            'kompetensi.required' => 'Kompetensi Wajib diisi',
            'tgl_ed.required' => 'Tanggal Berkahir Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }

        // Find the existing record
        $fileSTR = FileSTR::find($request->id);
        if (!$fileSTR) {
            return response()->json([
                'status' => 400,
                'error' => ['id' => ['Record tidak ditemukan']]
            ]);
        }

        // Handle file upload if new file is provided
        $filenameSimpan = $fileSTR->file; // Keep existing file by default
        $originalName = $fileSTR->file; // Keep existing file name by default
        
        if ($request->hasFile('file')) {
            // Delete old file
            File::delete('File/Pegawai/Dokumen/STR/' . $fileSTR->file);

            // Upload new file
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName(); // Nama file asli baru
            $extension = $file->getClientOriginalExtension();
            
            // Ambil NIP pegawai dari database
            $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            
            // Bersihkan nomor STR dari karakter khusus
            $noRegStr = preg_replace('/[^A-Za-z0-9]/', '', $request->no_reg_str);
            
            // Format nama file baru: STR_nomorSTR_nip_tanggal_hash
            $currentDate = date('Ymd');
            $hash = substr(md5($originalName . time()), 0, 6);
            $filenameSimpan = 'STR_' . $noRegStr . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
            
            $file->move(public_path('File/Pegawai/Dokumen/STR'), $filenameSimpan);
        } else {
            // Jika tidak ada file baru, tetap update nama file jika ada perubahan data
            $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            
            // Bersihkan nomor STR dari karakter khusus
            $noRegStr = preg_replace('/[^A-Za-z0-9]/', '', $request->no_reg_str);
            
            // Format nama file baru: STR_nomorSTR_nip_tanggal_hash
            $currentDate = date('Ymd');
            $hash = substr(md5($fileSTR->file . time()), 0, 6);
            $newFilename = 'STR_' . $noRegStr . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . pathinfo($fileSTR->file, PATHINFO_EXTENSION);
            
            // Rename file lama ke nama baru
            if ($fileSTR->file != $newFilename) {
                $oldPath = public_path('File/Pegawai/Dokumen/STR/' . $fileSTR->file);
                $newPath = public_path('File/Pegawai/Dokumen/STR/' . $newFilename);
                
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                    $filenameSimpan = $newFilename;
                }
            }
        }

        // Prepare data for database update
        $data = [
            'id_pegawai' => $request->id_pegawai,
            'nama_file_str_id' => $request->nama_file_str_id,
            'no_reg_str' => $request->no_reg_str,
            'kompetensi' => $request->kompetensi,
            'file' => $filenameSimpan
        ];

        // Determine status and dates based on expiration setting
        if ($request->enable_exp_str_edit) {
            $today = Carbon::today()->toDateString();
            $tgl_ed = $request->tgl_ed;

            // Determine status based on dates
            if ($tgl_ed == $today) {
                $status = 'nonactive';
            } elseif ($tgl_ed < $today) {
                $status = 'nonactive';
            } else {
                $status = 'active';
            }
            
            $data['tgl_ed'] = $tgl_ed;
            $data['status'] = $status;
        } else {
            // STR lifetime (no expiration)
            $data['tgl_ed'] = null;
            $data['status'] = 'lifetime';
        }

        // Update record
        $upload = $fileSTR->update($data);

        // Log activity
        ActivityLogHelper::logCrud('updated', $fileSTR, 'Updated STR file: ' . $fileSTR->no_reg_str, [
            'file_name' => $filenameSimpan,
            'employee_id' => $request->id_pegawai,
            'competency' => $request->kompetensi,
            'expiration_date' => $request->enable_exp_str_edit ? $request->tgl_ed : 'Lifetime',
            'status' => $data['status'],
            'file_changed' => $request->hasFile('file')
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'STR Berhasil Diubah',
            'data' => $upload
        ]);
    }

   
    public function destroy(Request $request)
    {
        $ceksip = FileSIP::where('no_reg', $request->id)->count();
        // $countsip = $ceksip->count();
        
        if ($ceksip > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal Hapus Data, Data Masih digunakan',
            ]);
        }else {
            $str = FileSTR::where('id', $request->id)->first();
            $dokumenbukti = VerifStr::where('str_id', $request->id)->first();
            $delete = FileSTR::where('id', $request->id)->delete();
            if ($delete) {
                // Log activity before file deletion
                ActivityLogHelper::log('Deleted STR file: ' . $str->no_reg_str, [
                    'str_id' => $request->id,
                    'file_name' => $str->file,
                    'employee_id' => $str->id_pegawai,
                    'competency' => $str->kompetensi,
                    'has_verification_doc' => $dokumenbukti ? true : false,
                    'verification_file' => $dokumenbukti ? $dokumenbukti->file_verif : null
                ]);

                if ($dokumenbukti == null) {
                    File::delete('File/Pegawai/Dokumen/STR/'.$str->file);
                    return response()->json([
                        'message' => 'Data STR Berhasil Dihapus',
                        'code' => 200,
                    ]);
                }else {
                    File::delete('File/Pegawai/Dokumen/STR/'.$str->file);
                    File::delete('File/Pegawai/Dokumen/STR/Verifikasi/'.$dokumenbukti->file_verif);
                    return response()->json([
                        'message' => 'Data STR & Bukti Verifikasi Berhasil Dihapus',
                        'code' => 200,
                    ]);
                }
               
            }
        }
        
    }

    public function status(Request $request) {
        // Get the current STR record to log old status
        $str = FileSTR::find($request->id);
        $oldStatus = $str ? $str->status : 'unknown';
        
        $upload = FileSTR::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        // Log activity
        ActivityLogHelper::log('Status Dokumen STR ' . $request->noreg . ' berhasil diubah', [
            'str_id' => $request->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'action' => 'status_change'
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Status Dokumen STR '.$request->noreg.' Berhasil Diubah',
            'data' => $upload
        ]);
    }

    public function viewPdf($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan (alphanumeric, dash, underscore, dot)
        if (!preg_match('/^[A-Za-z0-9._-]+\.pdf$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        $path = public_path('File/Pegawai/Dokumen/STR/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        // Opsi: tambahkan validasi hak akses user di sini
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
