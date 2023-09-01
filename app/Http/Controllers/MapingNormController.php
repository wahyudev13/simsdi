<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Pasien;
use App\Models\MapingNorm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class MapingNormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $database_2 = config('database.connections.mysql2.database');
        $getuser = User::join("$database_2.pegawai as tbsik_pegawai",'pengguna.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join("$database_2.departemen as departemen",'tbsik_pegawai.departemen','=','departemen.dep_id')
        ->select('pengguna.id AS id_pegawai','pengguna.id_pegawai','tbsik_pegawai.nik as nik_pegawai','pengguna.username',
        'tbsik_pegawai.nama','tbsik_pegawai.jbtn','departemen.nama AS nama_dep')
        ->get();

        // $pasien = Pasien::get();

        $data = [
            'pengguna' => $getuser,
            // 'pasien' => $pasien
        ];  
        return view('pages.Master.master-mapingrm',$data);
    }

    public function get() {
        $database_2 = config('database.connections.mysql2.database');

        $get = MapingNorm::join("$database_2.pegawai as pegawai",'maping_norm_simrs.id_pegawai','=','pegawai.id')
        ->join("$database_2.pasien as pasien",'maping_norm_simrs.no_rkm_medis','=','pasien.no_rkm_medis')
        ->select('maping_norm_simrs.id','maping_norm_simrs.id_pegawai','maping_norm_simrs.no_rkm_medis',
        'pegawai.nama AS nama_pegawai','pasien.nm_pasien AS nama_pasien')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
    }

    public function load(Request $request) {
        // $database_2 = config('database.connections.mysql2.database');
        // $pengguna = User::where('pengguna.id',$request->id)->join("$database_2.pegawai as tbsik_pegawai",'pengguna.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        // ->join("$database_2.departemen as departemen",'tbsik_pegawai.departemen','=','departemen.dep_id')
        // ->select('pengguna.id AS id_pegawai','pengguna.id_pegawai','tbsik_pegawai.nik as nik_pegawai','pengguna.username',
        // 'tbsik_pegawai.nama','tbsik_pegawai.jbtn','pengguna.email','departemen.nama AS nama_dep')
        // ->first();

        // return response()->json([
        //     'data'=>$pengguna
        // ]);

        $pegawai = Pegawai::where('pegawai.id',$request->id_pegawai)
        ->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->select('pegawai.id','pegawai.nik','pegawai.nama','pegawai.jk','pegawai.jbtn','departemen.nama AS nama_dep')
        ->first();

         return response()->json([
            'data'=>$pegawai
        ]);

    }

    public function pasien(Request $request) {
        if(!empty($request->nama)) {
            $pasien = Pasien::where('nm_pasien','like',"%".$request->nama."%")->get();
        }else {
            $pasien = Pasien::limit(100)->get();
        }
      
        return DataTables::of($pasien)
        ->addIndexColumn()
        ->make(true);

    }

    public function load_pasien(Request $request) {
        $pasien = Pasien::where('no_rkm_medis',$request->norm)->first();
        return response()->json([
            'data'=>$pasien
        ]);
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
            'norm' => 'required'
           
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            'norm' => 'No Rekam Medis Wajib Diisi' 
        ]);

        if ($validated->passes()) {

            $cek = MapingNorm::where('id_pegawai',$request->id_pegawai)->count();
            $cekrm = MapingNorm::where('no_rkm_medis',$request->norm)->count();

            if ($cek > 0) {
                return response()->json([
                    'status' => 401,
                    'message' => 'ID Pegawai '.$request->id_pegawai.' Sudah Digunakan',
                ]);
            }else {
                if ($cekrm > 0) {
                    return response()->json([
                        'status' => 401,
                        'message' => 'No Rekam Medis '.$request->norm.' Sudah Digunakan',
                    ]);
                }else {
                    $maping_store = MapingNorm::create([
                        'id_pegawai' => $request->id_pegawai,
                        'no_rkm_medis' => $request->norm
                    ]);
                   
                    return response()->json([
                        'status' => 200,
                        'message' => 'Maping NO Rekam Medis '.$request->norm.' Berhasil Disimpan',
                        'data' => $maping_store
                    ]);
                }
               
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
     * @param  \App\Models\MapingNorm  $mapingNorm
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $database_2 = config('database.connections.mysql2.database');

        $show = MapingNorm::where('maping_norm_simrs.id',$request->id)
        ->join("$database_2.pegawai as pegawai",'maping_norm_simrs.id_pegawai','=','pegawai.id')
        ->join("$database_2.pasien as pasien",'maping_norm_simrs.no_rkm_medis','=','pasien.no_rkm_medis')
        ->select('maping_norm_simrs.id','maping_norm_simrs.id_pegawai','maping_norm_simrs.no_rkm_medis',
        'pegawai.nama AS nama_pegawai','pasien.nm_pasien AS nama_pasien')
        ->first();

        if ($show) {
            return response()->json([
                'message' => 'Data Maping Ditemukan',
                'code' => 200,
                'data' => $show
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MapingNorm  $mapingNorm
     * @return \Illuminate\Http\Response
     */
    public function edit(MapingNorm $mapingNorm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MapingNorm  $mapingNorm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id' => 'required',
            'id_pegawai' => 'required',
            'no_rm' => 'required'
           
        ],[
            'id' => 'Pilih Data yang Sudah Ada Terlebih Dahulu',
            'id_pegawai.required' => 'ID Pengguna Wajib diisi',
            'no_rm' => 'No Rekam Medis Wajib Diisi' 
        ]);

        if ($validated->passes()) {

            $cek = MapingNorm::where('id_pegawai',$request->id_pegawai)->whereNotIn('id',[$request->id])->count();
            $cekrm = MapingNorm::where('no_rkm_medis',$request->no_rm)->whereNotIn('id',[$request->id])->count();

            if ($cek > 0) {
                return response()->json([
                    'status' => 401,
                    'message' => 'ID Pegawai '.$request->id_pegawai.' Sudah Digunakan',
                ]);
            }else {
                if ($cekrm > 0) {
                    return response()->json([
                        'status' => 401,
                        'message' => 'No Rekam Medis '.$request->no_rm.' Sudah Digunakan',
                    ]);
                }else {
                    $maping_update = MapingNorm::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                        'no_rkm_medis' => $request->no_rm
                    ]);
                   
                    return response()->json([
                        'status' => 200,
                        'message' => 'Maping NO Rekam Medis '.$request->no_rm.' Berhasil Diupdate',
                        'data' => $maping_update
                    ]);
                }
               
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
     * @param  \App\Models\MapingNorm  $mapingNorm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete = MapingNorm::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json([
                'message' => 'Data Maping '.$request->nama.'('.$request->norm.') Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }
}
