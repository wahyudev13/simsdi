<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Karyawan;
use App\Http\Controllers\JenjangJabatanController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\UnitEmergencyController;
use App\Http\Controllers\FileIjazahController;
use App\Http\Controllers\FileTranskripController;
use App\Http\Controllers\FileSTRController;
use App\Http\Controllers\FileSIPController;
use App\Http\Controllers\MasterBerkasController;
use App\Http\Controllers\AlertSTRController;
use App\Http\Controllers\FileIdentitasController;
use App\Http\Controllers\SetAplikasiController;
use App\Http\Controllers\FileRiwayatKerjaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KesehatanController;
use App\Http\Controllers\FileKesehatanController;
use App\Http\Controllers\FileVaksinController;
use App\Http\Controllers\PenilaianKerjaController;
use App\Http\Controllers\PengingatController;
use App\Http\Controllers\MapingNormController;
use App\Http\Controllers\PenilaianMCUController;
use App\Http\Controllers\DetailKepegawaianController;
use App\Http\Controllers\PageuserController;
use App\Http\Controllers\JenisKegiatanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\FileSertifPelatihanController;
use App\Http\Controllers\FileOrientasiController;
use App\Http\Controllers\FileLainController;
use App\Http\Controllers\VerifIjazahController;
use App\Http\Controllers\VerifStrController;
use App\Http\Controllers\SpkRkkController;
use App\Http\Controllers\UraianTugasController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ActivityLogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('pages.Dashboard.dashboard');
// });


// Route::get('/tesbos', [FileSTRController::class, 'index'])->name('berkas.index');

// Route::get('/sendemail', [AlertSTRController::class, 'index']);
// Route::get('/kirimemail', [FileRiwayatKerjaController::class, 'index']);

Route::group(['middleware' => ['guest:admin,web']], function(){
    //Login
    Route::get('/', [AuthController::class, 'index'])->name('login.index');
    Route::post('/authentication', [AuthController::class, 'authentication'])->name('login.authentication');

    //Login Admin
    Route::get('/admin', [AuthController::class, 'admin'])->name('login.admin.index');
    Route::post('/authentication/admin', [AuthController::class, 'authenticationAdmin'])->name('login.authenticationAdmin');
});


