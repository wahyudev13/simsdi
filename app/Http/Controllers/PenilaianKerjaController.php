<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianKerja;
use App\Models\FileKesehatan;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\Departemen;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;


class PenilaianKerjaController extends Controller
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
        $deparetemen = Departemen::get();
        $data = [
            'pegawai' => $pegawai,
            'deparetemen' => $deparetemen,
        ];
        return view('pages.Karyawan.penilaian-kerja',$data);
    }

    public function get(Request $request) {
        $database_2 = config('database.connections.mysql2.database');
        $penilaian_kerja = PenilaianKerja::where('penilaian_kerja.id_pegawai',$request->id)
        ->join("$database_2.departemen as departemen",'penilaian_kerja.departemen_id','=','departemen.dep_id')
        ->orderBy('penilaian_kerja.created_at','desc')
        ->get();

        return DataTables::of($penilaian_kerja)
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
            'id_pegawai' => 'required',
            'tgl_penilaian' => 'required',
            'dep_penilaian' => 'required',
            'jabatan' => 'required',
            'nilai' => 'required',
            // 'ket' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'tgl_penilaian' => 'Tanggal Penilaian Wajib Diisi',
            'dep_penilaian.required' => 'Departemen / Unit Kerja Pegawai Wajib diisi',
            'jabatan.required' => 'Jabatan Pegawai Wajib diisi',
            'nilai.required' => 'Total Nilai Wajib diisi',
            // 'ket.required' => 'Keterangan Nilai Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Penilaian'), $filenameSimpan);

                $ket ='';
                if ($request->nilai < 59 || $request->nilai == 59) {
                    $ket = 'Sangat Kurang';
                }elseif ($request->nilai > 59 && $request->nilai < 70) {
                    $ket = 'Kurang';
                }elseif ($request->nilai > 69 && $request->nilai < 81) {
                    $ket = 'Cukup';
                }elseif ($request->nilai > 80 && $request->nilai < 91) {
                    $ket = 'Baik';
                }elseif ($request->nilai > 90 && $request->nilai < 101) {
                    $ket = 'Sangat Baik / Istimewa';
                }
    
                $upload = PenilaianKerja::create([
                    'id_pegawai' => $request->id_pegawai,
                    'tgl_penilaian' => $request->tgl_penilaian,
                    'departemen_id' => $request->dep_penilaian,
                    'jabatan' => $request->jabatan,
                    'jml_total' => $request->nilai,
                    'keterangan' => $ket,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Penilaian '.$pegawai->nama.' Berhasil Disimpan',
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
     * @param  \App\Models\PenilaianKerja  $penilaianKerja
     * @return \Illuminate\Http\Response
     */
    public function show(PenilaianKerja $penilaianKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenilaianKerja  $penilaianKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dokumen = PenilaianKerja::where('id', $request->id)->first();
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
     * @param  \App\Models\PenilaianKerja  $penilaianKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'tgl_penilaian' => 'required',
            'dep_penilaian' => 'required',
            'jabatan' => 'required',
            'nilai' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'tgl_penilaian' => 'Tanggal Penilaian Wajib Diisi',
            'dep_penilaian.required' => 'Departemen / Unit Kerja Pegawai Wajib diisi',
            'jabatan.required' => 'Jabatan Pegawai Wajib diisi',
            'nilai.required' => 'Total Nilai Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = PenilaianKerja::where('id', $request->id)->first();
                File::delete('File/Pegawai/Penilaian/'.$delete_file->file);

                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Penilaian'), $filenameSimpan);

                $ket ='';
                if ($request->nilai < 59 || $request->nilai == 59) {
                    $ket = 'Sangat Kurang';
                }elseif ($request->nilai > 59 && $request->nilai < 70) {
                    $ket = 'Kurang';
                }elseif ($request->nilai > 69 && $request->nilai < 81) {
                    $ket = 'Cukup';
                }elseif ($request->nilai > 80 && $request->nilai < 91) {
                    $ket = 'Baik';
                }elseif ($request->nilai > 90 && $request->nilai < 101) {
                    $ket = 'Sangat Baik / Istimewa';
                }
    
                $upload = PenilaianKerja::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'tgl_penilaian' => $request->tgl_penilaian,
                    'departemen_id' => $request->dep_penilaian,
                    'jabatan' => $request->jabatan,
                    'jml_total' => $request->nilai,
                    'keterangan' => $ket,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Penilaian '.$pegawai->nama.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
                $ket ='';
                if ($request->nilai < 59 || $request->nilai == 59) {
                    $ket = 'Sangat Kurang';
                }elseif ($request->nilai > 59 && $request->nilai < 70) {
                    $ket = 'Kurang';
                }elseif ($request->nilai > 69 && $request->nilai < 81) {
                    $ket = 'Cukup';
                }elseif ($request->nilai > 80 && $request->nilai < 91) {
                    $ket = 'Baik';
                }elseif ($request->nilai > 90 && $request->nilai < 101) {
                    $ket = 'Sangat Baik / Istimewa';
                }
    
                $upload = PenilaianKerja::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'tgl_penilaian' => $request->tgl_penilaian,
                    'departemen_id' => $request->dep_penilaian,
                    'jabatan' => $request->jabatan,
                    'jml_total' => $request->nilai,
                    'keterangan' => $ket,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Penilaian '.$pegawai->nama.' Berhasil Diupdate',
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
     * @param  \App\Models\PenilaianKerja  $penilaianKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = PenilaianKerja::where('id', $request->id)->first();
    
        $delete = PenilaianKerja::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Penilaian/'.$dokumen->file);
            return response()->json([
                'message' => 'Data Penilaian Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }
}
