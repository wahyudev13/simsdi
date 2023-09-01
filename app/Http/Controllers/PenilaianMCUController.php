<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegPeriksa;
use App\Models\SetAplikasi;
use App\Models\PeriksaLab;
use App\Models\DetailPeriksaLab;
use App\Models\SaranKesanLab;
use App\Models\PenilaianMCU;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianMCUController extends Controller
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

    public function get(Request $request) {
         $database = config('database.connections.mysql.database');

        $get = PenilaianMCU::where('mapingrm.id_pegawai',$request->id_pegawai)
        ->join('reg_periksa','penilaian_mcu.no_rawat','=','reg_periksa.no_rawat')
        ->join('dokter','penilaian_mcu.kd_dokter','=','dokter.kd_dokter')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->leftjoin( "$database.maping_norm_simrs as mapingrm",'pasien.no_rkm_medis','=','mapingrm.no_rkm_medis')
        ->orderBy('penilaian_mcu.tanggal','desc')
        // ->select('reg_periksa.no_rkm_medis','mapingrm.id_pegawai')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
    }


    public function periksalab(Request $request) {
         $database = config('database.connections.mysql.database');

        $periksalab = PeriksaLab::where('periksa_lab.kategori','PK')->where('periksa_lab.no_rawat',$request->no_rawat)
        ->join('reg_periksa','periksa_lab.no_rawat','=','reg_periksa.no_rawat')
        ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->join('petugas','periksa_lab.nip','=','petugas.nip')
        ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
        ->join('dokter as dokterrujuk','periksa_lab.dokter_perujuk','=','dokterrujuk.kd_dokter')
        ->join('dokter as dokterpj','periksa_lab.kd_dokter','=','dokterpj.kd_dokter')
        ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
        ->leftjoin( "$database.maping_norm_simrs as mapingrm",'pasien.no_rkm_medis','=','mapingrm.no_rkm_medis')
        ->select('periksa_lab.no_rawat','reg_periksa.no_rkm_medis','reg_periksa.tgl_registrasi','reg_periksa.kd_poli','reg_periksa.no_reg',
        'pasien.nm_pasien','petugas.nama','periksa_lab.tgl_periksa','periksa_lab.jam',
        'periksa_lab.dokter_perujuk','periksa_lab.kd_dokter','dokterrujuk.nm_dokter','dokterpj.nm_dokter as dokter_pj','penjab.png_jawab',
        'jns_perawatan_lab.nm_perawatan','poliklinik.nm_poli','periksa_lab.kd_jenis_prw')
        ->get();

        return DataTables::of($periksalab)
        ->addIndexColumn()
        ->make(true);
    }

    // public function report_lab(Request $request) {
    //      $database = config('database.connections.mysql.database');

    //     $aplikasi = SetAplikasi::first();
       
    //     $pasien = PeriksaLab::where('periksa_lab.kategori','PK')
    //     ->where('periksa_lab.no_rawat',$request->no_rawat)
    //     ->where('periksa_lab.tgl_periksa', $request->tgl_periksa)
    //     ->where('periksa_lab.jam', $request->jam)
    //     ->join('reg_periksa','periksa_lab.no_rawat','=','reg_periksa.no_rawat')
    //     ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
    //     ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    //     ->join('kelurahan','pasien.kd_kel','=','kelurahan.kd_kel')
    //     ->join('kecamatan','pasien.kd_kec','=','kecamatan.kd_kec')
    //     ->join('kabupaten','pasien.kd_kab','=','kabupaten.kd_kab')
    //     ->join('petugas','periksa_lab.nip','=','petugas.nip')
    //     ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
    //     ->join('dokter as dokterrujuk','periksa_lab.dokter_perujuk','=','dokterrujuk.kd_dokter')
    //     ->join('dokter as dokterpj','periksa_lab.kd_dokter','=','dokterpj.kd_dokter')
    //     ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
    //     ->leftjoin( "$database.maping_norm_simrs as mapingrm",'pasien.no_rkm_medis','=','mapingrm.no_rkm_medis')
    //     ->select('periksa_lab.no_rawat','reg_periksa.no_rkm_medis','pasien.nm_pasien','petugas.nama','periksa_lab.tgl_periksa','periksa_lab.jam',
    //     'periksa_lab.dokter_perujuk','periksa_lab.kd_dokter','dokterrujuk.nm_dokter','dokterpj.nm_dokter as dokter_pj','penjab.png_jawab',
    //     'jns_perawatan_lab.nm_perawatan','poliklinik.nm_poli','periksa_lab.kd_jenis_prw','pasien.jk','pasien.umur','pasien.alamat',
    //     'kelurahan.nm_kel','kecamatan.nm_kec','kabupaten.nm_kab')
    //     ->first();

    //     $periksalab = PeriksaLab::where('periksa_lab.kategori','PK')
    //     ->where('periksa_lab.kd_jenis_prw', $request->kd_jenis_prw)
    //     ->where('periksa_lab.no_rawat',$request->no_rawat)
    //     ->where('periksa_lab.tgl_periksa', $request->tgl_periksa)
    //     ->where('periksa_lab.jam', $request->jam)
    //     ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
    //     ->select('jns_perawatan_lab.kd_jenis_prw','jns_perawatan_lab.nm_perawatan','periksa_lab.biaya')
    //     ->first();

    //     $detail_periksa_lab = DetailPeriksaLab::where('detail_periksa_lab.no_rawat',$request->no_rawat)
    //     ->where('detail_periksa_lab.kd_jenis_prw', $request->kd_jenis_prw)
    //     ->where('detail_periksa_lab.tgl_periksa', $request->tgl_periksa)
    //     ->join('template_laboratorium','detail_periksa_lab.id_template','=','template_laboratorium.id_template')
    //     ->select('template_laboratorium.Pemeriksaan', 'detail_periksa_lab.nilai','template_laboratorium.satuan','detail_periksa_lab.nilai_rujukan','detail_periksa_lab.biaya_item',
    //     'detail_periksa_lab.keterangan','detail_periksa_lab.kd_jenis_prw')
    //     ->orderBy('template_laboratorium.urut')
    //     ->get();

    //     $saran_kesan = SaranKesanLab::
    //     where('saran_kesan_lab.no_rawat',$request->no_rawat)
    //     ->where('saran_kesan_lab.tgl_periksa', $request->tgl_periksa)
    //     ->where('saran_kesan_lab.jam', $request->jam)
    //     ->get();

    //     // return response()->json([
    //     //     'message' => 'Data Ditemukan',
    //     //     'code' => 200,
    //     //     'data' => $pasien
    //     // ]);

    //     $data = [
    //         'pasien' => $pasien,
    //         'periksalab' => $periksalab,
    //         'detail_periksa_lab' => $detail_periksa_lab,
    //         'saran_kesan' => $saran_kesan,
    //         'aplikasi' => $aplikasi
    //     ];

    //     // return view('pdf.report-lab');
    //     $pdf = Pdf::loadView('pdf.report-lab', $data);
    //     $path = public_path('File/Report/laboratorium/');
    //     $fileName =  time().'.'.'pdf' ;
    //     $pdf->save($path.'/'.$fileName);

    //     $pdf2 = public_path('File/Report/laboratorium/'.$fileName);
    //     return response()->download($pdf2);
    // }

    public function report_lab_v2($norm,$kdpoli,$tglreg,$noreg,$kdprw) {
        $database = config('database.connections.mysql.database');
        $aplikasi = SetAplikasi::first();

        $pasien = RegPeriksa::where('reg_periksa.tgl_registrasi',$tglreg)
        ->where('reg_periksa.no_rkm_medis',$norm)
        ->where('reg_periksa.kd_poli',$kdpoli)
        ->where('reg_periksa.no_reg',$noreg)
        ->where('periksa_lab.kd_jenis_prw',$kdprw)
        ->join('periksa_lab','reg_periksa.no_rawat','=','periksa_lab.no_rawat')
        ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->join('kelurahan','pasien.kd_kel','=','kelurahan.kd_kel')
        ->join('kecamatan','pasien.kd_kec','=','kecamatan.kd_kec')
        ->join('kabupaten','pasien.kd_kab','=','kabupaten.kd_kab')
        ->join('petugas','periksa_lab.nip','=','petugas.nip')
        ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
        ->join('dokter as dokterrujuk','periksa_lab.dokter_perujuk','=','dokterrujuk.kd_dokter')
        ->join('dokter as dokterpj','periksa_lab.kd_dokter','=','dokterpj.kd_dokter')
        ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
        ->leftjoin( "$database.maping_norm_simrs as mapingrm",'pasien.no_rkm_medis','=','mapingrm.no_rkm_medis')
        ->select('periksa_lab.no_rawat','reg_periksa.no_rkm_medis','pasien.nm_pasien','petugas.nama','periksa_lab.tgl_periksa','periksa_lab.jam',
        'periksa_lab.dokter_perujuk','periksa_lab.kd_dokter','dokterrujuk.nm_dokter','dokterpj.nm_dokter as dokter_pj','penjab.png_jawab',
        'jns_perawatan_lab.nm_perawatan','poliklinik.nm_poli','periksa_lab.kd_jenis_prw','pasien.jk','pasien.umur','pasien.alamat',
        'kelurahan.nm_kel','kecamatan.nm_kec','kabupaten.nm_kab')
        ->first();
      
        $periksalab = PeriksaLab::where('periksa_lab.kategori','PK')
        ->where('periksa_lab.kd_jenis_prw', $pasien->kd_jenis_prw)
        ->where('periksa_lab.no_rawat',$pasien->no_rawat)
        ->where('periksa_lab.tgl_periksa', $pasien->tgl_periksa)
        ->where('periksa_lab.jam', $pasien->jam)
        ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
        ->select('jns_perawatan_lab.kd_jenis_prw','jns_perawatan_lab.nm_perawatan','periksa_lab.biaya')
        ->first();

        $detail_periksa_lab = DetailPeriksaLab::where('detail_periksa_lab.no_rawat',$pasien->no_rawat)
        ->where('detail_periksa_lab.kd_jenis_prw', $pasien->kd_jenis_prw)
        ->where('detail_periksa_lab.tgl_periksa', $pasien->tgl_periksa)
        ->join('template_laboratorium','detail_periksa_lab.id_template','=','template_laboratorium.id_template')
        ->select('template_laboratorium.Pemeriksaan', 'detail_periksa_lab.nilai','template_laboratorium.satuan','detail_periksa_lab.nilai_rujukan','detail_periksa_lab.biaya_item',
        'detail_periksa_lab.keterangan','detail_periksa_lab.kd_jenis_prw')
        ->orderBy('template_laboratorium.urut')
        ->get();

        $saran_kesan = SaranKesanLab::
        where('saran_kesan_lab.no_rawat',$pasien->no_rawat)
        ->where('saran_kesan_lab.tgl_periksa', $pasien->tgl_periksa)
        ->where('saran_kesan_lab.jam', $pasien->jam)
        ->get();

        $data = [
            'pasien' => $pasien,
            'periksalab' => $periksalab,
            'detail_periksa_lab' => $detail_periksa_lab,
            'saran_kesan' => $saran_kesan,
            'aplikasi' => $aplikasi
        ];

        //    return view('pdf.report-lab',$data);
        $pdf = Pdf::loadView('pdf.report-lab', $data);
        return $pdf->stream();
    }

    // public function report_mcu(Request $request) {
    //     // $database = config('database.connections.mysql.database');
    //     $aplikasi = SetAplikasi::first();

    //     $periksa_mcu = RegPeriksa::where('reg_periksa.no_rawat',$request->no_rawat)
    //     ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    //     ->join('penilaian_mcu','reg_periksa.no_rawat','=','penilaian_mcu.no_rawat')
    //     ->join('kelurahan','pasien.kd_kel','=','kelurahan.kd_kel')
    //     ->join('kecamatan','pasien.kd_kec','=','kecamatan.kd_kec')
    //     ->join('kabupaten','pasien.kd_kab','=','kabupaten.kd_kab')
    //     ->join('propinsi','pasien.kd_prop','=','propinsi.kd_prop')
    //     ->join('dokter','penilaian_mcu.kd_dokter','=','dokter.kd_dokter')
    //     ->select('reg_periksa.no_rawat','pasien.no_rkm_medis','pasien.nm_pasien','pasien.jk','pasien.tgl_lahir','pasien.stts_nikah','penilaian_mcu.tanggal',
    //     'pasien.alamat','kelurahan.nm_kel','kecamatan.nm_kec','kabupaten.nm_kab','propinsi.nm_prop',
    //     'penilaian_mcu.informasi','penilaian_mcu.rps','penilaian_mcu.rpk','penilaian_mcu.rpd','penilaian_mcu.alergi','penilaian_mcu.keadaan','penilaian_mcu.kesadaran','penilaian_mcu.td',
    //     'penilaian_mcu.nadi','penilaian_mcu.rr','penilaian_mcu.tb','penilaian_mcu.bb','penilaian_mcu.suhu','penilaian_mcu.submandibula','penilaian_mcu.axilla','penilaian_mcu.supraklavikula',
    //     'penilaian_mcu.leher','penilaian_mcu.inguinal','penilaian_mcu.oedema','penilaian_mcu.sinus_frontalis','penilaian_mcu.sinus_maxilaris','penilaian_mcu.palpebra','penilaian_mcu.sklera',
    //     'penilaian_mcu.cornea','penilaian_mcu.buta_warna','penilaian_mcu.konjungtiva','penilaian_mcu.lensa','penilaian_mcu.pupil','penilaian_mcu.lubang_telinga','penilaian_mcu.daun_telinga',
    //     'penilaian_mcu.selaput_pendengaran','penilaian_mcu.proc_mastoideus','penilaian_mcu.septum_nasi','penilaian_mcu.lubang_hidung','penilaian_mcu.bibir','penilaian_mcu.caries',
    //    'penilaian_mcu.lidah','penilaian_mcu.faring','penilaian_mcu.tonsil','penilaian_mcu.kelenjar_limfe','penilaian_mcu.kelenjar_gondok','penilaian_mcu.gerakan_dada',
    //     'penilaian_mcu.vocal_femitus','penilaian_mcu.perkusi_dada','penilaian_mcu.bunyi_napas','penilaian_mcu.bunyi_tambahan','penilaian_mcu.ictus_cordis','penilaian_mcu.bunyi_jantung',
    //    'penilaian_mcu.batas','penilaian_mcu.inspeksi','penilaian_mcu.palpasi','penilaian_mcu.hepar','penilaian_mcu.perkusi_abdomen','penilaian_mcu.auskultasi','penilaian_mcu.limpa',
    //     'penilaian_mcu.costovertebral','penilaian_mcu.kondisi_kulit','penilaian_mcu.ekstrimitas_atas','penilaian_mcu.ekstrimitas_atas_ket','penilaian_mcu.ekstrimitas_bawah',
    //     'penilaian_mcu.ekstrimitas_bawah_ket','penilaian_mcu.laborat','penilaian_mcu.radiologi','penilaian_mcu.ekg','penilaian_mcu.spirometri','penilaian_mcu.audiometri',
    //    'penilaian_mcu.treadmill','penilaian_mcu.lainlain','penilaian_mcu.merokok','penilaian_mcu.alkohol','penilaian_mcu.kesimpulan','penilaian_mcu.anjuran','penilaian_mcu.kd_dokter','dokter.nm_dokter')
    //     ->first();

    //     // return response()->json([
    //     //     'message' => 'Data Ditemukan',
    //     //     'code' => 200,
    //     //     'data' => $periksa_mcu
    //     // ]);

    //     $data = [
    //         'periksa_mcu' => $periksa_mcu,
    //         'aplikasi' => $aplikasi
           
    //     ];

    //     // return view('pdf.report-lab');
    //     $pdf = Pdf::loadView('pdf.report-mcu', $data);
    //     $path = public_path('File/Report/MCU/');
    //     $fileName =  time().'.'.'pdf' ;
    //     $pdf->save($path.'/'.$fileName);

    //     $pdf2 = public_path('File/Report/MCU/'.$fileName);
    //     return response()->download($pdf2);

    // }

    public function report_mcu_v2($tglreg, $norm,$kdpoli,$noreg) {
        // $database = config('database.connections.mysql.database');
        $aplikasi = SetAplikasi::first();

        $periksa_mcu = RegPeriksa::where('reg_periksa.tgl_registrasi',$tglreg)
        ->where('reg_periksa.no_rkm_medis',$norm)
        ->where('reg_periksa.kd_poli',$kdpoli)
        ->where('reg_periksa.no_reg',$noreg)
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->join('penilaian_mcu','reg_periksa.no_rawat','=','penilaian_mcu.no_rawat')
        ->join('kelurahan','pasien.kd_kel','=','kelurahan.kd_kel')
        ->join('kecamatan','pasien.kd_kec','=','kecamatan.kd_kec')
        ->join('kabupaten','pasien.kd_kab','=','kabupaten.kd_kab')
        ->join('propinsi','pasien.kd_prop','=','propinsi.kd_prop')
        ->join('dokter','penilaian_mcu.kd_dokter','=','dokter.kd_dokter')
        ->select('reg_periksa.no_rawat','pasien.no_rkm_medis','pasien.nm_pasien','pasien.jk','pasien.tgl_lahir','pasien.stts_nikah','penilaian_mcu.tanggal',
        'pasien.alamat','kelurahan.nm_kel','kecamatan.nm_kec','kabupaten.nm_kab','propinsi.nm_prop',
        'penilaian_mcu.informasi','penilaian_mcu.rps','penilaian_mcu.rpk','penilaian_mcu.rpd','penilaian_mcu.alergi','penilaian_mcu.keadaan','penilaian_mcu.kesadaran','penilaian_mcu.td',
        'penilaian_mcu.nadi','penilaian_mcu.rr','penilaian_mcu.tb','penilaian_mcu.bb','penilaian_mcu.suhu','penilaian_mcu.submandibula','penilaian_mcu.axilla','penilaian_mcu.supraklavikula',
        'penilaian_mcu.leher','penilaian_mcu.inguinal','penilaian_mcu.oedema','penilaian_mcu.sinus_frontalis','penilaian_mcu.sinus_maxilaris','penilaian_mcu.palpebra','penilaian_mcu.sklera',
        'penilaian_mcu.cornea','penilaian_mcu.buta_warna','penilaian_mcu.konjungtiva','penilaian_mcu.lensa','penilaian_mcu.pupil','penilaian_mcu.lubang_telinga','penilaian_mcu.daun_telinga',
        'penilaian_mcu.selaput_pendengaran','penilaian_mcu.proc_mastoideus','penilaian_mcu.septum_nasi','penilaian_mcu.lubang_hidung','penilaian_mcu.bibir','penilaian_mcu.caries',
       'penilaian_mcu.lidah','penilaian_mcu.faring','penilaian_mcu.tonsil','penilaian_mcu.kelenjar_limfe','penilaian_mcu.kelenjar_gondok','penilaian_mcu.gerakan_dada',
        'penilaian_mcu.vocal_femitus','penilaian_mcu.perkusi_dada','penilaian_mcu.bunyi_napas','penilaian_mcu.bunyi_tambahan','penilaian_mcu.ictus_cordis','penilaian_mcu.bunyi_jantung',
       'penilaian_mcu.batas','penilaian_mcu.inspeksi','penilaian_mcu.palpasi','penilaian_mcu.hepar','penilaian_mcu.perkusi_abdomen','penilaian_mcu.auskultasi','penilaian_mcu.limpa',
        'penilaian_mcu.costovertebral','penilaian_mcu.kondisi_kulit','penilaian_mcu.ekstrimitas_atas','penilaian_mcu.ekstrimitas_atas_ket','penilaian_mcu.ekstrimitas_bawah',
        'penilaian_mcu.ekstrimitas_bawah_ket','penilaian_mcu.laborat','penilaian_mcu.radiologi','penilaian_mcu.ekg','penilaian_mcu.spirometri','penilaian_mcu.audiometri',
       'penilaian_mcu.treadmill','penilaian_mcu.lainlain','penilaian_mcu.merokok','penilaian_mcu.alkohol','penilaian_mcu.kesimpulan','penilaian_mcu.anjuran','penilaian_mcu.kd_dokter','dokter.nm_dokter')
        ->first();

        $data = [
            'periksa_mcu' => $periksa_mcu,
            'aplikasi' => $aplikasi
           
        ];

        //return view('pdf.report-mcu',$data);
        $pdf = Pdf::loadView('pdf.report-mcu', $data);
        return $pdf->stream();
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
