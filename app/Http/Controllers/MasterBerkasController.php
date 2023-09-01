<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Devisi;
use App\Models\Pegawai;
use App\Models\MasterBerkas;
use Yajra\DataTables\Facades\DataTables;

class MasterBerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.Master.master-berkas');
    }

    public function getMaster()
    {
        $berkas = MasterBerkas::get();
        return DataTables::of($berkas)
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
            'kode' => 'required|unique:master_berkas_pegawai',
            'kategori' => 'required',
            'nama_berkas' => 'required',
        ],[
            'kode.required' => 'Kode Master Berkas Wajib diisi',
            'kode.unique' => 'Kode Sudah Digunakan',
            'kategori.required' => 'Kategori Master Berkas Wajib diisi',
            'nama_berkas.required' => 'Nama Berkas Wajib diisi'
        ]);

        if ($validated->passes()) {
                $store = MasterBerkas::create([
                    'kode' => $request->kode,
                    'kategori' => $request->kategori,
                    'nama_berkas' => $request->nama_berkas,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Master Berkas Berhasil Disimpan',
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
    public function show(Request $request)
    {
        $show = MasterBerkas::where('id', $request->id)->first();
        if ($show) {
            return response()->json([
                'message' => 'Data Ditemukan',
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
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'kode' => 'required',
            'kategori' => 'required',
            'nama_berkas' => 'required',
        ],[
            'kode.required' => 'Kode Master Berkas Wajib diisi',
            'kode.unique' => 'Kode Sudah Digunakan',
            'kategori.required' => 'Kategori Master Berkas Wajib diisi',
            'nama_berkas.required' => 'Nama Berkas Wajib diisi'
        ]);

        if ($validated->passes()) {
                $store = MasterBerkas::where('id', $request->id)->update([
                    'kode' => $request->kode,
                    'kategori' => $request->kategori,
                    'nama_berkas' => $request->nama_berkas,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Master Berkas Berhasil Diupdate',
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
        $del = MasterBerkas::where('id', $request->id)->delete();
        if ($del) {
            return response()->json([
                'message' => 'Data Berhasil Dihapus',
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'error' => 'Gagal Hapus data, data Masih digunakan',
                'status' => 500,
            ]);
        }
    }
}
