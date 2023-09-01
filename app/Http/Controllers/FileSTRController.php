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
class FileSTRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date = Carbon::today()->toDateString();
        // dd($date);
    }

    public function getSTR(Request $request)
    {
        $getstr = FileSTR::where('id_pegawai',$request->id)
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->leftjoin('verif_str','file_str.id','=','verif_str.str_id')
        ->select('file_str.id','file_str.no_reg_str','file_str.kompetensi','file_str.file','file_str.tgl_ed',
        'file_str.pengingat','master_berkas_pegawai.nama_berkas','file_str.updated_at','file_str.status','verif_str.id AS id_verif_str',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $upload = FileSTR::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Status Dokumen STR '.$request->noreg.' Berhasil Diubah',
            'data' => $upload
        ]);
    }
}
