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

    public function profile() {
        $master_berkas_identitas = MasterBerkas::where('kategori','identitas')->get();

        $auth = Auth::user()->id_pegawai;
       
        $pengguna = User::where('id_pegawai',$auth)->first();

        $pegawai = Pegawai::where('id', $auth)
        ->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->join('stts_kerja','pegawai.stts_kerja','=','stts_kerja.stts')
        ->select('pegawai.id','pegawai.nik','pegawai.nama','pegawai.jk','pegawai.jbtn','departemen.nama AS nm_dep','pegawai.stts_aktif',
        'pegawai.tmp_lahir','pegawai.tgl_lahir','pegawai.alamat','pegawai.kota','pegawai.mulai_kerja','pegawai.no_ktp','stts_kerja.ktg',
        'pegawai.mulai_kontrak','pegawai.pendidikan')
        ->first();

        $data =[
            'pegawai' => $pegawai,
            'pengguna' => $pengguna,
            'master_berkas_identitas' => $master_berkas_identitas,
        ];

        return view('pages.Karyawan.profile-pengguna',$data);
    }

    public function rekap_presensi(Request $request) {
        $auth = Auth::user()->id_pegawai;
        if(!empty($request->from_date)) {
            $rekap_presensi = Pegawai::where('pegawai.id', $auth)->whereBetween('rekap_presensi.jam_datang', [$request->from_date, $request->to_date])
            ->join('rekap_presensi','pegawai.id','=','rekap_presensi.id')
            ->join('departemen','pegawai.departemen','=','departemen.dep_id')
            ->select('pegawai.id','pegawai.nik','pegawai.nama','rekap_presensi.shift','rekap_presensi.jam_datang',
            'rekap_presensi.jam_pulang','rekap_presensi.status','rekap_presensi.keterlambatan','rekap_presensi.durasi',
            'rekap_presensi.keterangan')
            ->get();
        }else {
            $rekap_presensi = Pegawai::where('pegawai.id', $auth)
            ->join('rekap_presensi','pegawai.id','=','rekap_presensi.id')
            ->join('departemen','pegawai.departemen','=','departemen.dep_id')
            ->select('pegawai.id','pegawai.nik','pegawai.nama','rekap_presensi.shift','rekap_presensi.jam_datang',
            'rekap_presensi.jam_pulang','rekap_presensi.status','rekap_presensi.keterlambatan','rekap_presensi.durasi',
            'rekap_presensi.keterangan')
            ->get();
        }
        return DataTables::of($rekap_presensi)
        ->addIndexColumn()
        ->make(true);
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

    public function ubah_password() {
        $auth = Auth::user()->id_pegawai;
        $pengguna = User::where('id_pegawai',$auth)->first();

        $data = [
            'pengguna' => $pengguna
        ];

        return view('pages.Karyawan.change-password',$data);
    }

    public function ganti_passowrd(Request $request) {

        $validated = Validator::make($request->all(),[
            'id' => 'required',
            'username' => 'required',
            'passwordold' => 'required',
            'passwordnew' => 'required',
        ],[
            'id.required' => 'ID Pengguna Belum Ada',
            'username.required' => 'Username Wajib diisi',
            'passwordold.required' => 'Password Lama Wajib Diisi',
            'passwordnew.required' => 'Password Baru Wajib Diisi',
         
        ]);
       
        if ($validated->passes()) {
            $pengguna = User::where('id',$request->id)->first();
            if (!$pengguna) {
                return response()->json([
                    'status' => 401,
                    'error' => 'Pengguna Tidak Ada',
                ]);
            }else {
                if (Hash::check($request->passwordold, $pengguna->password)) {

                    $ganti = User::where('id', $request->id)->update([
                        'password' => Hash::make($request->passwordnew)
                    ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Password Berhasil Diubah',
                    ]);

                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/');

                }else {
                    return response()->json([
                        'status' => 401,
                        'error' => 'Password Lama Tidak Cocok',
                    ]);
                }
            }
            
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);

        }
        
       
    }

    public function email() {
        $auth = Auth::user()->id_pegawai;
        $pengguna = User::where('id_pegawai',$auth)->first();

        $data = [
            'pengguna' => $pengguna
        ];
        return view('pages.Karyawan.change-email',$data);
    }

    public function ganti_email(Request $request) {
        $validated = Validator::make($request->all(),[
            'id' => 'required',
            'email' => 'required|email'
        ],[
            'id.required' => 'ID Pengguna Belum Ada',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email Kurang Tepat',
        ]);

        if ($validated->passes()) {
            $ganti_email = User::where('id', $request->id)->update([
                'email' => $request->email
            ]);
            if ($ganti_email) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Berhasil Diubah',
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
     * @param  \App\Models\DetailKepegawaian  $detailKepegawaian
     * @return \Illuminate\Http\Response
     */
    public function show(DetailKepegawaian $detailKepegawaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailKepegawaian  $detailKepegawaian
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailKepegawaian $detailKepegawaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailKepegawaian  $detailKepegawaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailKepegawaian $detailKepegawaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailKepegawaian  $detailKepegawaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailKepegawaian $detailKepegawaian)
    {
        //
    }
}