Route::group(['middleware' => ['auth:admin,web']], function(){
    //Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    //Dashboard
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard.index');
    
    Route::group(['middleware' => ['permission:admin-all-access']], function () {
        //Setting
        Route::get('/setting/aplikasi', [SetAplikasiController::class, 'index'])->name('setting.aplikasi.index');
        Route::post('/setting/aplikasi/store', [SetAplikasiController::class, 'store'])->name('setting.aplikasi.store');

        //Administrator
        Route::get('/setting/admin', [AdminController::class, 'index'])->name('setting.admin.index');
        Route::get('/setting/admin/get', [AdminController::class, 'get'])->name('setting.admin.get');
        Route::post('/setting/admin/store', [AdminController::class, 'store'])->name('setting.admin.store');
        Route::post('/setting/admin/destroy', [AdminController::class, 'destroy'])->name('setting.admin.destroy');
        Route::get('/setting/admin/show', [AdminController::class, 'show'])->name('setting.admin.show');
        Route::post('/setting/admin/update', [AdminController::class, 'update'])->name('setting.admin.update');

        //MasterBerkas
        Route::get('/master/berkas', [MasterBerkasController::class, 'index'])->name('master.berkas');
        Route::get('/master/berkas/get', [MasterBerkasController::class, 'getMaster'])->name('master.get');
        Route::post('/master/berkas/store', [MasterBerkasController::class, 'store'])->name('master.store');
        Route::get('/master/berkas/show', [MasterBerkasController::class, 'show'])->name('master.berkas.show');
        Route::post('/master/berkas/update', [MasterBerkasController::class, 'update'])->name('master.berkas.update');
        Route::post('/master/berkas/destroy', [MasterBerkasController::class, 'destroy'])->name('master.berkas.destroy');

        //Pengguna
        Route::get('/master/pengguna', [PenggunaController::class, 'index'])->name('master.pengguna');
        Route::get('/master/pengguna/get', [PenggunaController::class, 'getuser'])->name('master.pengguna.getuser');
        Route::get('/pegawai/load/', [PenggunaController::class, 'load_pengguna'])->name('master.pengguna.load_pengguna');
        Route::post('/master/pengguna/store', [PenggunaController::class, 'store'])->name('master.pengguna.store');
        Route::get('/master/pengguna/show', [PenggunaController::class, 'show'])->name('master.pengguna.show');
        Route::post('/master/pengguna/destroy', [PenggunaController::class, 'destroy'])->name('master.pengguna.destroy');
        Route::post('/master/pengguna/update', [PenggunaController::class, 'update'])->name('master.pengguna.update');

        //maping No Rekam Medis
        Route::get('/pengguna/maping/norm', [MapingNormController::class, 'index'])->name('master.maping');
        Route::get('/pengguna/maping/get', [MapingNormController::class, 'get'])->name('master.maping.get');
        //  Route::get('/pengguna/maping/load', [MapingNormController::class, 'load'])->name('master.maping.load');
        Route::get('/pasien', [MapingNormController::class, 'pasien'])->name('pasien.get');
        Route::get('/pengguna/maping/load_pasien', [MapingNormController::class, 'load_pasien'])->name('master.maping.load_pasien');
        Route::post('/pengguna/maping/store', [MapingNormController::class, 'store'])->name('master.maping.store');
        Route::get('/pengguna/maping/show', [MapingNormController::class, 'show'])->name('master.maping.show');
        Route::post('/pengguna/maping/update', [MapingNormController::class, 'update'])->name('master.maping.update');
        Route::post('/pengguna/maping/destroy', [MapingNormController::class, 'destroy'])->name('master.maping.destroy');

        //Add Role To user
        Route::get('/master/pengguna/role/show', [PenggunaController::class, 'settingRole'])->name('master.pengguna.settingRole');
        Route::post('/master/pengguna/role/store', [PenggunaController::class, 'addRoleUser'])->name('master.pengguna.addRoleUser');
        Route::post('/master/pengguna/role/destroy', [PenggunaController::class, 'deleteRoleUser'])->name('master.pengguna.deleteRoleUser');

        //Master Role
        Route::get('/master/role', [RoleController::class, 'index'])->name('master.role.index');
        Route::get('/master/role/get', [RoleController::class, 'data'])->name('master.role.get');
        Route::post('/master/role/store', [RoleController::class, 'store'])->name('master.role.store');
        Route::post('/master/role/delete', [RoleController::class, 'delete'])->name('master.role.delete');
        Route::get('/master/role/edit', [RoleController::class, 'edit'])->name('master.role.edit');
        Route::post('/master/role/update', [RoleController::class, 'update'])->name('master.role.update');

        Route::get('/master/role/getPermission', [RoleController::class, 'getPermission'])->name('master.role.getPermission');
        Route::post('/master/role/addPermissionRole', [RoleController::class, 'addPermissionRole'])->name('master.role.addPermissionRole');
        Route::post('/master/role/deletePermission', [RoleController::class, 'deletePermission'])->name('master.role.deletePermission');

        // Activity Log Routes
        Route::group(['middleware' => ['activity.log']], function () {
            Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
            Route::get('/activity-log/{id}', [ActivityLogController::class, 'show'])->name('activity-log.show');
            Route::post('/activity-log/clear', [ActivityLogController::class, 'clearLogs'])->name('activity-log.clear');
            Route::get('/activity-log/export', [ActivityLogController::class, 'exportLogs'])->name('activity-log.export');
        });

        
    });
    
    Route::group(['middleware' => ['permission:admin-karyawan-detail|admin-all-access']], function () {
        //Detail Kepegawaian
        Route::get('karyawan/detail/get/{id}', [DetailKepegawaianController::class, 'index'])->name('pegawai.detail.index');
        //Presensi
        Route::get('karyawan/admin/presensi/rekap', [DetailKepegawaianController::class, 'rekap_presensi_admin'])->name('pegawai.presensi.rekap_presensi_admin');
    });

    Route::group(['middleware' => ['permission:admin-karyawan-view|admin-all-access']], function () {
        //Pegawai
        Route::get('/karyawan', [Karyawan::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/get', [Karyawan::class, 'getPegawai'])->name('karyawan.getPegawai');
    });
  
    Route::group(['middleware' => ['permission:admin-karyawan-dokumen|admin-all-access']], function () {
        //Berkas Ijazah
        Route::get('/karyawan/berkas/ijazah/get', [FileIjazahController::class, 'getIjazah'])->name('berkas.getIjazah');
        Route::get('/karyawan/berkas/kepeg/{id}', [FileIjazahController::class, 'index'])->name('berkas.index');
        Route::post('/karyawan/berkas/store', [FileIjazahController::class, 'store'])->name('berkas.store');
        Route::post('/karyawan/berkas/delete', [FileIjazahController::class, 'destroy'])->name('berkas.destroy');
        Route::get('/karyawan/edit/berkas', [FileIjazahController::class, 'edit'])->name('berkas.edit');
        Route::post('/karyawan/update/berkas', [FileIjazahController::class, 'update'])->name('berkas.update');
        
        //Verifikasi Ijazah
        Route::post('/karyawan/ijazah/verif/store', [VerifIjazahController::class, 'store'])->name('verif.ijazah.store');
        Route::post('/karyawan/ijazah/verif/destroy', [VerifIjazahController::class, 'destroy'])->name('verif.ijazah.destroy');

        //Berkas Transkrip
        Route::get('/karyawan/berkas/traskrip/get', [FileTranskripController::class, 'getTranskrip'])->name('berkas.getTranskrip');
        Route::post('/karyawan/berkas/traskrip/store', [FileTranskripController::class, 'store'])->name('berkas.transkrip.store');
        Route::get('/karyawan/edit/berkas/traskrip', [FileTranskripController::class, 'edit'])->name('berkas.transkrip.edit');
        Route::post('/karyawan/update/berkas/traskrip', [FileTranskripController::class, 'update'])->name('berkas.transkrip.update');
        Route::post('/karyawan/berkas/traskrip/destroy', [FileTranskripController::class, 'destroy'])->name('berkas.transkrip.destroy');

        //Berkas STR
        Route::get('/karyawan/berkas/str/get', [FileSTRController::class, 'getSTR'])->name('berkas.getSTR');
        Route::post('/karyawan/berkas/str/store', [FileSTRController::class, 'store'])->name('berkas.str.store');
        Route::post('/karyawan/berkas/str/destroy', [FileSTRController::class, 'destroy'])->name('berkas.str.destroy');
        Route::get('/karyawan/berkas/str/edit', [FileSTRController::class, 'edit'])->name('berkas.str.edit');
        Route::post('/karyawan/berkas/str/update', [FileSTRController::class, 'update'])->name('berkas.str.update');
        Route::post('/karyawan/berkas/str/status', [FileSTRController::class, 'status'])->name('berkas.str.status');
        
        //Verifikasi STR
        Route::post('/karyawan/str/verif/store', [VerifStrController::class, 'store'])->name('verif.str.store');
        Route::post('/karyawan/str/verif/destroy', [VerifStrController::class, 'destroy'])->name('verif.str.destroy');
        
        //JSON STR
        // Route::get('/karyawan/str/get/{id}', [FileSIPController::class, 'strget'])->name('file.str.get');
        Route::get('/karyawan/str/get', [FileSIPController::class, 'strget'])->name('file.str.get');
        // Route::get('/karyawan/str/selected/get/{idsip}', [FileSIPController::class, 'str_selected'])->name('selected.str.get');
        Route::get('/karyawan/str/selected/get', [FileSIPController::class, 'str_selected'])->name('selected.str.get');

        //Berkas SIP
        Route::get('/karyawan/berkas/sip/get', [FileSIPController::class, 'getSIP'])->name('berkas.getSIP');
        Route::post('/karyawan/berkas/sip/store', [FileSIPController::class, 'store'])->name('berkas.sip.store');
        Route::post('/karyawan/berkas/sip/destroy', [FileSIPController::class, 'destroy'])->name('berkas.sip.destroy');
        Route::get('/karyawan/berkas/sip/edit', [FileSIPController::class, 'edit'])->name('berkas.sip.edit');
        Route::post('/karyawan/berkas/sip/update', [FileSIPController::class, 'update'])->name('berkas.sip.update');
        Route::post('/karyawan/berkas/sip/exp', [FileSIPController::class, 'exp'])->name('berkas.sip.exp');
        Route::post('/karyawan/berkas/sip/desexp', [FileSIPController::class, 'desexp'])->name('berkas.sip.desexp');
        Route::post('/karyawan/berkas/sip/status', [FileSIPController::class, 'status'])->name('berkas.sip.status');

        //Berkas Riwayat kerja
        Route::get('/karyawan/berkas/riwayat/get', [FileRiwayatKerjaController::class, 'getRiwayat'])->name('berkas.riwayat.getRiwayat');
        Route::post('/karyawan/berkas/riwayat/store', [FileRiwayatKerjaController::class, 'store'])->name('berkas.riwayat.store');
        Route::get('/karyawan/berkas/riwayat/edit', [FileRiwayatKerjaController::class, 'edit'])->name('berkas.riwayat.edit');
        Route::post('/karyawan/berkas/riwayat/update', [FileRiwayatKerjaController::class, 'update'])->name('berkas.riwayat.update');
        Route::post('/karyawan/berkas/riwayat/destroy', [FileRiwayatKerjaController::class, 'destroy'])->name('berkas.riwayat.destroy');
        Route::post('/karyawan/berkas/riwayat/updatestatus', [FileRiwayatKerjaController::class, 'updatestatus'])->name('berkas.riwayat.update.status');

        //Berkas Orientasi
        Route::get('karyawan/berkas/orientasi', [FileOrientasiController::class, 'getOrientasi'])->name('berkas.orientasi.get');
        Route::post('karyawan/berkas/orientasi/store', [FileOrientasiController::class, 'store'])->name('berkas.orientasi.store');
        Route::get('karyawan/berkas/orientasi/edit', [FileOrientasiController::class, 'edit'])->name('berkas.orientasi.edit');
        Route::post('karyawan/berkas/orientasi/update', [FileOrientasiController::class, 'update'])->name('berkas.orientasi.update');
        Route::post('karyawan/berkas/orientasi/destroy', [FileOrientasiController::class, 'destroy'])->name('berkas.orientasi.destroy');
        //Berkas Lain-lain
        Route::get('karyawan/berkas/lain-lain', [FileLainController::class, 'get'])->name('berkas.lainlain.get');
        Route::post('karyawan/berkas/lain-lain/store', [FileLainController::class, 'store'])->name('berkas.lainlain.store');
        Route::get('karyawan/berkas/lain-lain/edit', [FileLainController::class, 'edit'])->name('berkas.lainlain.edit');
        Route::post('karyawan/berkas/lain-lain/updated', [FileLainController::class, 'update'])->name('berkas.lainlain.update');
        Route::post('karyawan/berkas/lain-lain/destroy', [FileLainController::class, 'destroy'])->name('berkas.lainlain.destroy');
        //SPK
        Route::get('karyawan/berkas/spk/get', [SpkRkkController::class, 'get'])->name('berkas.spk.get');
        Route::post('karyawan/berkas/spk/store', [SpkRkkController::class, 'store'])->name('berkas.spk.store');
        Route::get('karyawan/berkas/spk/edit', [SpkRkkController::class, 'edit'])->name('berkas.spk.edit');
        Route::post('karyawan/berkas/spk/update', [SpkRkkController::class, 'update'])->name('berkas.spk.update');
        Route::post('karyawan/berkas/spk/destroy', [SpkRkkController::class, 'destroy'])->name('berkas.spk.destroy');
        //Uraian Tugas
        Route::get('karyawan/berkas/uraian-tugas/get', [UraianTugasController::class, 'get'])->name('berkas.uraian.get');
        Route::post('karyawan/berkas/uraian-tugas/store', [UraianTugasController::class, 'store'])->name('berkas.uraian.store');
        Route::get('karyawan/berkas/uraian-tugas/edit', [UraianTugasController::class, 'edit'])->name('berkas.uraian.edit');
        Route::post('karyawan/berkas/uraian-tugas/update', [UraianTugasController::class, 'update'])->name('berkas.uraian.update');
        Route::post('karyawan/berkas/uraian-tugas/destroy', [UraianTugasController::class, 'destroy'])->name('berkas.uraian.destroy');
       
        //FileIdentitas (lain lain)
        Route::get('karyawan/berkas/lain/get', [FileIdentitasController::class, 'getFile'])->name('berkas.lain.getFile');
        Route::post('karyawan/berkas/lain/store', [FileIdentitasController::class, 'store'])->name('berkas.lain.store');
        Route::post('karyawan/berkas/lain/destroy', [FileIdentitasController::class, 'destroy'])->name('berkas.lain.destroy');
        Route::get('karyawan/berkas/lain/edit', [FileIdentitasController::class, 'edit'])->name('berkas.lain.edit');
        Route::post('karyawan/berkas/lain/update', [FileIdentitasController::class, 'update'])->name('berkas.lain.update');

    });

    Route::group(['middleware' => ['permission:admin-peringatan|admin-all-access']], function () {
        //Peringatan
        Route::get('/pengingat/str', [PengingatController::class, 'index'])->name('pengingat.str.index');
        Route::get('/pengingat/str/get', [PengingatController::class, 'get'])->name('pengingat.str.get');
        Route::get('/pengingat/kontrak', [PengingatController::class, 'pengingatKontrak'])->name('pengingat.kontrak.pengingatKontrak');
        Route::get('/pengingat/kontrak/get', [PengingatController::class, 'getkontrak'])->name('pengingat.kontrak.get');
        Route::get('/pengingat/sip', [PengingatController::class, 'pengingatSip'])->name('pengingat.sip.pengingatSip');
        Route::get('/pengingat/sip/get', [PengingatController::class, 'getSip'])->name('pengingat.sip.get');
    });

    Route::group(['middleware' => ['permission:admin-karyawan-dokumen-k3|admin-all-access']], function () {
        //Kesehatan
        Route::get('/karyawan/berkas/kesehatan/{id}', [KesehatanController::class, 'index'])->name('berkas.kesehatan.index');

        //TES KESEHATAN
        Route::get('/karyawan/berkas/kesehatan/awal/get', [FileKesehatanController::class, 'index'])->name('kesehatan.awal.index');
        Route::post('/karyawan/berkas/kesehatan/awal/store', [FileKesehatanController::class, 'store'])->name('kesehatan.awal.store');
        Route::get('/karyawan/berkas/kesehatan/awal/edit', [FileKesehatanController::class, 'edit'])->name('kesehatan.awal.edit');
        Route::post('/karyawan/berkas/kesehatan/awal/update', [FileKesehatanController::class, 'update'])->name('kesehatan.awal.update');
        Route::post('/karyawan/berkas/kesehatan/awal/destroy', [FileKesehatanController::class, 'destroy'])->name('kesehatan.awal.destroy');
    
        //Vaksin
        Route::get('/karyawan/berkas/kesehatan/vaksin/get', [FileVaksinController::class, 'index'])->name('kesehatan.vaksin.index');
        Route::post('/karyawan/berkas/kesehatan/vaksin/store', [FileVaksinController::class, 'store'])->name('kesehatan.vaksin.store');
        Route::get('/karyawan/berkas/kesehatan/vaksin/edit', [FileVaksinController::class, 'edit'])->name('kesehatan.vaksin.edit');
        Route::post('/karyawan/berkas/kesehatan/vaksin/update', [FileVaksinController::class, 'update'])->name('kesehatan.vaksin.update');
        Route::post('/karyawan/berkas/kesehatan/vaksin/destroy', [FileVaksinController::class, 'destroy'])->name('kesehatan.vaksin.destroy');

        //MCU
        Route::get('penilaian/kesehatan/mcu/get', [PenilaianMCUController::class, 'get'])->name('penilaian.mcu.get');
        Route::get('penilaian/kesehatan/mcu/periksalab', [PenilaianMCUController::class, 'periksalab'])->name('penilaian.mcu.periksalab');
               
        //Menampilkan Report MCU dan Lab
        Route::get('penilaian/kesehatan/mcu/{tglreg}/{norm}/{kdpoli}/{noreg}', [PenilaianMCUController::class, 'report_mcu_v2'])->name('mcu.report.pdf.v2');
        Route::get('penilaian/kesehatan/mcu/laborat/{norm}/{kdpoli}/{tglreg}/{noreg}/{kdprw}', [PenilaianMCUController::class, 'report_lab_v2'])->name('mcu.report.lab.v2');
    });
  
    Route::group(['middleware' => ['permission:admin-karyawan-penilaian|admin-all-access']], function () {
        //Penilaian Kerja
        Route::get('karyawan/berkas/penilaian/{id}', [PenilaianKerjaController::class, 'index'])->name('penilaian.index');
        Route::get('karyawan/penilaian/get', [PenilaianKerjaController::class, 'get'])->name('penilaian.berkas.get');
        Route::post('karyawan/penilaian/store', [PenilaianKerjaController::class, 'store'])->name('penilaian.berkas.store');
        Route::get('karyawan/penilaian/edit', [PenilaianKerjaController::class, 'edit'])->name('penilaian.berkas.edit');
        Route::post('karyawan/penilaian/update', [PenilaianKerjaController::class, 'update'])->name('penilaian.berkas.update');
        Route::post('karyawan/penilaian/destroy', [PenilaianKerjaController::class, 'destroy'])->name('penilaian.berkas.destroy');
    });

    Route::group(['middleware' => ['permission:admin-karyawan-dokumen-diklat|admin-all-access']], function () {
        //Dokumen Diklat
        Route::get('karyawan/berkas/diklat/{id}', [DiklatController::class, 'index'])->name('karywan.diklat');
        Route::post('karyawan/berkas/diklat/sertif/store', [FileSertifPelatihanController::class, 'store'])->name('karywan.diklat.sertif.store');
        Route::get('karyawan/berkas/diklat/sertif/get', [FileSertifPelatihanController::class, 'get'])->name('karywan.diklat.sertif.get');
        Route::get('karyawan/berkas/diklat/sertif/edit', [FileSertifPelatihanController::class, 'edit'])->name('karywan.diklat.sertif.edit');
        Route::post('karyawan/berkas/diklat/sertif/update', [FileSertifPelatihanController::class, 'update'])->name('karywan.diklat.sertif.update');
        Route::post('karyawan/berkas/diklat/sertif/destroy', [FileSertifPelatihanController::class, 'destroy'])->name('karywan.diklat.sertif.destroy');
        //load pegawai
        Route::get('/pengguna/maping/load', [MapingNormController::class, 'load'])->name('master.maping.load');
        
        Route::get('diklat/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('diklat/unit/get', [KegiatanController::class, 'json_dep'])->name('departemen.get');
        Route::get('diklat/jenis/get', [KegiatanController::class, 'json_jenis'])->name('jenis.get');

        Route::get('diklat/kegiatan/get', [KegiatanController::class, 'get'])->name('kegiatan.get');
        Route::post('diklat/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('diklat/kegiatan/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
        Route::post('diklat/kegiatan/update', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::post('diklat/kegiatan/destroy', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

        Route::get('diklat/jenis-kegiatan', [JenisKegiatanController::class, 'index'])->name('diklat.kegiatan.jenis');
        Route::get('diklat/jenis-kegiatan/get', [JenisKegiatanController::class, 'get'])->name('diklat.kegiatan.jenis.get');
        Route::POST('diklat/jenis-kegiatan/store', [JenisKegiatanController::class, 'store'])->name('diklat.kegiatan.jenis.store');
        Route::get('diklat/jenis-kegiatan/edit', [JenisKegiatanController::class, 'edit'])->name('diklat.kegiatan.jenis.edit');
        Route::POST('diklat/jenis-kegiatan/update', [JenisKegiatanController::class, 'update'])->name('diklat.kegiatan.jenis.update');
        Route::POST('diklat/jenis-kegiatan/destroy', [JenisKegiatanController::class, 'destroy'])->name('diklat.kegiatan.jenis.destroy');

        Route::get('diklat/absensi/masuk/{id}', [AbsensiController::class, 'index'])->name('absensi.diklat.masuk');
        Route::post('diklat/absensi/masuk/store', [AbsensiController::class, 'store'])->name('absensi.diklat.masuk.store');
        Route::get('diklat/absensi/get/masuk', [AbsensiController::class, 'get_masuk'])->name('absensi.diklat.masuk.get');

        Route::get('diklat/absensi/selesai/{id}', [AbsensiController::class, 'selesai'])->name('absensi.diklat.selesai');
        Route::post('diklat/absensi/selesai/update', [AbsensiController::class, 'update'])->name('absensi.diklat.selesai.update');
    
        Route::get('diklat/absensi/manual/{id}', [AbsensiController::class, 'manual'])->name('absensi.diklat.manual');
        Route::post('diklat/absensi/manual/store', [AbsensiController::class, 'store_manual'])->name('absensi.diklat.store_manual');
        Route::post('diklat/absensi/manual/destroy', [AbsensiController::class, 'destroy'])->name('absensi.diklat.destroy');

        Route::get('diklat/absensi/rekab/{id}', [AbsensiController::class, 'rekap'])->name('absensi.diklat.rekap');

        Route::get('karyawan/diklat/iht', [DiklatController::class, 'absen_iht'])->name('karywan.diklat.absen_iht');
    });

    Route::group(['middleware' => ['permission:user-menu-access']], function () { 
        //Presensi
        Route::get('karyawan/presensi/rekap', [PageuserController::class, 'getPresensiPengguna'])->name('pengguna.presensi');
        //Profile
        Route::get('profile/pengguna', [PageuserController::class, 'profile'])->name('profile.index');
        Route::get('profile/ubah_password', [PageuserController::class, 'ubah_password'])->name('profile.ubah_password');
        Route::post('profile/ubah_password/update', [PageuserController::class, 'ganti_passowrd'])->name('profile.ganti_passowrd');
        //getSTR untuk SIP
        Route::get('pengguna/str/get', [PageuserController::class, 'getSTRPengguna'])->name('str.get');
        //get Data
        Route::get('pengguna/getijazah', [PageuserController::class, 'getijazah'])->name('pengguna.getijazah');
        Route::get('pengguna/gettrans', [PageuserController::class, 'gettrans'])->name('pengguna.gettrans');
        Route::get('pengguna/getSTR', [PageuserController::class, 'getSTR'])->name('pengguna.getSTR');
        Route::get('pengguna/getSIP', [PageuserController::class, 'getSIP'])->name('pengguna.getSIP');
        Route::get('pengguna/getRiwayat', [PageuserController::class, 'getRiwayat'])->name('pengguna.getRiwayat');
        Route::get('pengguna/getKesehatan', [PageuserController::class, 'getKesehatan'])->name('pengguna.getKesehatan');
        Route::get('pengguna/getVaksin', [PageuserController::class, 'getVaksin'])->name('pengguna.getVaksin');
        Route::get('pengguna/getMCU', [PageuserController::class, 'getMCU'])->name('pengguna.getMCU');
        Route::get('pengguna/getFileId', [PageuserController::class, 'getFileId'])->name('pengguna.getFileId');
        Route::get('pengguna/getSertif', [PageuserController::class, 'getSertif'])->name('pengguna.getSertif');
        Route::get('pengguna/getOrientasi', [PageuserController::class, 'getOrientasi'])->name('pengguna.getOrientasi');
        //halaman
        Route::get('pengguna/pendidikan', [PageuserController::class, 'pendidikan'])->name('pengguna.pendidikan');
        Route::get('pengguna/izin', [PageuserController::class, 'izin'])->name('pengguna.izin');
        Route::get('pengguna/kesehatan', [PageuserController::class, 'kesehatan'])->name('pengguna.kesehatan');
        Route::get('pengguna/vaksin', [PageuserController::class, 'vaksin'])->name('pengguna.vaksin');
        Route::get('pengguna/riwayat', [PageuserController::class, 'riwayat'])->name('pengguna.riwayat');
        Route::get('pengguna/sertifikat', [PageuserController::class, 'sertifikat'])->name('pengguna.sertifikat');
        Route::get('pengguna/orientasi', [PageuserController::class, 'orientasi'])->name('pengguna.orientasi');
        Route::get('pengguna/pelatihan', [PageuserController::class, 'riwayat_pelatihan'])->name('pengguna.pelatihan');
        Route::get('pengguna/pelatihan/absen', [PageuserController::class, 'absensi_diklat'])->name('pengguna.pelatihan.absen');     
        
        //Get Data MCU
        Route::get('pengguna/mcu', [PageuserController::class, 'mcu'])->name('pengguna.mcu');
        //Get Data Laborat
        Route::get('pengguna/mcu/laborat', [PageuserController::class, 'periksalabMCUPengguna'])->name('pengguna.mcu.laborat');

        //Report MCU dan Laborat
        Route::get('pengguna/mcu/report/{tglreg}/{norm}/{kdpoli}/{noreg}', [PageuserController::class, 'reportMCUPengguna'])->name('pengguna.mcu.report');
        Route::get('pengguna/mcu/report/laborat/{norm}/{kdpoli}/{tglreg}/{noreg}/{kdprw}', [PageuserController::class, 'reportLabPengguna'])->name('pengguna.mcu.report.laborat');

        //STR
        Route::get('pengguna/getSTR', [FileSTRController::class, 'getSTR'])->name('pengguna.getSTR');
        Route::group(['middleware' => ['permission:user-str-create']], function () {
            Route::post('pengguna/str/store', [FileSTRController::class, 'store'])->name('pengguna.str.store');
             //Verifikasi STR
            Route::post('pengguna/str/verif/store', [VerifStrController::class, 'store'])->name('pengguna.verif.str.store');
            Route::post('pengguna/str/verif/destroy', [VerifStrController::class, 'destroy'])->name('pengguna.verif.str.destroy');
        });
        Route::group(['middleware' => ['permission:user-str-edit']], function () {
            Route::get('pengguna/str/edit', [FileSTRController::class, 'edit'])->name('pengguna.str.edit');
            Route::post('pengguna/str/update', [FileSTRController::class, 'update'])->name('pengguna.str.update');
        });
        Route::group(['middleware' => ['permission:user-str-delete']], function () {
            Route::post('pengguna/str/destroy', [FileSTRController::class, 'destroy'])->name('pengguna.str.destroy');   
        });

        

        //TAMBAH
        Route::group(['middleware' => ['permission:user-ijazah-create']], function () {
            Route::post('pengguna/ijazah/store', [PageuserController::class, 'storeijazah'])->name('pengguna.ijazah.store');
        });
        Route::group(['middleware' => ['permission:user-transkrip-create']], function () {
            Route::post('pengguna/transkrip/store', [PageuserController::class, 'storetrans'])->name('pengguna.trans.store');
        });
       
        Route::group(['middleware' => ['permission:user-sip-create']], function () {
            Route::post('pengguna/sip/store', [PageuserController::class, 'storesip'])->name('pengguna.sip.store');
        });
        Route::group(['middleware' => ['permission:user-riwayat-create']], function () {
            Route::post('pengguna/riwayat/store', [PageuserController::class, 'storeriwayat'])->name('pengguna.riwayat.store');
        });
        Route::group(['middleware' => ['permission:user-kesehatan-create']], function () {
            Route::post('pengguna/kesehatan/store', [PageuserController::class, 'storekes'])->name('pengguna.kesehatan.store');
        });
        Route::group(['middleware' => ['permission:user-vaksin-create']], function () {
            Route::post('pengguna/vaksin/store', [PageuserController::class, 'storevaksin'])->name('pengguna.vaksin.store');
        });
        Route::group(['middleware' => ['permission:user-setif-create']], function () {
            Route::post('pengguna/sertifikat/store', [PageuserController::class, 'storeSertif'])->name('pengguna.sertifikat.store');
        });
        Route::group(['middleware' => ['permission:user-orientasi-create']], function () {
            Route::post('pengguna/orientasi/store', [PageuserController::class, 'storeOrientasi'])->name('pengguna.orientasi.store');
        });

        //EDIT
        Route::group(['middleware' => ['permission:user-ijazah-edit']], function () {
            Route::get('pengguna/ijazah/edit', [PageuserController::class, 'editijazah'])->name('pengguna.ijazah.edit');
            Route::post('pengguna/ijazah/update', [PageuserController::class, 'updateijazah'])->name('pengguna.ijazah.update');
        });
        Route::group(['middleware' => ['permission:user-transkrip-edit']], function () {
            Route::get('pengguna/transkrip/edit', [PageuserController::class, 'edittrans'])->name('pengguna.trans.edit');
            Route::post('pengguna/transkrip/update', [PageuserController::class, 'updatetrans'])->name('pengguna.trans.update');
        });
       
        Route::group(['middleware' => ['permission:user-sip-edit']], function () {
            Route::get('pengguna/sip/edit', [PageuserController::class, 'editsip'])->name('pengguna.sip.edit');
            Route::post('pengguna/sip/update', [PageuserController::class, 'updatesip'])->name('pengguna.sip.update');
        });
        Route::group(['middleware' => ['permission:user-riwayat-edit']], function () {
            Route::get('pengguna/riwayat/edit', [PageuserController::class, 'editriwayat'])->name('pengguna.riwayat.edit');
            Route::post('pengguna/riwayat/update', [PageuserController::class, 'updateriwayat'])->name('pengguna.riwayat.update');
        });
        Route::group(['middleware' => ['permission:user-kesehatan-edit']], function () {
            Route::get('pengguna/kesehatan/edit', [PageuserController::class, 'editkes'])->name('pengguna.kesehatan.edit');
            Route::post('pengguna/kesehatan/update', [PageuserController::class, 'updatekes'])->name('pengguna.kesehatan.update');
        });
        Route::group(['middleware' => ['permission:user-vaksin-edit']], function () {
            Route::get('pengguna/vaksin/edit', [PageuserController::class, 'editvaksin'])->name('pengguna.vaksin.edit');
            Route::post('pengguna/vaksin/update', [PageuserController::class, 'updatevaksin'])->name('pengguna.vaksin.update');
        });
        Route::group(['middleware' => ['permission:user-setif-edit']], function () {
            Route::get('pengguna/sertifikat/edit', [PageuserController::class, 'editSertif'])->name('pengguna.sertifikat.edit');
            Route::post('pengguna/sertifikat/update', [PageuserController::class, 'updateSertif'])->name('pengguna.sertifikat.update');
        });
        Route::group(['middleware' => ['permission:user-orientasi-edit']], function () {
            Route::get('pengguna/orientasi/edit', [PageuserController::class, 'editOrientasi'])->name('pengguna.orientasi.edit');
            Route::post('pengguna/orientasi/update', [PageuserController::class, 'updateOrientasi'])->name('pengguna.orientasi.update');
        });

        //FileIdentitas (lain lain) - Untuk Pengguna
        Route::group(['middleware' => ['permission:user-identitas-view']], function () {
            Route::get('pengguna/berkas/lain/get', [FileIdentitasController::class, 'getFile'])->name('pengguna.berkas.lain.getFile');
        });
        Route::group(['middleware' => ['permission:user-identitas-create']], function () {
            Route::post('pengguna/berkas/lain/store', [FileIdentitasController::class, 'store'])->name('pengguna.berkas.lain.store');
        });
        Route::group(['middleware' => ['permission:user-identitas-edit']], function () {
            Route::get('pengguna/berkas/lain/edit', [FileIdentitasController::class, 'edit'])->name('pengguna.berkas.lain.edit');
            Route::post('pengguna/berkas/lain/update', [FileIdentitasController::class, 'update'])->name('pengguna.berkas.lain.update');
        });
        Route::group(['middleware' => ['permission:user-identitas-delete']], function () {
            Route::post('pengguna/berkas/lain/destroy', [FileIdentitasController::class, 'destroy'])->name('pengguna.berkas.lain.destroy');
        });

        //HAPUS
        Route::group(['middleware' => ['permission:user-ijazah-delete']], function () {
            Route::post('pengguna/ijazah/destroy', [PageuserController::class, 'destroyijazah'])->name('pengguna.ijazah.destroy');
        });
        Route::group(['middleware' => ['permission:user-transkrip-delete']], function () {
            Route::post('pengguna/transkrip/destroy', [PageuserController::class, 'destroytrans'])->name('pengguna.transkrip.destroy');   
        });
      
        Route::group(['middleware' => ['permission:user-sip-delete']], function () {
            Route::post('pengguna/sip/destroy', [PageuserController::class, 'destroysip'])->name('pengguna.sip.destroy');   
        });
        Route::group(['middleware' => ['permission:user-riwayat-delete']], function () {
            Route::post('pengguna/riwayat/destroy', [PageuserController::class, 'destroyriwayat'])->name('pengguna.riwayat.destroy');
        });
        Route::group(['middleware' => ['permission:user-kesehatan-delete']], function () {
            Route::post('pengguna/kesehatan/destroy', [PageuserController::class, 'destroykes'])->name('pengguna.kesehatan.destroy');
        });
        Route::group(['middleware' => ['permission:user-vaksin-delete']], function () {
            Route::post('pengguna/vaksin/destroy', [PageuserController::class, 'destroyvaksin'])->name('pengguna.vaksin.destroy');
        });
        Route::group(['middleware' => ['permission:user-setif-delete']], function () {
            Route::post('pengguna/sertifikat/destroy', [PageuserController::class, 'destroySertif'])->name('pengguna.sertifikat.destroy');
        });
        Route::group(['middleware' => ['permission:user-orientasi-delete']], function () {
            Route::post('pengguna/orientasi/destroy', [PageuserController::class, 'destroyOrientasi'])->name('pengguna.orientasi.destroy');
        });
    }); 
});
