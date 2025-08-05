<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\MasterBerkas;
use App\Models\MasaBerlakuSIP;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Auth;
use App\Helpers\ActivityLogHelper;


class FileSIPController extends Controller
{
   
    public function getSIP(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        
        $getsip = FileSIP::where('file_sip.id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_sip.nama_file_sip_id', '=', 'master_berkas_pegawai.id')
        ->join('file_str','file_sip.no_reg','=','file_str.id')
        ->leftjoin('masa_berlaku_sip','file_sip.id','=','masa_berlaku_sip.sip_id')
        ->select('file_sip.id','file_sip.id_pegawai','file_sip.no_sip','file_sip.file','master_berkas_pegawai.nama_berkas',
        'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_sip.updated_at','masa_berlaku_sip.id AS id_masa_berlaku',
        'masa_berlaku_sip.tgl_ed AS tgl_ed_sip','masa_berlaku_sip.status AS status_sip')
        ->orderBy('file_sip.created_at','desc')
        ->get();

        return DataTables::of($getsip)
        ->editColumn('updated_at',function($getsip) {
            return $getsip->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_sip_id' => 'required',
            'no_sip' => 'required',
            'no_reg' => 'required',
            // 'tgl_ed_str' => 'required',
            // 'bikes' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_sip_id.required' => 'Nama File Wajib diisi',
            'no_sip.required' => 'Nomor SIP Wajib diisi',
            'no_reg.required' => 'Nomor STR Wajib diisi',
            // 'tgl_ed_str.required' => 'Tanggal Berkahir STR Wajib diisi',
            // 'bikes.required' => 'Bidang Kesehatan Wajib diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                // Ambil NIP pegawai dari database
                $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;

                // Bersihkan nomor SIP dari karakter khusus
                $noSipBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->no_sip);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'SIP_' . $noSipBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/SIP'), $filenameSimpan);
    
                $upload = FileSIP::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                    // 'tgl_ed_str' => $request->tgl_ed_str,
                    // 'bikes' => $request->bikes,
                    'file' => $filenameSimpan
                ]);
                // Log aktivitas pembuatan SIP
                ActivityLogHelper::logCrud('created', $upload, 'Membuat data SIP baru: ' . $upload->no_sip, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'no_sip' => $request->no_sip,
                    'no_reg_str' => $request->no_reg
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Disimpan',
                    'data' => $upload
                ]);
            }
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

   
    public function edit(Request $request)
    {
        $sip_edit = FileSIP::where('id', $request->id)->first();
        if ($sip_edit) {
            // Get the associated STR data
            $str_data = null;
            if ($sip_edit->no_reg) {
                $str_data = \App\Models\FileSTR::where('id', $sip_edit->no_reg)->first();
            }
            
            return response()->json([
                'message' => 'Data SIP Ditemukan',
                'code' => 200,
                'data' => $sip_edit,
                'str_data' => $str_data
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
        $validated = Validator::make($request->all(),[
            'nama_file_sip_id' => 'required',
            'no_sip' => 'required',
            'no_reg' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_sip_id.required' => 'Nama File Wajib diisi',
            'no_sip.required' => 'Nomor SIP Wajib diisi',
            'no_reg.required' => 'Nomor STR Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $sip = FileSIP::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/SIP/'.$sip->file);

                // Ambil NIP pegawai dari database
                $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;

                // Bersihkan nomor SIP dari karakter khusus
                $noSipBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->no_sip);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'SIP_' . $noSipBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/SIP'), $filenameSimpan);
    
                $upload = FileSIP::where('id', $request->id)->update([
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                    'file' => $filenameSimpan // pastikan nama file di database ikut berubah
                ]);
                // Log aktivitas update SIP (dengan file baru)
                ActivityLogHelper::logCrud('updated', $sip, 'Mengubah data SIP: ' . $sip->no_sip, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $sip->id_pegawai,
                    'no_sip' => $request->no_sip,
                    'no_reg_str' => $request->no_reg,
                    'file_diubah' => true
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                // Jika tidak ada file baru, tetap update nama file jika ada perubahan data
                $sip = FileSIP::where('id', $request->id)->first();
                $pegawai = \App\Models\Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $noSipBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->no_sip);
                $currentDate = date('Ymd');
                $hash = substr(md5($sip->file . time()), 0, 6);
                $newFilename = 'SIP_' . $noSipBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . pathinfo($sip->file, PATHINFO_EXTENSION);
                // Rename file lama ke nama baru setiap kali update
                $oldPath = public_path('File/Pegawai/Dokumen/SIP/' . $sip->file);
                $newPath = public_path('File/Pegawai/Dokumen/SIP/' . $newFilename);
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                    $filenameSimpan = $newFilename;
                } else {
                    $filenameSimpan = $sip->file;
                }
                $upload = FileSIP::where('id', $request->id)->update([
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                    'file' => $filenameSimpan // update nama file di database
                ]);
                // Log aktivitas update SIP (tanpa file baru)
                $sip = FileSIP::where('id', $request->id)->first();
                ActivityLogHelper::logCrud('updated', $sip, 'Mengubah data SIP: ' . $sip->no_sip, [
                    'nama_file' => $sip->file,
                    'id_pegawai' => $sip->id_pegawai,
                    'no_sip' => $request->no_sip,
                    'no_reg_str' => $request->no_reg,
                    'file_diubah' => false
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Diubah',
                    'data' => $upload
                ]);
            }
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $sip = FileSIP::where('id', $request->id)->first();
        $delete = FileSIP::where('id', $request->id)->delete();
        if ($delete) {
            // Log aktivitas hapus SIP
            ActivityLogHelper::log('Menghapus data SIP: ' . $sip->no_sip, [
                'id_sip' => $sip->id,
                'nama_file' => $sip->file,
                'id_pegawai' => $sip->id_pegawai,
                'no_sip' => $sip->no_sip,
                'no_reg_str' => $sip->no_reg
            ]);
            File::delete('File/Pegawai/Dokumen/SIP/'.$sip->file);
            return response()->json([
                'message' => 'Data SIP Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    //getSTR untuk SIP Modal tambah SIP
    public function strget(Request $request) {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $str = FileSTR::where('id_pegawai', $auth)
        ->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'lifetime');
        })
        ->select('file_str.id','file_str.no_reg_str')
        ->get();

        $response = array();
        foreach($str as $item){
            $response[] = array(
                "id"=>$item->id,
                "text"=>$item->no_reg_str
            );
        }

        return response()->json($response); 
    }

    //getSTR untuk SIP Modal edit SIP
    public function str_selected(Request $request)  {
        $nostr = FileSIP::where('id',$request->id)->first();
        
        $str = FileSTR::where('id_pegawai', $nostr->id_pegawai)
        // ->where(function($query){
        //     $query->where('status', 'active');
        //     $query->orWhere('status', 'lifetime');
        // })
        ->select('file_str.id','file_str.no_reg_str')
        ->get();

        $response = array();
        foreach($str as $item){
            $response[] = array(
                "id"=>$item->id,
                "text"=>$item->no_reg_str,
            );
        }

        return response()->json($response); 
    }

    //Masa Berlaku SIP
    public function exp(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'sip_id_masa_berlaku' => 'required|exists:file_sip,id',
            'tgl_ed_sip' => 'required|date',
        ], [
            'sip_id_masa_berlaku.required' => 'SIP wajib dipilih',
            'sip_id_masa_berlaku.exists' => 'SIP tidak ditemukan',
            'tgl_ed_sip.required' => 'Tanggal masa berlaku wajib diisi',
            'tgl_ed_sip.date' => 'Format tanggal tidak valid',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }

        // Cek duplikasi masa berlaku aktif
        $exists = MasaBerlakuSIP::where('sip_id', $request->sip_id_masa_berlaku)
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 400,
                'error' => ['Masa berlaku aktif untuk SIP ini sudah ada.']
            ]);
        }

        // Penentuan status sederhana
        $today = now()->toDateString();
        $status = 'active';
        if ($request->tgl_ed_sip == $today) {
            $status = 'nonactive';
        }elseif ($request->tgl_ed_sip < $today) {
            $status = 'nonactive';
        }
        // Jika ingin lifetime, bisa tambahkan:
        // if (empty($request->tgl_ed_sip)) $status = 'lifetime';

        $masaBerlaku = MasaBerlakuSIP::create([
            'sip_id' => $request->sip_id_masa_berlaku,
            'tgl_ed' => $request->tgl_ed_sip,
            'status' => $status
        ]);

        ActivityLogHelper::logCrud('created', $masaBerlaku, 'Menambah masa berlaku SIP', [
            'sip_id' => $request->sip_id_masa_berlaku,
            'tgl_ed' => $request->tgl_ed_sip,
            'status' => $status
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Masa Berlaku SIP Berhasil Disimpan',
            'data' => $masaBerlaku
        ]);
    }

    //Hapus Masa Berlaku SIP
    public function destroyexp(Request $request) {
        // Get the masa berlaku data before deletion for logging
        $masaBerlaku = MasaBerlakuSIP::where('id', $request->id)->first();
        
        $delete = MasaBerlakuSIP::where('id', $request->id)->delete();
        if ($delete) {
            // Log aktivitas hapus masa berlaku SIP
            if ($masaBerlaku) {
                // Get SIP data for more detailed logging
                $sip = FileSIP::where('id', $masaBerlaku->sip_id)->first();
                $sipNumber = $sip ? $sip->no_sip : 'Unknown SIP';
                
                ActivityLogHelper::log('Menghapus masa berlaku SIP: ' . $sipNumber, [
                    'id_masa_berlaku' => $masaBerlaku->id,
                    'sip_id' => $masaBerlaku->sip_id,
                    'no_sip' => $sipNumber,
                    'tgl_ed' => $masaBerlaku->tgl_ed,
                    'status' => $masaBerlaku->status,
                    'aksi' => 'hapus_masa_berlaku_sip'
                ]);
            }
            
            return response()->json([
                'message' => 'Masa berlaku SIP Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    //Ubah Status Masa Berlaku SIP
    public function status(Request $request) {
        $upload = MasaBerlakuSIP::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        // Update updated_at pada file_sip
        $masaBerlaku = MasaBerlakuSIP::where('id', $request->id)->first();
        if ($masaBerlaku) {
            \App\Models\FileSIP::where('id', $masaBerlaku->sip_id)->update([
                'updated_at' => now()
            ]);
        }

        // Log aktivitas perubahan status masa berlaku SIP
        ActivityLogHelper::log('Status masa berlaku SIP ' . ($request->nosip ?? '') . ' berhasil diubah', [
            'id_masa_berlaku' => $request->id,
            'status_baru' => $request->status,
            'aksi' => 'perubahan_status'
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Status Masa Berlaku SIP '.$request->nosip.' Berhasil Diubah',
            'data' => $upload
        ]);
    }


    public function viewPdf($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan
        if (!preg_match('/^[A-Za-z0-9._-]+\.pdf$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        
        // Validasi file exists
        $path = public_path('File/Pegawai/Dokumen/SIP/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
      
        // Return file PDF
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
