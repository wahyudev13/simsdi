<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\JenisKegiatan;
use App\Models\Kegiatan;
use App\Models\AbsenDiklat;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.Diklat.page-kegiatan');
    }

    public function json_dep(Request $request) {
        $search = $request->search;
        if ($search == '') {
            $dep = Departemen::get();
        }else {
            $dep = Departemen::where('nama', 'like', '%' .$search . '%')->get();
        }
        $response = array();
        foreach($dep as $item){
            $response[] = array(
                "id"=>$item->dep_id,
                "text"=>$item->nama,
            );
        }

        return response()->json($response); 
    }

    public function json_jenis(Request $request) {
        $search = $request->search;
        if ($search == '') {
            $jenis = JenisKegiatan::get();
        }else {
            $jenis = JenisKegiatan::where('nama', 'like', '%' .$search . '%')->get();
        }
        $response = array();
        foreach($jenis as $item){
            $response[] = array(
                "id"=>$item->id,
                "text"=>$item->nama,
            );
        }

        return response()->json($response); 
    }

    public function get() {

        $database_2 = config('database.connections.mysql2.database');

        $get = Kegiatan::join("$database_2.departemen as departemen",'kegiatan.departemen_id','=','departemen.dep_id')
        ->join('jenis_kegiatan','kegiatan.jenis_kegiatans_id','=','jenis_kegiatan.id')
        ->select('kegiatan.id','departemen.nama','kegiatan.nama as nama_kegiatan','jenis_kegiatan.nama AS nama_jenis',
        'kegiatan.tempat','kegiatan.tanggal','kegiatan.tanggal2')
        ->orderBy('kegiatan.created_at','desc')
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
        $validated = Validator::make($request->all(),[
            'departemen' => 'required',
            'nama' => 'required',
            'jenis_kegiatan' => 'required',
            'tempat' => 'required',
            'tanggal' => 'required',
            'tanggal2' => 'required'
        ],[
            'departemen.required' => 'Unit Wajib Diisi',
            'nama.required' => 'Nama Kegiatan Wajib Diisi',
            'jenis_kegiatan.required' => 'Jenis Kegiatan Wajib Diisi',
            'tempat.required' => 'Tempat Kegiatan Wajib Diisi',
            'tanggal.required' => 'Tanggal Mulai Kegiatan Wajib Diisi',
            'tanggal2.required' => 'Tanggal Selesai Kegiatan Wajib Diisi',
        ]);

        if ($validated->passes()) {
          
            $store = Kegiatan::create([
                'departemen_id' => $request->departemen,
                'nama' => $request->nama,
                'jenis_kegiatans_id' => $request->jenis_kegiatan,
                'tempat' => $request->tempat,
                'tanggal' => $request->tanggal,
                'tanggal2' => $request->tanggal2,

            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Kegiatan ('.$request->nama.') Berhasil Disimpan',
                'data' => $store
            ]);
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
        $edit = Kegiatan::where('id',$request->id)->first();
        if ($edit) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $edit
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
            'departemen' => 'required',
            'nama' => 'required',
            'jenis_kegiatan' => 'required',
            'tempat' => 'required',
            'tanggal' => 'required',
            'tanggal2' => 'required'
        ],[
            'departemen.required' => 'Unit Wajib Diisi',
            'nama.required' => 'Nama Kegiatan Wajib Diisi',
            'jenis_kegiatan.required' => 'Jenis Kegiatan Wajib Diisi',
            'tempat.required' => 'Tempat Kegiatan Wajib Diisi',
            'tanggal.required' => 'Tanggal Mulai Kegiatan Wajib Diisi',
            'tanggal2.required' => 'Tanggal Selesai Kegiatan Wajib Diisi',
        ]);

        if ($validated->passes()) {
          
            $update = Kegiatan::where('id',$request->id)->update([
                'departemen_id' => $request->departemen,
                'nama' => $request->nama,
                'jenis_kegiatans_id' => $request->jenis_kegiatan,
                'tempat' => $request->tempat,
                'tanggal' => $request->tanggal,
                'tanggal2' => $request->tanggal2
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Kegiatan ('.$request->nama.') Berhasil Diupdate',
                'data' => $update
            ]);
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
        $cekabsen = AbsenDiklat::where('kegiatan_id',$request->id)->get();
        $count = $cekabsen->count();
        if ($count > 0) {
            return response()->json([
                'message' => 'Gagal Hapus, Data Kegiatan '.$request->name.' Masih Digunakan',
                'code' => 401,
            ]);
        }else {
            $del = Kegiatan::where('id',$request->id)->delete();
            if ($del) {
                return response()->json([
                    'message' => 'Kegiatan '.$request->name.' Berhasil Dihapus',
                    'code' => 200,
                    'data' => $del
                ]);
            }else {
                return response()->json([
                    'message' => 'Internal Server Error',
                    'code' => 500,
                ]);
            }
        }
        
    }
}
