<?php

namespace App\Http\Controllers;

use App\Models\FileRiwayatKerja;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\setAplikasi;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Auth;
use App\Helpers\ActivityLogHelper;
// Tambahkan jika ada helper log aktivitas, misal: use App\Helpers\ActivityLogHelper;

class FileRiwayatKerjaController extends Controller
{
    // Hapus function index, create, dan show
    
    public function getRiwayat(Request $request)
    {
        $auth = auth('admin')->check() ? $request->id : (Auth::user()->id_pegawai ?? $request->id);
        $get_riwayat_kerja = FileRiwayatKerja::where('file_riwayat_pekerjaan.id_pegawai', $auth)
            ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
            ->select('file_riwayat_pekerjaan.id','file_riwayat_pekerjaan.id_pegawai','file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.file','master_berkas_pegawai.nama_berkas',
                'file_riwayat_pekerjaan.tgl_ed','file_riwayat_pekerjaan.updated_at','file_riwayat_pekerjaan.status')
            ->orderBy('file_riwayat_pekerjaan.created_at','desc')
            ->get();
        return DataTables::of($get_riwayat_kerja)
            ->editColumn('updated_at',function($get_riwayat_kerja) {
                return $get_riwayat_kerja->updated_at->format('j F Y h:i:s A');
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function edit(Request $request)
    {
        $riwayat = FileRiwayatKerja::where('id', $request->id)->first();
        if ($riwayat) {
            return response()->json([
                'message' => 'Data Riwayat Pekerjaan Ditemukan',
                'code' => 200,
                'data' => $riwayat
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_riwayat_id' => 'required',
            'nomor' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_riwayat_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }

        $riwayat = FileRiwayatKerja::where('id', $request->id)->first();
        if ($request->hasFile('file')) {
            File::delete('File/Pegawai/Dokumen/RiwayatKerja/'.$riwayat->file);
            $pegawai = Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            $nomorBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->nomor);
            $masterBerkas = MasterBerkas::find($request->nama_file_riwayat_id);
            $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $extension = $request->file('file')->getClientOriginalExtension();
            $currentDate = date('Ymd');
            $hash = substr(md5($filenameWithExt . time()), 0, 6);
            $filenameSimpan = 'RIWAYAT_' . $namaBerkas . '_' . $nomorBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
            $request->file('file')->move(public_path('File/Pegawai/Dokumen/RiwayatKerja'), $filenameSimpan);
            $date = Carbon::today()->toDateString();
            $status = $this->getStatusByTglEd($request->tgl_ed);
           
            $upload = FileRiwayatKerja::where('id',$request->id)->update([
                'id_pegawai' => $request->id_pegawai,
                'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                'nomor' => $request->nomor,
                'tgl_ed' => $request->tgl_ed,
                'status' => $status,
                'file' => $filenameSimpan
            ]);
            ActivityLogHelper::logCrud('updated', $riwayat, 'Mengubah data Riwayat Kerja: ' . $riwayat->nomor, [
                'nama_file' => $filenameSimpan,
                'id_pegawai' => $request->id_pegawai,
                'nomor' => $request->nomor,
                'file_diubah' => true
            ]);
        } else {
            // Jika tidak ada file baru, tetap update nama file jika ada perubahan data
            $fileriwayat = FileRiwayatKerja::where('id', $request->id)->first();
            $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            $nomorBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->nomor);
            $masterBerkas = MasterBerkas::find($request->nama_file_riwayat_id);
            $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
            $currentDate = date('Ymd');
            $hash = substr(md5($fileriwayat->file . time()), 0, 6);
            $newFilename = 'RIWAYAT_' . $namaBerkas . '_' . $nomorBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . pathinfo($fileriwayat->file, PATHINFO_EXTENSION);
            // Rename file lama ke nama baru setiap kali update
            $oldPath = public_path('File/Pegawai/Dokumen/RiwayatKerja/' . $fileriwayat->file);
            $newPath = public_path('File/Pegawai/Dokumen/RiwayatKerja/' . $newFilename);
            if (file_exists($oldPath)) {
                rename($oldPath, $newPath);
                $filenameSimpan = $newFilename;
            } else {
                $filenameSimpan = $fileriwayat->file;
            }
            $date = Carbon::today()->toDateString();
            $status = $this->getStatusByTglEd($request->tgl_ed);
            $upload = FileRiwayatKerja::where('id',$request->id)->update([
                'id_pegawai' => $request->id_pegawai,
                'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                'nomor' => $request->nomor,
                'tgl_ed' => $request->tgl_ed,
                'status' => $status,
                'file' => $filenameSimpan // update nama file di database
            ]);
            ActivityLogHelper::logCrud('updated', $riwayat, 'Mengubah data Riwayat Kerja: ' . $riwayat->nomor, [
                'id_pegawai' => $request->id_pegawai,
                'nomor' => $request->nomor,
                'file_diubah' => false
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Dokumen Riwayat Pekerjaan Berhasil Diubah',
            'data' => $upload
        ]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_riwayat_id' => 'required',
            'nomor' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_riwayat_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Wajib diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }

        if ($request->hasFile('file')) {
            $pegawai = Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            $nomorBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->nomor);
            $masterBerkas = MasterBerkas::find($request->nama_file_riwayat_id);
            $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $extension = $request->file('file')->getClientOriginalExtension();
            $currentDate = date('Ymd');
            $hash = substr(md5($filenameWithExt . time()), 0, 6);
            $filenameSimpan = 'RIWAYAT_' . $namaBerkas . '_' . $nomorBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
            $request->file('file')->move(public_path('File/Pegawai/Dokumen/RiwayatKerja'), $filenameSimpan);

            $date = Carbon::today()->toDateString();
            $status = $this->getStatusByTglEd($request->tgl_ed);
            $upload = FileRiwayatKerja::create([
                'id_pegawai' => $request->id_pegawai,
                'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                'nomor' => $request->nomor,
                'tgl_ed' => $request->tgl_ed,
                'status' => $status,
                'file' => $filenameSimpan
            ]);
            ActivityLogHelper::logCrud('created', $upload, 'Membuat data Riwayat Kerja baru: ' . $upload->nomor, [
                'nama_file' => $filenameSimpan,
                'id_pegawai' => $request->id_pegawai,
                'nomor' => $request->nomor
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen Riwayat Pekerjaan Berhasil Disimpan',
                'data' => $upload
            ]);
        }
    }

  
    public function destroy(Request $request)
    {
        $delete_riwayat = FileRiwayatKerja::where('id', $request->id)->first();
        $delete = FileRiwayatKerja::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/RiwayatKerja/'.$delete_riwayat->file);
            ActivityLogHelper::log('Menghapus data Riwayat Kerja: ' . ($delete_riwayat->nomor ?? ''), [
                'id_riwayat' => $delete_riwayat->id ?? null,
                'nama_file' => $delete_riwayat->file ?? null,
                'id_pegawai' => $delete_riwayat->id_pegawai ?? null,
                'nomor' => $delete_riwayat->nomor ?? null
            ]);
            return response()->json([
                'message' => 'Data Riwayat Kerja Berhasil Dihapus',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function updatestatus(Request $request) {
        $upload = FileRiwayatKerja::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        if ($upload) {
            ActivityLogHelper::log('Status dokumen Riwayat Kerja ' . ($request->naber ?? '') . ' berhasil diubah', [
                'id_riwayat' => $request->id,
                'status_baru' => $request->status,
                'aksi' => 'perubahan_status'
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Status Dokumen '.$request->naber.' Berhasil Diubah',
                'data' => $upload
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal mengubah status dokumen',
            ]);
        }
    }

    public function viewPdf($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan
        if (!preg_match('/^[A-Za-z0-9._-]+\.pdf$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        $path = public_path('File/Pegawai/Dokumen/RiwayatKerja/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /**
     * Fungsi untuk menentukan status dokumen berdasarkan tgl_ed dan tanggal hari ini
     */
    private function getStatusByTglEd($tgl_ed)
    {
        $date = \Carbon\Carbon::today()->toDateString();
        if (is_null($tgl_ed)) {
            return 'active';
        } elseif ($tgl_ed <= $date) {
            return 'nonactive';
        } else {
            return 'active';
        }
    }
}
