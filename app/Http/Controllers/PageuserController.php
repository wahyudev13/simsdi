<?php

namespace App\Http\Controllers;

use App\Models\DetailKepegawaian;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\FileRiwayatKerja;
use App\Models\FileKesehatan;
use App\Models\FileVaksin;
use App\Models\FileIdentitas;
use App\Models\PenilaianMCU;
use App\Models\FileSertifPelatihan;
use App\Models\AbsenDiklat;
use App\Models\FileOrientasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use File;
use Auth;


class PageuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function mcu() {
        $auth = Auth::user()->id_pegawai;
        $pengguna = User::where('id_pegawai',$auth)->first();
        $pegawai = Pegawai::where('id', $auth)->first();
        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai
        ];
        return view('pages.Pengguna.page-mcu',$data);
    }
    public function vaksin() {
        $auth = Auth::user()->id_pegawai;

        $pegawai = Pegawai::where('id', $auth)->first();
        $pengguna = User::where('id_pegawai',$auth)->first();

        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai
        ];
        return view('pages.Pengguna.page-vaksin',$data);
    }

    public function kesehatan() {
        $auth = Auth::user()->id_pegawai;

        $pegawai = Pegawai::where('id', $auth)->first();
        $pengguna = User::where('id_pegawai',$auth)->first();
        $berkas_kesehatan = MasterBerkas::where('kategori','kesehatan')->get();

        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai,
            'berkas_kesehatan' => $berkas_kesehatan
        ];
        return view('pages.Pengguna.page-kesehatan',$data);
    }

    public function storekes(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'nama_file' => 'required',
            'nama_pemeriksaan' => 'required',
            'tgl_pemeriksaan' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            'nama_file.required' => 'Nama File Wajib Diisi',
            'nama_pemeriksaan.required' => 'Nama Pemeriksaan Wajib Diisi',
            'tgl_pemeriksaan.required' => 'Tanggal Pemeriksaan Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Kesehatan/'), $filenameSimpan);
    
                $upload = FileKesehatan::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_kesehatan_id' => $request->nama_file,
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Kesehatan ('.$request->nama_pemeriksaan.') Berhasil Disimpan',
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

    public function editkes(Request $request)
    {
        $dokumen = FileKesehatan::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $dokumen
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updatekes(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'nama_file' => 'required',
            'nama_pemeriksaan' => 'required',
            'tgl_pemeriksaan' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            'nama_file.required' => 'Nama File Wajib Diisi',
            'nama_pemeriksaan.required' => 'Nama Pemeriksaan Wajib Diisi',
            'tgl_pemeriksaan.required' => 'Tanggal Pemeriksaan Wajib Diisi',
            // 'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileKesehatan::where('id', $request->id)->first();
                File::delete('File/Pegawai/Kesehatan/Kesehatan/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Kesehatan/'), $filenameSimpan);
    
                $upload = FileKesehatan::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_kesehatan_id' => $request->nama_file,
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Kesehatan ('.$request->nama_pemeriksaan.') Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileKesehatan::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_kesehatan_id' => $request->nama_file,
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                  
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Kesehatan ('.$request->nama_pemeriksaan.') Berhasil Diubah',
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

    public function destroykes(Request $request)
    {
        $delete_file = FileKesehatan::where('id', $request->id)->first();
        $delete = FileKesehatan::where('id', $request->id)->delete();

        if ($delete) {
            File::delete('File/Pegawai/Kesehatan/Kesehatan/'.$delete_file->file);
            return response()->json([
                'message' => 'Data Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function pendidikan() {
        $auth = Auth::user()->id_pegawai;

        $pegawai = Pegawai::where('id', $auth)->first();
        $pengguna = User::where('id_pegawai',$auth)->first();
        $master_berkas_pendidikan = MasterBerkas::where('kategori','pendidikan')->get();

        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai,
            'master_berkas_pendidikan' => $master_berkas_pendidikan
        ];
        return view('pages.Pengguna.page-pendidikan',$data);
    }

    public function getijazah() {
        $auth = Auth::user()->id_pegawai;

        $berkas = FileIjazah::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_ijazah.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->select('file_ijazah.id','master_berkas_pegawai.nama_berkas','file_ijazah.nomor','file_ijazah.asal',
        'file_ijazah.thn_lulus','file_ijazah.file','file_ijazah.updated_at')
        ->get();

        return DataTables::of($berkas)
        ->editColumn('updated_at',function($berkas) {
            return $berkas->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function storeijazah(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_id' => 'required',
            'nomor' => 'required',
            'asal' => 'required',
            'thn_lulus' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Ijazah Wajib diisi',
            'asal.required' => 'Asal Sekolah / Universitas Wajib diisi',
            'thn_lulus.required' => 'Tahun Lulus Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Ijazah'), $filenameSimpan);
    
                $upload = FileIjazah::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_id' => $request->nama_file_id,
                    'nomor' => $request->nomor,
                    'asal' => $request->asal,
                    'thn_lulus' => $request->thn_lulus,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Ijazah Berhasil Disimpan',
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

    public function editijazah(Request $request)
    {
        // /$pegawai = Pegawai::where('id', $id)->first();
        $dokumen = FileIjazah::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $dokumen
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }

    }

    public function updateijazah(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_id' => 'required',
            'nomor' => 'required',
            'asal' => 'required',
            'thn_lulus' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Ijazah Wajib diisi',
            'asal.required' => 'Asal Sekolah / Universitas Wajib diisi',
            'thn_lulus.required' => 'Tahun Lulus Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileIjazah::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Ijazah/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Ijazah'), $filenameSimpan);
    
                $upload = FileIjazah::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_id' => $request->nama_file_id,
                    'nomor' => $request->nomor,
                    'asal' => $request->asal,
                    'thn_lulus' => $request->thn_lulus,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Ijazah Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileIjazah::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_id' => $request->nama_file_id,
                    'nomor' => $request->nomor,
                    'asal' => $request->asal,
                    'thn_lulus' => $request->thn_lulus,
                  
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Ijazah Berhasil Diubah',
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

    public function destroyijazah(Request $request)
    {
        $dokumen = FileIjazah::where('id', $request->id)->first();
      

        $delete = FileIjazah::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Ijazah/'.$dokumen->file);
            return response()->json([
                'message' => 'Data Ijazah Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data, data Masih digunakan',
                'code' => 500,
            ]);
        }
    }

    public function gettrans() {
        $auth = Auth::user()->id_pegawai;

        $gettranskrip = FileTranskrip::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_transkrip.nama_file_trans_id', '=', 'master_berkas_pegawai.id')
        ->select('file_transkrip.id','file_transkrip.nomor_transkrip','file_transkrip.file','master_berkas_pegawai.nama_berkas',
        'file_transkrip.updated_at')
        ->get();
        return DataTables::of($gettranskrip)
        ->editColumn('updated_at',function($gettranskrip) {
            return $gettranskrip->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function storetrans(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_trans_id' => 'required',
            'nomor_transkrip' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_trans_id.required' => 'Nama File Wajib diisi',
            'nomor_transkrip.required' => 'Nomor Transkrip Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Transkrip'), $filenameSimpan);
    
                $upload = FileTranskrip::create([
                    'id_pegawai' => $request->id_pegawai,
                    //'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Disimpan',
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

    public function edittrans(Request $request)
    {
        $trans_edit = FileTranskrip::where('id', $request->id)->first();
        if ($trans_edit) {
            return response()->json([
                'message' => 'Data Transkrip Ditemukan',
                'code' => 200,
                'data' => $trans_edit
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updatetrans(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_trans_id' => 'required',
            'nomor_transkrip' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_trans_id.required' => 'Nama File Wajib diisi',
            'nomor_transkrip.required' => 'Nomor Transkrip Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileTranskrip::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Transkrip/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Transkrip'), $filenameSimpan);
    
                $upload = FileTranskrip::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileTranskrip::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Diubah',
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

    public function destroytrans(Request $request)
    {
        $transkrip = FileTranskrip::where('id', $request->id)->first();
        $delete = FileTranskrip::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Transkrip/'.$transkrip->file);
            return response()->json([
                'message' => 'Data Transkrip Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data, data Masih digunakan',
                'code' => 500,
            ]);
        }
    }


    public function izin() {
        $auth = Auth::user()->id_pegawai;

        $pegawai = Pegawai::where('id', $auth)->first();
        $pengguna = User::where('id_pegawai',$auth)->first();
        $master_berkas_izin = MasterBerkas::where('kategori','ijin')->get();

        $str = FileSTR::where('id_pegawai', $auth)->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })->get();

        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai,
            'master_berkas_izin' => $master_berkas_izin,
            'file_str' => $str
        ];
        return view('pages.Pengguna.page-izin',$data);
    }

    public function json_str(Request $request){
        $auth = Auth::user()->id_pegawai;
        $str = FileSTR::where('id_pegawai', $auth)
        ->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
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

    public function getSTR()
    {
        $auth = Auth::user()->id_pegawai;
        $getstr = FileSTR::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('file_str.id','file_str.no_reg_str','file_str.kompetensi','file_str.file','file_str.tgl_ed',
        'file_str.pengingat','master_berkas_pegawai.nama_berkas','file_str.updated_at','file_str.status')
        ->get();
        return DataTables::of($getstr)
        ->editColumn('updated_at',function($getstr) {
            return $getstr->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function getSIP()
    {
        $auth = Auth::user()->id_pegawai;
        $getsip = FileSIP::where('file_sip.id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_sip.nama_file_sip_id', '=', 'master_berkas_pegawai.id')
        ->join('file_str','file_sip.no_reg','=','file_str.id')
        ->select('file_sip.id','file_sip.id_pegawai','file_sip.no_sip','file_sip.file','master_berkas_pegawai.nama_berkas',
        'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_sip.updated_at')
        ->get();

        return DataTables::of($getsip)
        ->editColumn('updated_at',function($getsip) {
            return $getsip->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function getRiwayat()
    {
        $auth = Auth::user()->id_pegawai;
        $get_riwayat_kerja = FileRiwayatKerja::where('file_riwayat_pekerjaan.id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('file_riwayat_pekerjaan.id','file_riwayat_pekerjaan.id_pegawai','file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.file','master_berkas_pegawai.nama_berkas',
        'file_riwayat_pekerjaan.tgl_ed','file_riwayat_pekerjaan.pengingat','file_riwayat_pekerjaan.updated_at','file_riwayat_pekerjaan.status',
        )
        ->get();

        return DataTables::of($get_riwayat_kerja)
        ->editColumn('updated_at',function($get_riwayat_kerja) {
            return $get_riwayat_kerja->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function getKesehatan()
    {
        $auth = Auth::user()->id_pegawai;
        $getfile = FileKesehatan::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_kesehatan.nama_file_kesehatan_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_kesehatan.id','file_kesehatan.nama_pemeriksaan',
        'file_kesehatan.tgl_pemeriksaan','file_kesehatan.updated_at','file_kesehatan.file')
        ->get();

        return DataTables::of($getfile)
        // ->editColumn('tgl_pemeriksaan',function($getfile) {
        //     return $getfile->tgl_pemeriksaan->format('Y-m-d');
        // })
        ->editColumn('updated_at',function($getfile) {
            return $getfile->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function getVaksin()
    {
        $auth = Auth::user()->id_pegawai;
        $getfile = FileVaksin::where('id_pegawai', $auth)
        // ->join('master_berkas_pegawai', 'file_vaksin.nama_file_kesehatan_id', '=', 'master_berkas_pegawai.id')
        ->select('file_vaksin.id','file_vaksin.dosis','file_vaksin.jenis_vaksin',
        'file_vaksin.tempat_vaksin','file_vaksin.tgl_vaksin','file_vaksin.file')
        ->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }

    public function getMCU() {
         $database = config('database.connections.mysql.database');
        $auth = Auth::user()->id_pegawai;
        $get = PenilaianMCU::where('mapingrm.id_pegawai',$auth)
        ->join('reg_periksa','penilaian_mcu.no_rawat','=','reg_periksa.no_rawat')
        ->join('dokter','penilaian_mcu.kd_dokter','=','dokter.kd_dokter')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->leftjoin( "$database.maping_norm_simrs as mapingrm",'pasien.no_rkm_medis','=','mapingrm.no_rkm_medis')
        // ->select('reg_periksa.no_rkm_medis','mapingrm.id_pegawai')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
    }

    public function getFileId()
    {
        $auth = Auth::user()->id_pegawai;
        $getfile = FileIdentitas::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_identitas.nama_file_lain_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_identitas.id','file_identitas.file')
        ->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }
    public function storestr(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_str_id' => 'required',
            'no_reg_str' => 'required',
            'kompetensi' => 'required',
            'tgl_ed' => 'required',
            'pengingat' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_str_id.required' => 'Nama File Wajib diisi',
            'no_reg_str.required' => 'Nomor reg Wajib diisi',
            'kompetensi.required' => 'Kompetensi Wajib diisi',
            'tgl_ed.required' => 'Tanggal Berkahir Wajib diisi',
            'pengingat.required' => 'Pengingat Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: jpg,png,pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/STR'), $filenameSimpan);

                $date = Carbon::today()->toDateString();

                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileSTR::create([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileSTR::create([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileSTR::create([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileSTR::create([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }
                
                return response()->json([
                    'status' => 200,
                    'message' => 'STR Berhasil Disimpan',
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

    public function editstr(Request $request)
    {
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

    public function updatestr(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_str_id' => 'required',
            'no_reg_str' => 'required',
            'kompetensi' => 'required',
            'tgl_ed' => 'required',
            'pengingat' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_str_id.required' => 'Nama File Wajib diisi',
            'no_reg_str.required' => 'Nomor reg Wajib diisi',
            'kompetensi.required' => 'Kompetensi Wajib diisi',
            'tgl_ed.required' => 'Tanggal Berkahir Wajib diisi',
            'pengingat.required' => 'Pengingat Wajib diisi',
            // 'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileSTR::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/STR/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/STR'), $filenameSimpan);

                $date = Carbon::today()->toDateString();
                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }
                
                return response()->json([
                    'status' => 200,
                    'message' => 'STR Berhasil Diubah',
                    'data' => $upload
                ]);
    
                // $upload = FileSTR::where('id', $request->id)->update([
                //     'id_pegawai' => $request->id_pegawai,
                //     //'nik_pegawai' => $request->nik_pegawai,
                //     'nama_file_str_id' => $request->nama_file_str_id,
                //     'no_reg_str' => $request->no_reg_str,
                //     'kompetensi' => $request->kompetensi,
                //     'tgl_ed' => $request->tgl_ed,
                //     'pengingat' => $request->pengingat,
                //     'file' => $filenameSimpan
                // ]);
                // return response()->json([
                //     'status' => 200,
                //     'message' => 'STR Berhasil Diubah',
                //     'data' => $upload
                // ]);
            }else {
                $date = Carbon::today()->toDateString();
                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload2 = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                       
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload2 = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                     
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload2 = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload2 = FileSTR::where('id', $request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_str_id' => $request->nama_file_str_id,
                        'no_reg_str' => $request->no_reg_str,
                        'kompetensi' => $request->kompetensi,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                      
                    ]);
                }
                
                return response()->json([
                    'status' => 200,
                    'message' => 'STR Berhasil Diubah',
                    'data' => $upload2
                ]);
                // $upload = FileSTR::where('id', $request->id)->update([
                //     'id_pegawai' => $request->id_pegawai,
                //     //'nik_pegawai' => $request->nik_pegawai,
                //     'nama_file_str_id' => $request->nama_file_str_id,
                //     'no_reg_str' => $request->no_reg_str,
                //     'kompetensi' => $request->kompetensi,
                //     'tgl_ed' => $request->tgl_ed,
                //     'pengingat' => $request->pengingat,
                    
                // ]);
                // return response()->json([
                //     'status' => 200,
                //     'message' => 'STR Berhasil Diubah',
                //     'data' => $upload
                // ]);
            }
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function destroystr(Request $request)
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
            $delete = FileSTR::where('id', $request->id)->delete();
            if ($delete) {
                File::delete('File/Pegawai/Dokumen/STR/'.$str->file);
                return response()->json([
                    'message' => 'Data STR Berhasil Dihapus',
                    'code' => 200,
                ]);
            }
        }
        
    }

    public function storesip(Request $request)
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

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
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

    public function editsip(Request $request)
    {
        $sip_edit = FileSIP::where('id', $request->id)->first();
        if ($sip_edit) {
            return response()->json([
                'message' => 'Data SIP Ditemukan',
                'code' => 200,
                'data' => $sip_edit
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updatesip(Request $request)
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
                
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/SIP'), $filenameSimpan);
    
                $upload = FileSIP::where('id', $request->id)->update([
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileSIP::where('id', $request->id)->update([
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
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

    public function destroysip(Request $request)
    {
        $sip = FileSIP::where('id', $request->id)->first();
        $delete = FileSIP::where('id', $request->id)->delete();
        if ($delete) {
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

    public function riwayat() {
        $auth = Auth::user()->id_pegawai;

        $pegawai = Pegawai::where('id', $auth)->first();
        $pengguna = User::where('id_pegawai',$auth)->first();
        $master_berkas_perjanjian = MasterBerkas::where('kategori','perjanjian')->get();

        $str = FileSTR::where('id_pegawai', $auth)->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })->get();

        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai,
            'master_berkas_perjanjian' => $master_berkas_perjanjian
          
        ];
        return view('pages.Pengguna.page-riwayat',$data);
    }

    public function storeriwayat(Request $request)
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

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/RiwayatKerja'), $filenameSimpan);

                $date = Carbon::today()->toDateString();

                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                        // 'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Dokumen Riwayat Pekerjaan Berhasil Disimpan',
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

    public function editriwayat(Request $request)
    {
        $riwayat = FileRiwayatKerja::where('id', $request->id)->first();
        if ($riwayat) {
            return response()->json([
                'message' => 'Data Riwayat Pekerjaan Ditemukan',
                'code' => 200,
                'data' => $riwayat
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updateriwayat(Request $request)
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

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                
                $delete_file = FileRiwayatKerja::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/RiwayatKerja/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/RiwayatKerja'), $filenameSimpan);

                $date = Carbon::today()->toDateString();

                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }
            }else {
                $date = Carbon::today()->toDateString();
                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                       
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                       
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                       
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                       
                    ]);
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen Riwayat Pekerjaan Berhasil Diubah',
                'data' => $upload
            ]);

        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function destroyriwayat(Request $request)
    {
        $delete_riwayat = FileRiwayatKerja::where('id', $request->id)->first();
            $delete = FileRiwayatKerja::where('id', $request->id)->delete();
            if ($delete) {
                File::delete('File/Pegawai/Dokumen/RiwayatKerja/'.$delete_riwayat->file);
                return response()->json([
                    'message' => 'Data Riwayat Kerja Berhasil Dihapus',
                    'code' => 200,
                ]);
            }
    }

    public function storevaksin(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            // 'nama_file' => 'required',
            'dosis' => 'required',
            'jenis_vaksin' => 'required',
            'tgl_vaksin' => 'required',
            'tempat_vaksin' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            // 'nama_file.required' => 'Nama File Wajib Diisi',
            'dosis.required' => 'Dosis Vaksin Wajib Diisi',
            'jenis_vaksin.required' => 'Janis Vaksin Wajib Diisi',
            'tgl_vaksin.required' => 'Tanggal Vaksin Wajib Diisi',
            'tempat_vaksin.required' => 'Tempat Vaksin Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Vaksin/'), $filenameSimpan);
    
                $upload = FileVaksin::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nama_file_kesehatan_id' => $request->nama_file,
                    'dosis' => $request->dosis,
                    'jenis_vaksin' =>$request->jenis_vaksin,
                    'tgl_vaksin' => $request->tgl_vaksin,
                    'tempat_vaksin' =>$request->tempat_vaksin,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Vaksin ('.$request->jenis_vaksin.') Berhasil Disimpan',
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

    public function editvaksin(Request $request)
    {
        $dokumen = FileVaksin::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $dokumen
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updatevaksin(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            // 'nama_file' => 'required',
            'dosis' => 'required',
            'jenis_vaksin' => 'required',
            'tgl_vaksin' => 'required',
            'tempat_vaksin' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            // 'nama_file.required' => 'Nama File Wajib Diisi',
            'dosis.required' => 'Dosis Vaksin Wajib Diisi',
            'jenis_vaksin.required' => 'Janis Vaksin Wajib Diisi',
            'tgl_vaksin.required' => 'Tanggal Vaksin Wajib Diisi',
            'tempat_vaksin.required' => 'Tempat Vaksin Wajib Diisi',
            //'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileVaksin::where('id', $request->id)->first();
                File::delete('File/Pegawai/Kesehatan/Vaksin/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Vaksin/'), $filenameSimpan);
    
                $upload = FileVaksin::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nama_file_kesehatan_id' => $request->nama_file,
                    'dosis' => $request->dosis,
                    'jenis_vaksin' =>$request->jenis_vaksin,
                    'tgl_vaksin' => $request->tgl_vaksin,
                    'tempat_vaksin' =>$request->tempat_vaksin,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Vaksin ('.$request->jenis_vaksin.') Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileVaksin::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nama_file_kesehatan_id' => $request->nama_file,
                    'dosis' => $request->dosis,
                    'jenis_vaksin' =>$request->jenis_vaksin,
                    'tgl_vaksin' => $request->tgl_vaksin,
                    'tempat_vaksin' =>$request->tempat_vaksin,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Vaksin ('.$request->jenis_vaksin.') Berhasil Diubah',
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

    public function destroyvaksin(Request $request)
    {
        $delete_file = FileVaksin::where('id', $request->id)->first();
        $delete = FileVaksin::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Kesehatan/Vaksin/'.$delete_file->file);
            return response()->json([
                'message' => 'Data Vaksin ('.$request->jenis.') Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function sertifikat() {
        $auth = Auth::user()->id_pegawai;

        $pegawai = Pegawai::where('id', $auth)->first();
        $pengguna = User::where('id_pegawai',$auth)->first();
        $master_berkas_kompetensi = MasterBerkas::where('kategori','kompetensi')->get();

        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai,
            'master_berkas_kompetensi' => $master_berkas_kompetensi
        ];

        return view('pages.Pengguna.page-sertif',$data);
    }

    public function getSertif(Request $request) {
        $auth = Auth::user()->id_pegawai;

        $get = FileSertifPelatihan::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'sertif_pelatihan.berkas_id', '=', 'master_berkas_pegawai.id')
        ->select('sertif_pelatihan.id','sertif_pelatihan.berkas_id','sertif_pelatihan.id_pegawai','sertif_pelatihan.nm_kegiatan','sertif_pelatihan.tgl_kegiatan',
        'sertif_pelatihan.tmp_kegiatan','sertif_pelatihan.penyelenggara','sertif_pelatihan.file','master_berkas_pegawai.nama_berkas')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
    }

    public function storeSertif(Request $request)
    {
        $validated = Validator::make($request->all(),[
            // 'id_pegawai' => 'required',
            'berkas_id' => 'required',
            'nm_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'tmp_kegiatan' => 'required',
            'penye_kegiatan' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            // 'id_pegawai.required' => 'Nama File Wajib diisi',
            'berkas_id.required' => 'Jenis Sertifikat Pelatihan Wajib Dipilih',
            'nm_kegiatan.required' => 'Nama Kegiatan / Pelatihan Wajib diisi',
            'tgl_kegiatan.required' => 'Tanggal Kegiatan / Pelatihan Wajib diisi',
            'tmp_kegiatan.required' => 'Tempat Kegiatan / Pelatihan Wajib diisi',
            'penye_kegiatan.required' => 'Penyelenggara Kegiatan / Pelatihan Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan'), $filenameSimpan);
    
                $store = FileSertifPelatihan::create([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Disimpan',
                    'data' => $store
                ]);
            }
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function editSertif(Request $request)
    {
        $dokumen = FileSertifPelatihan::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $dokumen
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updateSertif(Request $request)
    {
        $validated = Validator::make($request->all(),[
            // 'id_pegawai' => 'required',
            'berkas_id' => 'required',
            'nm_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'tmp_kegiatan' => 'required',
            'penye_kegiatan' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            // 'id_pegawai.required' => 'Nama File Wajib diisi',
            'berkas_id.required' => 'Jenis Sertifikat Pelatihan Wajib Dipilih',
            'nm_kegiatan.required' => 'Nama Kegiatan / Pelatihan Wajib diisi',
            'tgl_kegiatan.required' => 'Tanggal Kegiatan / Pelatihan Wajib diisi',
            'tmp_kegiatan.required' => 'Tempat Kegiatan / Pelatihan Wajib diisi',
            'penye_kegiatan.required' => 'Penyelenggara Kegiatan / Pelatihan Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileSertifPelatihan::where('id', $request->id)->first();
                File::delete('File/Pegawai/Diklat/Sertifikat-Pelatihan/'.$delete_file->file);

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan'), $filenameSimpan);
    
                $update = FileSertifPelatihan::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Diupdate',
                    'data' => $update
                ]);
            }else {

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $update = FileSertifPelatihan::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Diupdate',
                    'data' => $update
                ]);
            }
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function destroySertif(Request $request)
    {
        $dokumen = FileSertifPelatihan::where('id', $request->id)->first();
        $delete_file = FileSertifPelatihan::where('id', $request->id)->delete();

        $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
        $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
        
        if ($delete_file) {
            File::delete('File/Pegawai/Diklat/Sertifikat-Pelatihan/'.$dokumen->file);
            return response()->json([
                'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function riwayat_pelatihan()  {
        $auth = Auth::user()->id_pegawai;
        $pengguna = User::where('id_pegawai',$auth)->first();
        $pegawai = Pegawai::where('id', $auth)->first();
        $data = [
            'pengguna' => $pengguna,
            'pegawai' => $pegawai
        ];
        return view('pages.Pengguna.page-pelatihan',$data);
    }


    public function absensi_diklat() {
        $auth = Auth::user()->id_pegawai;
        $database_2 = config('database.connections.mysql2.database');

        $get = AbsenDiklat::where('id_pegawai',$auth)
        ->join("$database_2.pegawai as pegawai",'absensi_diklat.id_pegawai','=','pegawai.id')//join database simrs
        ->join("$database_2.departemen as departemen",'pegawai.departemen','=','departemen.dep_id')
        ->join('kegiatan','absensi_diklat.kegiatan_id','=','kegiatan.id')
        ->select('absensi_diklat.id','pegawai.id AS id_pegawai','pegawai.nik','pegawai.nama AS nama_pegawai','kegiatan.nama AS nama_kegiatan','departemen.nama AS nama_dep',
        'absensi_diklat.masuk_at','absensi_diklat.selesai_at','absensi_diklat.total_waktu','kegiatan.tempat')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
        
    }

    public function orientasi() {
        $auth = Auth::user()->id_pegawai;
        $pegawai = Pegawai::where('id', $auth)->first();
        $data = [
            'pegawai' => $pegawai
        ];
        return view('pages.Pengguna.page-orientasi',$data);
    }

    public function getOrientasi(Request $request)
    {
        $auth = Auth::user()->id_pegawai;
        $getfile = FileOrientasi::where('id_pegawai', $auth)->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }

    public function storeOrientasi(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nomor_orientasi' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nomor_orientasi.required' => 'Nomor Sertifikat Wajib diisi',
            'tgl_mulai.required' => 'Tanggal Mulai Wajib diisi',
            'tgl_selesai.required' => 'Tanggal Selesai Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Orientasi'), $filenameSimpan);
    
                $upload = FileOrientasi::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Oriantasi '.$request->nomor_orientasi.' Berhasil Disimpan',
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

    public function editOrientasi(Request $request)
    {
        $dokumen = FileOrientasi::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $dokumen
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function updateOrientasi(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nomor_orientasi' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nomor_orientasi.required' => 'Nomor Sertifikat Wajib diisi',
            'tgl_mulai.required' => 'Tanggal Mulai Wajib diisi',
            'tgl_selesai.required' => 'Tanggal Selesai Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileOrientasi::where('id', $request->id_orientasi)->first();
                File::delete('File/Pegawai/Dokumen/Orientasi/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Orientasi'), $filenameSimpan);
    
                $upload = FileOrientasi::where('id', $request->id_orientasi)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Oriantasi '.$request->nomor_orientasi.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $upload = FileOrientasi::where('id', $request->id_orientasi)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Oriantasi '.$request->nomor_orientasi.' Berhasil Diupdate',
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

    public function destroyOrientasi(Request $request)
    {
        $delete_file = FileOrientasi::where('id', $request->id_orientasi)->first();

        $delete = FileOrientasi::where('id', $request->id_orientasi)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Orientasi/'.$delete_file->file);
            return response()->json([
                'message' => 'Data Sertifikat '.$request->nomor.' Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
