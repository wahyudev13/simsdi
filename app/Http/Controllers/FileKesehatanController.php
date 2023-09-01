<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FileKesehatan;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;

class FileKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // protected $casts = [ 'tgl_pemeriksaan'=>'datetime'];
    public function index(Request $request)
    {
        
        $getfile = FileKesehatan::where('id_pegawai', $request->id_pegawai)
        ->join('master_berkas_pegawai', 'file_kesehatan.nama_file_kesehatan_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_kesehatan.id','file_kesehatan.nama_pemeriksaan',
        'file_kesehatan.tgl_pemeriksaan','file_kesehatan.updated_at','file_kesehatan.file')
        ->get();

        return DataTables::of($getfile)
        // ->editColumn('tgl_pemeriksaan',function($getfile) {
        //     return $getfile->tgl_pemeriksaan->format('Y-m-d');
        // })
        ->editColumn('updated_at',function($getfile) {
            return $getfile->updated_at->format('j F Y h:i:s A');
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
            'id_pegawai' => 'required',
            'nama_file' => 'required',
            'nama_pemeriksaan' => 'required',
            'tgl_pemeriksaan' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            'nama_file.required' => 'Nama File Wajib Diisi',
            'nama_pemeriksaan.required' => 'Nama Pemeriksaan Wajib Diisi',
            'tgl_pemeriksaan.required' => 'Tanggal Pemeriksaan Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Kesehatan/'), $filenameSimpan);
    
                $upload = FileKesehatan::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_kesehatan_id' => $request->nama_file,
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Kesehatan ('.$request->nama_pemeriksaan.') Berhasil Disimpan',
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
     * @param  \App\Models\FileKesehatanAwal  $fileKesehatanAwal
     * @return \Illuminate\Http\Response
     */
    public function show(FileKesehatanAwal $fileKesehatanAwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileKesehatanAwal  $fileKesehatanAwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dokumen = FileKesehatan::where('id', $request->id)->first();
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
     * @param  \App\Models\FileKesehatanAwal  $fileKesehatanAwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'nama_file' => 'required',
            'nama_pemeriksaan' => 'required',
            'tgl_pemeriksaan' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            'nama_file.required' => 'Nama File Wajib Diisi',
            'nama_pemeriksaan.required' => 'Nama Pemeriksaan Wajib Diisi',
            'tgl_pemeriksaan.required' => 'Tanggal Pemeriksaan Wajib Diisi',
            // 'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileKesehatan::where('id', $request->id)->first();
                File::delete('File/Pegawai/Kesehatan/Kesehatan/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Kesehatan/'), $filenameSimpan);
    
                $upload = FileKesehatan::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_kesehatan_id' => $request->nama_file,
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Kesehatan ('.$request->nama_pemeriksaan.') Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileKesehatan::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_kesehatan_id' => $request->nama_file,
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
                  
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Kesehatan ('.$request->nama_pemeriksaan.') Berhasil Diubah',
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
     * @param  \App\Models\FileKesehatanAwal  $fileKesehatanAwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_file = FileKesehatan::where('id', $request->id)->first();
        $delete = FileKesehatan::where('id', $request->id)->delete();

        if ($delete) {
            File::delete('File/Pegawai/Kesehatan/Kesehatan/'.$delete_file->file);
            return response()->json([
                'message' => 'Data Berhasil Dihapus',
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
