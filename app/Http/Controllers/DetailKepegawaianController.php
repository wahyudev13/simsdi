<?php

namespace App\Http\Controllers;

use App\Models\DetailKepegawaian;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class DetailKepegawaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $master_berkas_identitas = MasterBerkas::where('kategori','identitas')->get();
        $pegawai = Pegawai::where('id', $id)
        ->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->join('stts_kerja','pegawai.stts_kerja','=','stts_kerja.stts')
        ->select('pegawai.id','pegawai.nik','pegawai.nama','pegawai.jk','pegawai.jbtn','departemen.nama AS nm_dep','pegawai.stts_aktif',
        'pegawai.tmp_lahir','pegawai.tgl_lahir','pegawai.alamat','pegawai.kota','pegawai.mulai_kerja','pegawai.no_ktp','stts_kerja.ktg',
        'pegawai.mulai_kontrak','pegawai.pendidikan')
        ->first();
        $data =[
            'pegawai' => $pegawai,
            'master_berkas_identitas' => $master_berkas_identitas,
        ];
        return view('pages.Karyawan.detail-kepegawaian',$data);
    }
   
    public function rekap_presensi_admin(Request $request) {
      
        if(!empty($request->from_date)) {
            $rekap_presensi2 = Pegawai::where('pegawai.id', $request->id_pegawai)->whereBetween('rekap_presensi.jam_datang', [$request->from_date, $request->to_date])
            ->join('rekap_presensi','pegawai.id','=','rekap_presensi.id')
            ->join('departemen','pegawai.departemen','=','departemen.dep_id')
            ->select('pegawai.id','pegawai.nik','pegawai.nama','rekap_presensi.shift','rekap_presensi.jam_datang',
            'rekap_presensi.jam_pulang','rekap_presensi.status','rekap_presensi.keterlambatan','rekap_presensi.durasi',
            'rekap_presensi.keterangan')
            ->get();
        }else {
            $rekap_presensi2 = Pegawai::where('pegawai.id', $request->id_pegawai)
            ->join('rekap_presensi','pegawai.id','=','rekap_presensi.id')
            ->join('departemen','pegawai.departemen','=','departemen.dep_id')
            ->select('pegawai.id','pegawai.nik','pegawai.nama','rekap_presensi.shift','rekap_presensi.jam_datang',
            'rekap_presensi.jam_pulang','rekap_presensi.status','rekap_presensi.keterlambatan','rekap_presensi.durasi',
            'rekap_presensi.keterangan')
            ->get();
        }
        return DataTables::of($rekap_presensi2)
        ->addIndexColumn()
        ->make(true);
    }

   
}
