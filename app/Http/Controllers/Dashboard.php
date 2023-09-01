<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Kegiatan;
use App\Models\MapingNorm;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\FileRiwayatKerja;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileKesehatan;
use App\Models\FileVaksin;
use App\Models\PenilaianMCU;
use App\Models\AbsenDiklat;
use App\Models\FileSertifPelatihan;
use Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $database = config('database.connections.mysql.database');
        $database_2 = config('database.connections.mysql2.database');
        
        $auth = Auth::user()->id_pegawai;
        $pegawai = Pegawai::where('id', $auth)->first();

        $count_pegawai = Pegawai::whereNotIn('stts_aktif',['keluar'])->count();
        $count_kegiatan = Kegiatan::count();
        $count_maping = MapingNorm::count();

        
        $count_str_admin = FileSTR::where('status','nonactive')->orWhere('status','proses')
        ->join("$database_2.pegawai as tbsik_pegawai",'file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.id AS id_pegawai','tbsik_pegawai.nama','tbsik_pegawai.nik','tbsik_pegawai.jbtn','master_berkas_pegawai.nama_berkas','file_str.id_pegawai',
        'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_str.status','file_str.id')
        ->count();

        $count_kontrak = FileRiwayatKerja::where('status','nonactive')->orWhere('status','proses')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_riwayat_pekerjaan.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_riwayat_pekerjaan.id_pegawai','tbsik_pegawai.nik',
        'file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.tgl_ed','tbsik_pegawai.jbtn','file_riwayat_pekerjaan.status')
        ->count();

        $count_ijazah = FileIjazah::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_ijazah.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->select('file_ijazah.id','master_berkas_pegawai.nama_berkas','file_ijazah.nomor','file_ijazah.asal',
        'file_ijazah.thn_lulus','file_ijazah.file','file_ijazah.updated_at')
        ->count();

        $count_trans = FileTranskrip::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_transkrip.nama_file_trans_id', '=', 'master_berkas_pegawai.id')
        ->select('file_transkrip.id','file_transkrip.nomor_transkrip','file_transkrip.file','master_berkas_pegawai.nama_berkas',
        'file_transkrip.updated_at')
        ->count();

        $count_str = FileSTR::where('id_pegawai',$auth)
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('file_str.id','file_str.no_reg_str','file_str.kompetensi','file_str.file','file_str.tgl_ed',
        'file_str.pengingat','master_berkas_pegawai.nama_berkas','file_str.updated_at','file_str.status')
        ->count();

        $count_sip = FileSIP::where('file_sip.id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_sip.nama_file_sip_id', '=', 'master_berkas_pegawai.id')
        ->join('file_str','file_sip.no_reg','=','file_str.id')
        ->select('file_sip.id','file_sip.id_pegawai','file_sip.no_sip','file_sip.file','master_berkas_pegawai.nama_berkas',
        'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_sip.updated_at')
        ->count();

        $count_riwayat = FileRiwayatKerja::where('file_riwayat_pekerjaan.id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('file_riwayat_pekerjaan.id','file_riwayat_pekerjaan.id_pegawai','file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.file','master_berkas_pegawai.nama_berkas',
        'file_riwayat_pekerjaan.tgl_ed','file_riwayat_pekerjaan.pengingat','file_riwayat_pekerjaan.updated_at','file_riwayat_pekerjaan.status',
        )
        ->count();

        $count_kes = FileKesehatan::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_kesehatan.nama_file_kesehatan_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_kesehatan.id','file_kesehatan.nama_pemeriksaan',
        'file_kesehatan.tgl_pemeriksaan','file_kesehatan.updated_at','file_kesehatan.file')
        ->count();

        $count_vaksin = FileVaksin::where('id_pegawai', $auth)
        // ->join('master_berkas_pegawai', 'file_vaksin.nama_file_kesehatan_id', '=', 'master_berkas_pegawai.id')
        ->select('file_vaksin.id','file_vaksin.dosis','file_vaksin.jenis_vaksin',
        'file_vaksin.tempat_vaksin','file_vaksin.tgl_vaksin','file_vaksin.file')
        ->count();

        $count_mcu = PenilaianMCU::where('mapingrm.id_pegawai',$auth)
        ->join('reg_periksa','penilaian_mcu.no_rawat','=','reg_periksa.no_rawat')
        ->join('dokter','penilaian_mcu.kd_dokter','=','dokter.kd_dokter')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->leftjoin( "$database.maping_norm_simrs as mapingrm",'pasien.no_rkm_medis','=','mapingrm.no_rkm_medis')
        // ->select('reg_periksa.no_rkm_medis','mapingrm.id_pegawai')
        ->count();

        $count_absensi_iht = AbsenDiklat::where('id_pegawai',$auth)
        ->join("$database_2.pegawai as pegawai",'absensi_diklat.id_pegawai','=','pegawai.id')//join database simrs
        ->join("$database_2.departemen as departemen",'pegawai.departemen','=','departemen.dep_id')
        ->join('kegiatan','absensi_diklat.kegiatan_id','=','kegiatan.id')
        ->select('absensi_diklat.id','pegawai.id AS id_pegawai','pegawai.nik','pegawai.nama AS nama_pegawai','kegiatan.nama AS nama_kegiatan','departemen.nama AS nama_dep',
        'absensi_diklat.masuk_at','absensi_diklat.selesai_at','absensi_diklat.total_waktu','kegiatan.tempat')
        ->count();

        $count_sertif = FileSertifPelatihan::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'sertif_pelatihan.berkas_id', '=', 'master_berkas_pegawai.id')
        ->select('sertif_pelatihan.id','sertif_pelatihan.berkas_id','sertif_pelatihan.id_pegawai','sertif_pelatihan.nm_kegiatan','sertif_pelatihan.tgl_kegiatan',
        'sertif_pelatihan.tmp_kegiatan','sertif_pelatihan.penyelenggara','sertif_pelatihan.file','master_berkas_pegawai.nama_berkas')
        ->count();

        $chart = Pegawai::whereNotIn('pegawai.stts_aktif',['keluar'])->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->select(DB::raw('count(*) as dep_count, departemen.nama'))
        ->groupBy('departemen.nama')
        ->get();

       
        foreach ($chart as $value) {
           $chart_count[] = $value->dep_count;
        }
        $collection =  collect($chart_count);
        $max = $collection->max();

        // dd($max);

        $data =[
            'pegawai' => $pegawai,
            'count_pegawai' => $count_pegawai,
            'count_kegiatan' => $count_kegiatan,
            'count_maping' => $count_maping,
            'count_str_admin' => $count_str_admin,
            'count_kontrak' => $count_kontrak,
            'count_ijazah' => $count_ijazah,
            'count_trans' => $count_trans,
            'count_str' => $count_str,
            'count_sip' => $count_sip,
            'count_riwayat' => $count_riwayat,
            'count_kes' => $count_kes,
            'count_vaksin' => $count_vaksin,
            'count_mcu' => $count_mcu,
            'count_absensi_iht' => $count_absensi_iht,
            'count_sertif' => $count_sertif,
            'chart_pegawai' => $chart,
            'chart_value_max' => $max

        ];

        return view('pages.Dashboard.dashboard',$data);
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
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
