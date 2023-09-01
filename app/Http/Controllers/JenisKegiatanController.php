<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\JenisKegiatan;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.Diklat.page-jenis-kegiatan');
    }

    public function get() {
        $jenis = JenisKegiatan::get();

        return DataTables::of($jenis)
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
            'nama' => 'required',
            'ket' => 'required'
        ],[
            'nama.required' => 'Nama Jenis Kegiatan Wajib Diisi',
            'ket.required' => 'Keterangan Jenis Kegiatan Wajib Diisi',
        ]);

        if ($validated->passes()) {
          
            $store_jenis = JenisKegiatan::create([
                'nama' => $request->nama,
                'keterangan' => $request->ket,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Jenis Kegiatan ('.$request->nama.') Berhasil Disimpan',
                'data' => $store_jenis
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
        $edit = JenisKegiatan::where('id', $request->id)->first();
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
            'nama' => 'required',
            'ket' => 'required'
        ],[
            'nama.required' => 'Nama Jenis Kegiatan Wajib Diisi',
            'ket.required' => 'Keterangan Jenis Kegiatan Wajib Diisi',
        ]);

        if ($validated->passes()) {
          
            $update_jenis = JenisKegiatan::where('id',$request->id)->update([
                'nama' => $request->nama,
                'keterangan' => $request->ket,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Jenis Kegiatan ('.$request->nama.') Berhasil Diubah',
                'data' => $update_jenis
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
        $kegiatan = Kegiatan::where('jenis_kegiatans_id',$request->id)->get();
        $count = $kegiatan->count();
        if ($count > 0) {
            return response()->json([
                'message' => 'Data '.$request->name.' Gagal Dihapus, Data Masih Digunakan',
                'status' => 401,
            ]);
        }else {
            $del = JenisKegiatan::where('id',$request->id)->delete();
            if ($del) {
                return response()->json([
                    'message' => 'Data '.$request->name.' Berhasil Dihapus',
                    'status' => 200,
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
