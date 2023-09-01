<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenjangJabatan;
use Validator;
use Yajra\DataTables\Facades\DataTables;


class JenjangJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.Karyawan.jenjang');
    }
    public function getJenjang()
    {
        $devisi = JenjangJabatan::orderBy('created_at','desc')->get();
        return DataTables::of($devisi)
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
            'kode_jenjang' => 'required|unique:jenjang_jabatans',
            'nama_jenjang' => 'required',
            'tunjangan' => 'required',
            'index' => 'required'
        ],[
            'kode_jenjang.required' => 'Kode Jenjang Wajib diisi',
            'kode_jenjang.unique' => 'Kode Jenjang Sudah Digunakan',
            'nama_jenjang.required' => 'Nama Jenjang Wajib diisi',
            'tunjangan.required' => 'Tunjangan Wajib diisi',
            'index.required' => 'Index wajib diisi'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }else {
            JenjangJabatan::create([
                'kode_jenjang' => $request->kode_jenjang,
                'nama_jenjang' => $request->nama_jenjang,
                'tunjangan' => $request->tunjangan,
                'index' => $request->index
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil Disimpan'
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
        $edit_jenjang = JenjangJabatan::where('id', $request->id)->first();
        if ($edit_jenjang) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $edit_jenjang
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
            'kode_jenjang' => 'required',
            'nama_jenjang' => 'required',
            'tunjangan' => 'required',
            'index' => 'required'
        ],[
            'kode_jenjang.required' => 'Kode Jenjang Wajib diisi',
            'nama_jenjang.required' => 'Nama Jenjang Wajib diisi',
            'tunjangan.required' => 'Tunjangan Wajib diisi',
            'index.required' => 'Index wajib diisi'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }else {
            JenjangJabatan::where('id',$request->id)->update([
                'kode_jenjang' => $request->kode_jenjang,
                'nama_jenjang' => $request->nama_jenjang,
                'tunjangan' => $request->tunjangan,
                'index' => $request->index
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diubah'
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
        $delete = JenjangJabatan::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json([
                'message' => 'Data Berhasil Dihapus',
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
