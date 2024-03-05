<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\MasterBerkas;
use App\Models\MasaBerlakuSIP;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;


class FileSIPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getSIP(Request $request)
    {
        $getsip = FileSIP::where('file_sip.id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_sip.nama_file_sip_id', '=', 'master_berkas_pegawai.id')
        ->join('file_str','file_sip.no_reg','=','file_str.id')
        ->leftjoin('masa_berlaku_sip','file_sip.id','=','masa_berlaku_sip.sip_id')
        ->select('file_sip.id','file_sip.id_pegawai','file_sip.no_sip','file_sip.file','master_berkas_pegawai.nama_berkas',
        'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_sip.updated_at','masa_berlaku_sip.id AS id_masa_berlaku',
        'masa_berlaku_sip.tgl_ed AS tgl_ed_sip','masa_berlaku_sip.pengingat','masa_berlaku_sip.status AS status_sip')
        ->orderBy('file_sip.created_at','desc')
        ->get();

        return DataTables::of($getsip)
        ->editColumn('updated_at',function($getsip) {
            return $getsip->updated_at->format('j F Y h:i:s A');
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
            'nama_file_sip_id' => 'required',
            'no_sip' => 'required',
            'no_reg' => 'required',
            // 'tgl_ed_str' => 'required',
            // 'bikes' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_sip_id.required' => 'Nama File Wajib diisi',
            'no_sip.required' => 'Nomor SIP Wajib diisi',
            'no_reg.required' => 'Nomor STR Wajib diisi',
            // 'tgl_ed_str.required' => 'Tanggal Berkahir STR Wajib diisi',
            // 'bikes.required' => 'Bidang Kesehatan Wajib diisi',
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
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/SIP'), $filenameSimpan);
    
                $upload = FileSIP::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                    // 'tgl_ed_str' => $request->tgl_ed_str,
                    // 'bikes' => $request->bikes,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Disimpan',
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
     * @param  \App\Models\FileSIP  $fileSIP
     * @return \Illuminate\Http\Response
     */
    public function show(FileSIP $fileSIP)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileSIP  $fileSIP
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $sip_edit = FileSIP::where('id', $request->id)->first();
        if ($sip_edit) {
            return response()->json([
                'message' => 'Data SIP Ditemukan',
                'code' => 200,
                'data' => $sip_edit
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
     * @param  \App\Models\FileSIP  $fileSIP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_sip_id' => 'required',
            'no_sip' => 'required',
            'no_reg' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_sip_id.required' => 'Nama File Wajib diisi',
            'no_sip.required' => 'Nomor SIP Wajib diisi',
            'no_reg.required' => 'Nomor STR Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $sip = FileSIP::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/SIP/'.$sip->file);
                
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/SIP'), $filenameSimpan);
    
                $upload = FileSIP::where('id', $request->id)->update([
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileSIP::where('id', $request->id)->update([
                    'nama_file_sip_id' => $request->nama_file_sip_id,
                    'no_sip' => $request->no_sip,
                    'no_reg' => $request->no_reg,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'SIP Berhasil Diubah',
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
     * @param  \App\Models\FileSIP  $fileSIP
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sip = FileSIP::where('id', $request->id)->first();
        $delete = FileSIP::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/SIP/'.$sip->file);
            return response()->json([
                'message' => 'Data SIP Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function strget(Request $request) {
        $str = FileSTR::where('id_pegawai', $request->id)
        ->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'lifetime');
            $query->orWhere('status', 'proses');
        })
        ->select('file_str.id','file_str.no_reg_str')
        ->get();

        $response = array();
        foreach($str as $item){
            $response[] = array(
                "id"=>$item->id,
                "text"=>$item->no_reg_str
            );
        }

        return response()->json($response); 
    }
    // public function strget($id) {
    //     $str = FileSTR::where('id_pegawai', $id)
    //     ->where(function($query){
    //         $query->where('status', 'active');
    //         $query->orWhere('status', 'proses');
    //     })
    //     ->select('file_str.id','file_str.no_reg_str')
    //     ->get();

    //     $response = array();
    //     foreach($str as $item){
    //         $response[] = array(
    //             "id"=>$item->id,
    //             "text"=>$item->no_reg_str
    //         );
    //     }

    //     return response()->json($response); 
    // }

    // public function str_selected($idsip)  {
    //     $nostr = FileSIP::where('id',$idsip)->first();
        
    //     $str = FileSTR::where('id_pegawai', $nostr->id_pegawai)
    //     ->where(function($query){
    //         $query->where('status', 'active');
    //         $query->orWhere('status', 'proses');
    //     })
    //     ->select('file_str.id','file_str.no_reg_str')
    //     ->get();

    //     $response = array();
    //     foreach($str as $item){
    //         $response[] = array(
    //             "id"=>$item->id,
    //             "text"=>$item->no_reg_str,
    //         );
    //     }

    //     return response()->json($response); 
    // }
    public function str_selected(Request $request)  {
        $nostr = FileSIP::where('id',$request->id)->first();
        
        $str = FileSTR::where('id_pegawai', $nostr->id_pegawai)
        ->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'lifetime');
            $query->orWhere('status', 'proses');
        })
        ->select('file_str.id','file_str.no_reg_str')
        ->get();

        $response = array();
        foreach($str as $item){
            $response[] = array(
                "id"=>$item->id,
                "text"=>$item->no_reg_str,
            );
        }

        return response()->json($response); 
    }

    public function exp(Request $request) {
        $validated = Validator::make($request->all(),[
            'tgl_ed_sip' => 'required',
            'pengingat_sip' => 'required',
            
        ],[
            'tgl_ed_sip.required' => 'Tgl Masa Berlaku Wajib diisi',
            'pengingat_sip.required' => 'Tgl Pengingat Wajib diisi',
        ]);

        if ($validated->passes()) {
            $date = Carbon::today()->toDateString();
            if ($request->tgl_ed_sip != $date && $request->pengingat_sip != $date) {
                $upload = MasaBerlakuSIP::create([
                    'sip_id' => $request->sip_id_masa_berlaku,
                    'tgl_ed' => $request->tgl_ed_sip,
                    'pengingat' => $request->pengingat_sip,
                    'status' => 'active'
                   
                ]);
            }elseif ($request->tgl_ed_sip != $date && $request->pengingat_sip == $date) {
                $upload = MasaBerlakuSIP::create([
                    'sip_id' => $request->sip_id_masa_berlaku,
                    'tgl_ed' => $request->tgl_ed_sip,
                    'pengingat' => $request->pengingat_sip,
                    'status' => 'proses'
                   
                ]);
            }elseif ($request->tgl_ed_sip == $date && $request->pengingat_sip != $date) {
                $upload = MasaBerlakuSIP::create([
                    'sip_id' => $request->sip_id_masa_berlaku,
                    'tgl_ed' => $request->tgl_ed_sip,
                    'pengingat' => $request->pengingat_sip,
                    'status' => 'nonactive'
                   
                ]);
            }elseif ($request->tgl_ed_sip == $date && $request->pengingat_sip == $date) {
                $upload = MasaBerlakuSIP::create([
                    'sip_id' => $request->sip_id_masa_berlaku,
                    'tgl_ed' => $request->tgl_ed_sip,
                    'pengingat' => $request->pengingat_sip,
                    'status' => 'nonactive'
                ]);
            }

            
            return response()->json([
                'status' => 200,
                'message' => 'Masa Berlaku SIP Berhasil Disimpan',
                'data' => $upload
            ]);
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }


    public function desexp(Request $request) {
        $delete = MasaBerlakuSIP::where('id', $request->id)->delete();
        if ($delete) {
            return response()->json([
                'message' => 'Masa berlaku SIP Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function status(Request $request) {
        $upload = MasaBerlakuSIP::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Status Masa Berlaku SIP '.$request->nosip.' Berhasil Diubah',
            'data' => $upload
        ]);
    }
}
