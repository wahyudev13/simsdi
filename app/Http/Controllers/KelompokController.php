<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelompokJabatan;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('pages.Karyawan.kelompok');
    }

    public function getKelompok()
    {
        $kelompok = KelompokJabatan::orderBy('created_at','desc')->get();
        return DataTables::of($kelompok)
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
            'kode_kelompok' => 'required|unique:kelompok_jabatans',
            'nama_kelompok' => 'required',
            'index' => 'required'
        ],[
            'kode_kelompok.required' => 'Kode Kelompok Wajib diisi',
            'kode_kelompok.unique' => 'Kode Kelompok Sudah Digunakan',
            'nama_kelompok.required' => 'Nama Kelompok Wajib diisi',
            'index.required' => 'Index wajib diisi'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }else {
            KelompokJabatan::create([
                'kode_kelompok' => $request->kode_kelompok,
                'nama_kelompok' => $request->nama_kelompok,
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
        $edit_kelompok = KelompokJabatan::where('id', $request->id)->first();
        if ($edit_kelompok) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $edit_kelompok
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
            // 'kode_kelompok' => 'required|unique:kelompok_jabatans',
            'nama_kelompok' => 'required',
            'index' => 'required'
        ],[
            // 'kode_kelompok.required' => 'Kode Kelompok Wajib diisi',
            // 'kode_kelompok.unique' => 'Kode Kelompok Sudah Digunakan',
            'nama_kelompok.required' => 'Nama Kelompok Wajib diisi',
            'index.required' => 'Index wajib diisi'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }else {
            KelompokJabatan::where('id', $request->id)->update([
                // 'kode_kelompok' => $request->kode_kelompok,
                'nama_kelompok' => $request->nama_kelompok,
                'index' => $request->index
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil Diupdate'
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
        $del = KelompokJabatan::where('id', $request->id)->delete();

        if ($del) {
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
