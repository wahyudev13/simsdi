<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\JenisKegiatan;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\AbsenDiklat;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $data = [
            'kegiatan2' => $kegiatan
        ];
        return view('pages.Diklat.Absensi.absen-masuk',$data);
    }

    public function get_masuk(Request $request) {
        $database_2 = config('database.connections.mysql2.database');

        $get = AbsenDiklat::where('kegiatan_id',$request->kegiatan_id)
        ->join("$database_2.pegawai as pegawai",'absensi_diklat.id_pegawai','=','pegawai.id')//join database simrs
        ->join("$database_2.departemen as departemen",'pegawai.departemen','=','departemen.dep_id')
        ->join('kegiatan','absensi_diklat.kegiatan_id','=','kegiatan.id')
        ->select('absensi_diklat.id','pegawai.id AS id_pegawai','pegawai.nik','pegawai.nama AS nama_pegawai','kegiatan.nama AS nama_kegiatan','departemen.nama AS nama_dep',
        'absensi_diklat.masuk_at','absensi_diklat.selesai_at','absensi_diklat.total_waktu')
        ->get();

        return DataTables::of($get)
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
        $pegawai = Pegawai::where('nik',$request->nik)->first();

        if ($pegawai) {
            $cekabsen = AbsenDiklat::where('id_pegawai',$pegawai->id)->where('kegiatan_id',$request->kegiatan_id)->get();
            $count = $cekabsen->count();
            if ($count > 0){
                return response()->json([
                    'status' => 402,
                    'message' => $pegawai->nama.'('.$pegawai->nik.') Sudah Melakukan Absen Sebelumnya',
                ]);
            }else {
                $store_absen = AbsenDiklat::create([
                    'kegiatan_id' => $request->kegiatan_id,
                    'id_pegawai'=> $pegawai->id,
                    'masuk_at' => now(),
                    'date' => date('Y-m-d',strtotime(now()))
                ]);
        
                if ($store_absen) {
                    return response()->json([
                        'status' => 200,
                        'message' => $pegawai->nama.'('.$pegawai->nik.') Absen Kedatangan',
                        'data' => $store_absen
                    ]);
                }
            }
            
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data Pegawai '.$request->nik.' Tidak Ada/Ditemukan',
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
    public function edit($id)
    {
        //
    }

    public function selesai($id) {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $data = [
            'kegiatan2' => $kegiatan
        ];
        return view('pages.Diklat.Absensi.absen-selesai',$data);
    }

    public function manual($id) {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $data = [
            'kegiatan2' => $kegiatan
        ];
        return view('pages.Diklat.Absensi.absen-manual',$data);
    }

    public function store_manual(Request $request) {
        $validated = Validator::make($request->all(),[
            'id_kegiatan' => 'required',
            'id_pegawai' =>'required',
            'masuk' => 'required',
            'selesai' => 'required',
           
        ],[
            'id_kegiatan.required' => 'kegiatan Wajib diisi',
            'id_pegawai.required' => 'Pegawai Wajib diisi',
            'masuk.required' => 'Waktu Mulai Wajib diisi',
            'selesai.required' => 'Waktu Selesai Wajib diisi',
          
        ]);

        if ($validated->passes()) {
            $pegawai = Pegawai::where('id',$request->id_pegawai)->first();

            $cekabsen = AbsenDiklat::where('id_pegawai',$request->id_pegawai)->where('kegiatan_id',$request->id_kegiatan)->get();
            $count = $cekabsen->count();
            if ($count > 0){
                return response()->json([
                    'status' => 402,
                    'message' => $pegawai->nama.'('.$pegawai->nik.') Sudah Melakukan Absen Sebelumnya',
                ]);
            }else {

                $store_absen = AbsenDiklat::create([
                    'kegiatan_id' => $request->id_kegiatan,
                    'id_pegawai'=> $request->id_pegawai,
                    'masuk_at' => date('Y-m-d H:i:s',strtotime($request->masuk)),
                    'selesai_at' => date('Y-m-d H:i:s',strtotime($request->selesai)),
                    'total_waktu' => Carbon::parse($request->masuk)->diffInHours($request->selesai, ['syntax' => 1, 'parts' => 1]),
                    'date' => date('Y-m-d',strtotime(now())),
                    'poin' => '1'
                ]);

                if ($store_absen) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Absen Kegiatan '.$pegawai->nama.' ('.$pegawai->nik.') Berhasil Ditambahkan',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pegawai = Pegawai::where('nik',$request->nik)->first();

        if ($pegawai) {
            $cekabsen = AbsenDiklat::where('id_pegawai',$pegawai->id)->where('kegiatan_id',$request->kegiatan_id)->get();
            $count = $cekabsen->count();
            if ($count == 0){
                return response()->json([
                    'status' => 402,
                    'message' => $pegawai->nama.' ('.$pegawai->nik.') Belum Melakukan Absen Masuk/Mulai Kegiatan',
                ]);
            }else {
                $absen = AbsenDiklat::where('id_pegawai',$pegawai->id)->where('kegiatan_id',$request->kegiatan_id)->first();
                if ($absen->selesai_at == null) {
                    $clock = Carbon::now()->diffInMinutes($absen->masuk_at, true);
                    $total = $clock/60;
                    $update_absen = AbsenDiklat::where('id_pegawai',$pegawai->id)
                    ->where('kegiatan_id',$request->kegiatan_id)
                    ->update([
                        'selesai_at' => now(),
                        'total_waktu'=> $total,
                        'poin' => '1'
                    ]);
            
                    if ($update_absen) {
                        return response()->json([
                            'status' => 200,
                            'message' => $pegawai->nama.' ('.$pegawai->nik.') Absen Selesai/Pulang Kegiatan',
                            'data' => $update_absen
                        ]);
                    }
                }
                else {
                    return response()->json([
                        'status' => 402,
                        'message' => $pegawai->nama.' ('.$pegawai->nik.') Sudah Melakukan Absen Selesai/Pulang Kegiatan',
                    ]);
                }
                
            }
            
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data Pegawai '.$request->nik.' Tidak Ada/Ditemukan',
            ]);
        }
    }

    public function rekap($id) {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $data = [
            'kegiatan2' => $kegiatan
        ];
        return view('pages.Diklat.Absensi.absen-rekap',$data);
    }

    // public function get_selesai() {
    //     $database_2 = config('database.connections.mysql2.database');

    //     $get = AbsenDiklat::where('kegiatan_id',$request->kegiatan_id)
    //     ->join("$database_2.pegawai as pegawai",'absensi_diklat.id_pegawai','=','pegawai.id')//join database simrs
    //     ->join("$database_2.departemen as departemen",'pegawai.departemen','=','departemen.dep_id')
    //     ->join('kegiatan','absensi_diklat.kegiatan_id','=','kegiatan.id')
    //     ->select('pegawai.nik','pegawai.nama AS nama_pegawai','kegiatan.nama AS nama_kegiatan','departemen.nama AS nama_dep',
    //     'absensi_diklat.masuk_at','absensi_diklat.selesai_at','absensi_diklat.total_waktu')
    //     ->get();

    //     return DataTables::of($get)
    //     ->addIndexColumn()
    //     ->make(true);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $kegiatan = Kegiatan::where('id',$request->id_kegiatan)->first();
        $pegawai = Pegawai::where('id',$request->id_pegawai)->first();

        $delete = AbsenDiklat::where('id', $request->id)->delete();

        if ($delete) {
            return response()->json([
                'message' => 'Absen Kegiatan '.$kegiatan->nama.' '.$pegawai->nama.' ('.$pegawai->nik.') Berhasil Dihapus',
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }
}
