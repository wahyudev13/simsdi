<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\VerifIjazah;
use App\Models\Departemen;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class FileIjazahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pegawai = Pegawai::where('id', $id)->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->select('pegawai.id','pegawai.nama','pegawai.jbtn','pegawai.nik','departemen.nama AS nama_dep')
        ->first();
        $master_berkas_pendidikan = MasterBerkas::where('kategori','pendidikan')->get();
        $master_berkas_izin = MasterBerkas::where('kategori','ijin')->get();
        $master_berkas_lain = MasterBerkas::where('kategori','lain')->get();
        $master_berkas_identitas = MasterBerkas::where('kategori','identitas')->get();
        $master_berkas_perjanjian = MasterBerkas::where('kategori','perjanjian')->get();
        $master_berkas_orientasi = MasterBerkas::where('kategori','orientasi')->get();
        $deparetemen = Departemen::get();
        $str = FileSTR::where('id_pegawai', $id)->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })->get();
        //$str = FileSTR::where('id_pegawai', $id)->where('status','active')->orwhere('status','proses')->get();
        $data=[
            'pegawai' => $pegawai,
            'master_berkas_pendidikan' => $master_berkas_pendidikan,
            'master_berkas_izin' => $master_berkas_izin,
            'master_berkas_lain' => $master_berkas_lain,
            'master_berkas_identitas' => $master_berkas_identitas,
            'master_berkas_perjanjian' => $master_berkas_perjanjian,
            'master_berkas_orientasi' => $master_berkas_orientasi,
            'file_str' => $str,
            'deparetemen' => $deparetemen,
        ];
        return view('pages.Karyawan.berkas-kepegawaian',$data);
    }

    //Get Brekas Ijazah
    public function getBerkas(Request $request)
    {
        $berkas = FileIjazah::where('id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_ijazah.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->leftjoin('verif_ijazah','file_ijazah.id','=','verif_ijazah.ijazah_id')
        ->select('file_ijazah.id AS id_ijazah','master_berkas_pegawai.nama_berkas','file_ijazah.nomor','file_ijazah.asal',
        'file_ijazah.thn_lulus','file_ijazah.file','file_ijazah.updated_at','verif_ijazah.id AS id_verif','verif_ijazah.file AS file_verif',
        'verif_ijazah.keterangan')
        ->get();

        return DataTables::of($berkas)
        ->editColumn('updated_at',function($berkas) {
            return $berkas->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);

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
    public function edit(Request $request)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
            'asal.required' => 'Asal Universitas Wajib diisi',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = FileIjazah::where('id', $request->id)->first();
        $dokumenbukti = VerifIjazah::where('ijazah_id', $request->id)->first();
    
        $delete = FileIjazah::where('id', $request->id)->delete();
        if ($delete) {
            if ($dokumenbukti == null) {
                File::delete('File/Pegawai/Dokumen/Ijazah/'.$dokumen->file);
                return response()->json([
                    'message' => 'Data Ijazah Berhasil Dihapus',
                    'code' => 200,
                ]);
            }else {
                File::delete('File/Pegawai/Dokumen/Ijazah/'.$dokumen->file);
                File::delete('File/Pegawai/Dokumen/Ijazah/Verifikasi/'.$dokumenbukti->file);
                return response()->json([
                    'message' => 'Data Ijazah & Bukti Verifikasi Berhasil Dihapus',
                    'code' => 200,
                ]);
            }
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }
}
