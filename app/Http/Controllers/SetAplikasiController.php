<?php

namespace App\Http\Controllers;

use App\Models\SetAplikasi;
use Illuminate\Http\Request;
use Validator;
use File;
class SetAplikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $aplikasi = SetAplikasi::first();
        $data = [
            'aplikasi' => $aplikasi
        ];
        return view('pages.Setting.aplikasi', $data);
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
            'telp' => 'required',
            'email' => 'required',
            'logo' => 'mimes:png,jpg,jpeg|max:2048',
            // 'time' => 'required'
        ],[
            'nama.required' => 'Nama Instansi Wajib diisi',
            'telp.required' => 'Telepon Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'logo.max' => 'Logo ukuran Maksimal 2mb',
            // 'time.required' => 'Waktu Wajib diisi'
        ]);

        
        if ($validated->passes()) {
            if ($request->hasFile('logo')) {


                $delete_file = SetAplikasi::where('id', $request->id)->first();
                if ($delete_file->logo != 'no_image.png') {
                    File::delete('File/Setting/Logo/'.$delete_file->logo);
                }

                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('logo')->move(public_path('File/Setting/Logo/'), $filenameSimpan);

                $store = SetAplikasi::updateOrCreate(['id' => $request->id],
                [
                    'nama_instansi' => $request->nama,
                    'no_telp' => $request->telp,
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'logo' => $filenameSimpan,
                    // 'time' => $request->time
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Disimpan',
                    // 'data' => $upload
                ]);
            }else {
                $store = SetAplikasi::updateOrCreate(['id' => $request->id],
                [
                    'nama_instansi' => $request->nama,
                    'no_telp' => $request->telp,
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'time' => $request->time
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Disimpan',
                    // 'data' => $upload
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
     * @param  \App\Models\SetAplikasi  $setAplikasi
     * @return \Illuminate\Http\Response
     */
    public function show(SetAplikasi $setAplikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SetAplikasi  $setAplikasi
     * @return \Illuminate\Http\Response
     */
    public function edit(SetAplikasi $setAplikasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SetAplikasi  $setAplikasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SetAplikasi $setAplikasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SetAplikasi  $setAplikasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(SetAplikasi $setAplikasi)
    {
        //
    }
}
