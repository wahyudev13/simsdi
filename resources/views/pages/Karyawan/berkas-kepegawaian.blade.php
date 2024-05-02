@extends('layouts.app')
@section('title', 'Berkas Karyawan')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Berkas Karyawan</h1>


    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <div class="card border-left-primary mb-4 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $pegawai->jbtn }} / {{ $pegawai->nama_dep }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pegawai->nama }} ({{ $pegawai->nik }})
                            </div>
                            <input type="hidden" class="id-pegawai" value="{{ $pegawai->id }}">
                            <input type="hidden" class="nik-pegawai" value="{{ $pegawai->nik }}">
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-solid fa-upload fa-2x text-gray-300"></i> --}}
                            <i class="fas fa-user-tag fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pendidikan-tab" data-toggle="tab" data-target="#pendidikan"
                        type="button" role="tab" aria-controls="pendidikan" aria-selected="true">Data
                        Pendidikan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="izin-tab" data-toggle="tab" data-target="#izin" type="button"
                        role="tab" aria-controls="izin" aria-selected="false">Data Perizinan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="riwayat-tab" data-toggle="tab" data-target="#riwayat" type="button"
                        role="tab" aria-controls="riwayat" aria-selected="false">Data Riwayat Pekerjaan </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="identitas-tab" data-toggle="tab" data-target="#identitas" type="button"
                        role="tab" aria-controls="identitas" aria-selected="false">Data Diri Karyawan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="orientasi-tab" data-toggle="tab" data-target="#orientasi" type="button"
                        role="tab" aria-controls="orientasi" aria-selected="false">Data Orientasi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="spk-tab" data-toggle="tab" data-target="#spk" type="button"
                        role="tab" aria-controls="spk" aria-selected="false">SPK & RKK</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="uraian-tab" data-toggle="tab" data-target="#uraian" type="button"
                        role="tab" aria-controls="uraian" aria-selected="false">Uraian Tugas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="lain-tab" data-toggle="tab" data-target="#lain" type="button"
                        role="tab" aria-controls="lain" aria-selected="false">Lain-Lain</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modalUpload">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas Ijazah</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-pendidikan" id="tbJenjang" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Asal</th>
                                    <th>Tahun Lulus</th>
                                    <th>Verifikasi</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end-->

                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdTrans">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas Transkrip</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-pendidikan" id="tableTrans" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>


                </div>
                <div class="tab-pane fade" id="izin" role="tabpanel" aria-labelledby="izin-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdSTR">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas STR</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-perizinan" id="tbSTR" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor REG</th>
                                    <th>Bidang Kesehatan</th>
                                    <th>Masa Berlaku</th>
                                    <th>Verifikasi</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!--END-->
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-warning btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdSIP">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas SIP</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-perizinan" id="tbSIP" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor SIP</th>
                                    <th>Nomor Reg STR</th>
                                    <th>Bidang Kesehatan</th>
                                    <th>Masa Berlaku</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-info btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdRiwayat">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas Riwayat Pekerjaan</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-perizinan" id="tbRiwayat" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Masa Berlaku</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!--END-->

                </div>
                <div class="tab-pane fade" id="identitas" role="tabpanel" aria-labelledby="identitas-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladd_Identitas">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas Data Diri</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-lain" id="tbLain" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="orientasi" role="tabpanel" aria-labelledby="orientasi-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-secondary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modal-add-orientasi">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Sertifikat</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-orientasi" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Tanggal Orientasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="spk" role="tabpanel" aria-labelledby="spk-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-secondary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modal-add-spk">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah SPK & RKK</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-spk" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor SPK</th>
                                    <th>Unit Kerja</th>
                                    <th>Kualifikasi</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="uraian" role="tabpanel" aria-labelledby="uraian-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-secondary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modal-add-uraian">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Uraian Tugas</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-uraian" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>Jabatan</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="lain" role="tabpanel" aria-labelledby="lain-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-secondary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modal-add-lain">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah File</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-lainlain" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Ijazah -->
    <div class="modal fade" id="modalUpload" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Ijazah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form method="POST" id="form-tambah-berkas" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik" id="nik" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}
                        <div class="form-group">
                            <label for="nama_file_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_id" id="nama_file_id" name="nama_file_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach

                            </select>

                        </div>
                        <div class="form-group">
                            <label for="nomor" class="col-form-label">Nomor<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor" id="nomor" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="asal" class="col-form-label">Asal<label class="text-danger">*</label></label>
                            <input type="text" class="form-control asal" id="asal" name="asal">
                        </div>
                        <div class="form-group">
                            <label for="thn_lulus" class="col-form-label">Tahun Lulus<label
                                    class="text-danger">*</label></label>
                            <input type="number" class="form-control thn_lulus" id="thn_lulus" name="thn_lulus">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span class="badge badge-secondary">.pdf
                                </span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-login" id="add_file">Simpan</button>
                            <button class="btn btn-primary btn-login-disabled d-none" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Berkas -->

    <!-- Modal Edit Ijazah -->
    <div class="modal fade" id="editmodalUpload" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Ijazah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form method="POST" id="form-update-berkas" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="form-control" id="id-ijazah-edit" name="id">
                        <input type="hidden" class="form-control" id="id-pegawai-edit" name="id_pegawai">
                        {{-- <input type="hidden" class="form-control" id="nik-edit" name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_id" id="nama-file-edit" name="nama_file_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor" class="col-form-label">Nomor<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor" id="nomor-edit" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="asal" class="col-form-label">Asal<label class="text-danger">*</label></label>
                            <input type="text" class="form-control asal" id="asal_edit" name="asal">
                        </div>
                        <div class="form-group">
                            <label for="thn_lulus" class="col-form-label">Tahun Lulus<label
                                    class="text-danger">*</label></label>
                            <input type="number" class="form-control thn_lulus" id="lulus-edit" name="thn_lulus">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file-edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="update_file">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Berkas -->

    <!-- Modal Tambah Transkrip Akademik -->
    <div class="modal fade" id="modaladdTrans" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Transkrip Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_trans"></div>
                    <form method="POST" id="form-tambah-trans" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik" id="nik" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}
                        <div class="form-group">
                            <label for="nama_file_trans_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_trans_id" id="nama_file_trans_id"
                                name="nama_file_trans_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_transkrip" class="col-form-label">Nomor Transkrip<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor_transkrip" id="nomor_transkrip"
                                name="nomor_transkrip">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_transkrip">Simpan</button>
                            <button type="submit" class="btn btn-primary d-none" id="add_transkrip_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Transkrip Akademik -->

    <!-- Modal Edit Transkrip Akademik -->
    <div class="modal fade" id="modaleditTrans" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Transkrip Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_trans_edit"></div>
                    <form method="POST" id="form-edit-trans" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="form-control" id="id-trans-edit" name="id">
                        <input type="hidden" class="form-control" id="id-trans-pegawai-edit" name="id_pegawai">
                        {{-- <input type="hidden" class="form-control" id="nik-trans-edit" name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_trans_id_edit" class="col-form-label">Nama Dokumen</label>
                            <select class="custom-select nama_file_trans_id_edit" id="nama_file_trans_id_edit"
                                name="nama_file_trans_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_transkrip_edit" class="col-form-label">Nomor Transkrip</label>
                            <input type="text" class="form-control nomor_transkrip_edit" id="nomor_transkrip_edit"
                                name="nomor_transkrip">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="update_trans">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Transkrip Akademik -->

    <!-- Modal Tambah STR -->
    <div class="modal fade" id="modaladdSTR" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Surat Tanda Registrasi (STR)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_str"></div>
                    <form method="POST" id="form-tambah-str" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai_str" id="id_pegawai_str" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_str" id="nik_str" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}
                        <div class="form-group">
                            <label for="nama_file_str_id" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_str_id" id="nama_file_str_id" name="nama_file_str_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_reg_str" class="col-form-label">Nomor Reg STR <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_reg_str" id="no_reg_str" name="no_reg_str">
                        </div>
                        <div class="form-group">
                            <label for="kompetensi" class="col-form-label">Kompetensi <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control kompetensi" id="kompetensi" name="kompetensi">
                        </div>


                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="enable_exp_str"
                                    name="enable_exp_str">
                                <label class="custom-control-label" for="enable_exp_str"><strong>Aktifkan Masa Berlaku
                                        STR</strong></label>
                            </div>
                        </div>
                        <div id="masa-berlaku"></div>



                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="add_str">Simpan</button>
                            <button type="submit" class="btn btn-warning d-none" id="add_str_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Tambah STR -->

    <!-- Modal Edit STR -->
    <div class="modal fade" id="modaleditSTR" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Surat Tanda Registrasi (STR)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_str_edit"></div>
                    <form method="POST" id="form-edit-str" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="id-str-edit" name="id">
                        <input type="hidden" class="form-control" id="id-str-pegawai-edit" name="id_pegawai">
                        {{-- <input type="hidden" class="form-control" id="nik-str-edit" name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_str_id_edit" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_str_id_edit" id="nama_file_str_id_edit"
                                name="nama_file_str_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_reg_str_edit" class="col-form-label">Nomor Reg STR <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_reg_str_edit" id="no_reg_str_edit"
                                name="no_reg_str">
                        </div>
                        <div class="form-group">
                            <label for="kompetensi_edit" class="col-form-label">Kompetensi <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control kompetensi" id="kompetensi_edit"
                                name="kompetensi">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="enable_exp_str_edit"
                                    name="enable_exp_str_edit">
                                <label class="custom-control-label" for="enable_exp_str_edit"><strong>Aktifkan Masa
                                        Berlaku STR</strong></label>
                            </div>
                        </div>
                        <div id="masa-berlaku-edit"></div>

                        <div class="form-group">
                            <label for="file_edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="add_str">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal STR -->

    <!-- Modal Tambah SIP -->
    <div class="modal fade" id="modaladdSIP" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Surat Izin Praktik (SIP)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_sip"></div>
                    <form method="POST" id="form-tambah-sip" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="id_pegawai_sip" id="id_pegawai_sip" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_sip" id="nik_sip" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_sip_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_sip_id" id="nama_file_sip_id" name="nama_file_sip_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_sip" class="col-form-label">Nomor SIP<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_sip" id="no_sip" name="no_sip">
                        </div>
                        <div class="form-group">
                            <label for="no_reg" class="col-form-label">Nomor Reg STR<label
                                    class="text-danger">*</label></label>
                            {{-- <select class="custom-select no_reg" id="no_reg" name="no_reg">
                                <option value="" selected>Choose...</option>
                                @foreach ($file_str as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_reg_str }}</option>
                                @endforeach
                            </select> --}}
                            <select class="form-select select-str" id="no_reg" name="no_reg"></select>
                        </div>
                        <div class="form-group">
                            <label for="filesip" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control filesip" id="filesip" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="add_sip">Simpan</button>
                            <button type="submit" class="btn btn-warning d-none" id="add_sip_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Tambah STR -->

    <!-- Modal Edit SIP -->
    <div class="modal fade" id="modaleditSIP" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Surat Izin Praktik (SIP)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_sip_edit"></div>
                    <form method="POST" id="form-edit-sip" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" class="id_pegawai_sip" id="id_pegawai_sip_edit" value="{{ $pegawai->id }}"
                         name="id_pegawai">
                     <input type="hidden" class="nik_sip" id="nik_sip_edit" value="{{ $pegawai->nik }}"
                         name="nik_pegawai"> --}}
                        <input type="hidden" class="id-sip-edit" id="id-sip-edit" name="id">

                        <div class="form-group">
                            <label for="nama_file_sip_id_edit" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_sip_id_edit" id="nama_file_sip_id_edit"
                                name="nama_file_sip_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_sip_edit" class="col-form-label">Nomor SIP<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_sip_edit" id="no_sip_edit" name="no_sip">
                        </div>
                        <div class="form-group">
                            <label for="no_reg_sip_edit" class="col-form-label">Nomor Reg STR<label
                                    class="text-danger">*</label></label>
                            {{-- <select class="custom-select no_reg_sip_edit" id="no_reg_sip_edit" name="no_reg">
                                <option value="" selected>Choose...</option>
                                @foreach ($file_str as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_reg_str }}</option>
                                @endforeach
                            </select> --}}
                            <select class="form-select select-str-edit" id="no_reg_sip_edit" name="no_reg"></select>
                        </div>
                        <div class="form-group">
                            <label for="filesip" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control filesip" id="filesip" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="submit_edit_sip">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Tambah SIP -->

    <!-- Modal Tambah Berkas Data Diri -->
    <div class="modal fade" id="modaladd_Identitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Data Diri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_lain"></div>
                    <form method="POST" id="form-tambah-lain" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="id_pegawai_lain" id="id_pegawai_lain" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_lain" id="nik_lain" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_lain_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_lain_id" id="nama_file_lain_id"
                                name="nama_file_lain_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_identitas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filelain" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filelain" id="filelain" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add_lain">Simpan</button>
                            <button type="submit" class="btn btn-success d-none" id="add_lain_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Berkas Data Diri -->
    <div class="modal fade" id="modaledit_Identitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_lain_edit"></div>
                    <form method="POST" id="form-edit-lain" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id-lain-edit" name="id">
                        <div class="form-group">
                            <label for="nama_file_lain_id_edit" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_lain_id_edit" id="nama_file_lain_id_edit"
                                name="nama_file_lain_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_identitas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filelain_edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filelain_edit" id="filelain_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="submit_edit_lain">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal-->

    <!-- Modal Tambah Riwayat Pekerjaan -->
    <div class="modal fade" id="modaladdRiwayat" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Riwayat Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_rw"></div>
                    <form method="POST" id="form-tambah-rw" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="id_pegawai_rw" id="id_pegawai_rw" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_rw" id="nik_rw" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_riwayat_id" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_riwayat_id" id="nama_file_riwayat_id"
                                name="nama_file_riwayat_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_perjanjian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_rw" class="col-form-label">Nomor <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor_rw" id="nomor_rw" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="tgl_ed" class="col-form-label">Berkalu Sampai</label>
                            <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat" class="col-form-label">Pengingat</label>
                            <input type="date" class="form-control pengingat" id="pengingat" name="pengingat">
                        </div>
                        <div class="form-group">
                            <label for="filerw" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filerw" id="filerw" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="add_lain">Simpan</button>
                            <button type="submit" class="btn btn-info d-none" id="add_lain_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Riwayat Pekerjaan -->
    <div class="modal fade" id="modaleditRiwayat" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Riwayat Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_rw_edit"></div>
                    <form method="POST" id="form-edit-riwayat" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id-riwayat-edit" id="id-riwayat-edit" name="id">
                        <input type="hidden" class="id_pegawai_rw_edit" id="id_pegawai_rw_edit"
                            value="{{ $pegawai->id }}" name="id_pegawai">
                        {{-- <input type="hidden" class="nik_rw_edit" id="nik_rw_edit" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_riwayat_id_edit" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_riwayat_id_edit" id="nama_file_riwayat_id_edit"
                                name="nama_file_riwayat_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_perjanjian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_rw_edit" class="col-form-label">Nomor <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor_rw_edit" id="nomor_rw_edit"
                                name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="tgl_ed_rw_edit" class="col-form-label">Berkalu Sampai</label>
                            <input type="date" class="form-control tgl_ed_rw_edit" id="tgl_ed_rw_edit"
                                name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label>
                            <input type="date" class="form-control pengingat_rw_edit" id="pengingat_rw_edit"
                                name="pengingat">
                        </div>
                        <div class="form-group">
                            <label for="filerw" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filerw" id="filerw" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="add_lain">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah Orientasi -->
    <div class="modal fade" id="modal-add-orientasi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat / Evaluasi Orientasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_ori"></div>
                    <form method="POST" id="form-tambah-orientasi" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_orientasi"
                            value="{{ $pegawai->id }}" name="id_pegawai">
                        <div class="form-group">
                            <label for="nama_file_ori" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select" id="nama_file_ori" name="nama_file_ori">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_orientasi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_orientasi" class="col-form-label">Nomor<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="nomor_orientasi" name="nomor_orientasi">
                        </div>
                        <div class="form-group">
                            <label for="tgl_mulai" class="col-form-label">Tanggal Mulai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tgl_selesai" class="col-form-label">Tanggal Selesai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        </div>
                        <div class="form-group">
                            <label for="file_orientasi" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file_orientasi" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_ori">Simpan</button>
                            <button type="submit" class="btn btn-primary d-none" id="add_ori_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Orientasi -->
    <div class="modal fade" id="modal-edit-orientasi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sertifikat / Evaluasi Orientasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_ori_edit"></div>
                    <form method="POST" id="form-edit-orientasi" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_orientasi_edit" name="id_pegawai">
                        <input type="hidden" class="id_orientasi" id="id_orientasi" name="id_orientasi">
                        <div class="form-group">
                            <label for="nama_file_ori_edit" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select" id="nama_file_ori_edit" name="nama_file_ori">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_orientasi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_orientasi_edit" class="col-form-label">Nomor<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="nomor_orientasi_edit"
                                name="nomor_orientasi">
                        </div>
                        <div class="form-group">
                            <label for="tgl_mulai_edit" class="col-form-label">Tanggal Mulai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_mulai_edit" name="tgl_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tgl_selesai_edit" class="col-form-label">Tanggal Selesai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_selesai_edit" name="tgl_selesai">
                        </div>
                        <div class="form-group">
                            <label for="file_orientasi_edit" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file_orientasi_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="edit_ori">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah Berkas Lain-lain -->
    <div class="modal fade" id="modal-add-lain" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Lain-Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_lainlain"></div>
                    <form method="POST" id="form-tambah-lainlain" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_pegawai_lain" value="{{ $pegawai->id }}" name="id_pegawai">
                        <div class="form-group">
                            <label for="nama_file_id_lainlain" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select" id="nama_file_id_lainlain" name="nama_file_id_lainlain">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_lain as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file-lainlain" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-lainlain" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add_lainlain">Simpan</button>
                            <button type="submit" class="btn btn-success d-none" id="add_lainlain_disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Berkas Lain-lain -->
    <div class="modal fade" id="modal-edit-lain" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Lain-Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_lainlain_edit"></div>
                    <form method="POST" id="form-edit-lainlain" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_lain_lain" name="id_lain">
                        <div class="form-group">
                            <label for="nama_file_id_lainlain_edit" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select" id="nama_file_id_lainlain_edit"
                                name="nama_file_id_lainlain">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_lain as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file-lainlain-edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-lainlain-edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="submit_edit_lain">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah Verifikasi Ijazah -->
    <div class="modal fade" id="modal-add-bukti" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti Verifikasi Ijazah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_bukti"></div>
                    <form method="POST" id="form-tambah-bukti" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id-ijazah-bukti" name="ijazah_id">
                        <div class="form-group">
                            <label for="file-bukti" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-bukti" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <div class="form-group">
                            <label for="ket-bukti" class="col-form-label">Keterangan</label>
                            <input type="text" class="form-control" id="ket-bukti" name="ket_bukti">
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add_bukti">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah Verifikasi STR -->
    <div class="modal fade" id="modal-add-bukti-str" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti Verifikasi STR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_bukti_str"></div>
                    <form method="POST" id="form-tambah-bukti-str" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id-str-bukti" name="str_id">
                        <div class="form-group">
                            <label for="file-bukti-str" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-bukti-str" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <div class="form-group">
                            <label for="ket-bukti-str" class="col-form-label">Keterangan</label>
                            <input type="text" class="form-control" id="ket-bukti-str" name="ket_bukti">
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add_bukti_str">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah SPK RKK -->
    <div class="modal fade" id="modal-add-spk" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah SPK & RKK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_spk"></div>
                    <form method="POST" id="form-tambah-spk" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_pegawai_spk" value="{{ $pegawai->id }}" name="id_pegawai">
                        <div class="form-group">
                            <label for="no-spk" class="col-form-label">Nomor SPK <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="no-spk" name="no_spk">
                        </div>
                        <div class="form-group">
                            <label for="dep-spk" class="col-form-label">Unit Kerja <label
                                    class="text-danger">*</label></label>
                            {{-- <select class="custom-select" id="dep-spk" name="dep_spk">
                            <option value="" selected>Choose...</option>
                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select> --}}
                            <select class="form-select select2 select-unit-kerja" id="dep-spk" name="dep_spk"
                                data-placeholder="Pilih Unit Kerja">
                                <option value="">-- Pilih --</option>
                                @foreach ($deparetemen as $item)
                                    <option value="{{ $item->dep_id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kualifikasi" class="col-form-label">Kualifikasi <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="kualifikasi" name="kualifikasi">
                        </div>
                        <div class="form-group">
                            <label for="file-spk" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-spk" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>

                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-spk">Simpan</button>
                            <button type="submit" class="btn btn-success d-none" id="add-spk-disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit SPK RKK -->
    <div class="modal fade" id="modal-edit-spk" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit SPK & RKK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_spk_edit"></div>
                    <form method="POST" id="form-edit-spk" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_pegawai_spk_edit" name="id_pegawai">
                        <input type="hidden" id="id_spk_edit" name="id">

                        <div class="form-group">
                            <label for="no-spk-edit" class="col-form-label">Nomor SPK <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="no-spk-edit" name="no_spk">
                        </div>
                        <div class="form-group">
                            <label for="dep-spk-edit" class="col-form-label">Unit Kerja <label
                                    class="text-danger">*</label></label>
                            <select class="form-select select2 select-unit-kerja-edit" id="dep-spk-edit"
                                name="dep_spk" data-placeholder="Pilih Unit Kerja">
                                @foreach ($deparetemen as $item)
                                    <option value="{{ $item->dep_id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kualifikasi-edit" class="col-form-label">Kualifikasi <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="kualifikasi-edit" name="kualifikasi">
                        </div>
                        <div class="form-group">
                            <label for="file-spk-edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-spk-edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>

                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-spk-edit">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah Uraian -->
    <div class="modal fade" id="modal-add-uraian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Uraian Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_uraian"></div>
                    <form method="POST" id="form-tambah-uraian" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_pegawai_uraian" value="{{ $pegawai->id }}" name="id_pegawai">
                        <div class="form-group">
                            <label for="dep-uraian">Unit Kerja <label class="text-danger">*</label></label>
                            <select class="form-select select2 select-departemen" id="dep-uraian"
                                data-placeholder="Pilih Unit Kerja" name="dep_uraian">

                                @foreach ($deparetemen as $item)
                                    <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan" class="col-form-label">Jabatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan">
                        </div>
                        <div class="form-group">
                            <label for="file-uraian" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-uraian" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>

                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-uraian">Simpan</button>
                            <button type="submit" class="btn btn-success d-none" id="add-uraian-disabled" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Uraian -->
    <div class="modal fade" id="modal-edit-uraian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Uraian Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_uraian_edit"></div>
                    <form method="POST" id="form-edit-uraian" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_uraian" name="id">
                        <input type="hidden" id="id_pegawai_uraian_edit" name="id_pegawai">
                        <div class="form-group">
                            <label for="dep-uraian-edit">Unit Kerja <label class="text-danger">*</label></label>
                            <select class="form-select select2 select-departemen-edit" id="dep-uraian-edit"
                                data-placeholder="Pilih Unit Kerja" name="dep_uraian">

                                @foreach ($deparetemen as $item)
                                    <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan-edit" class="col-form-label">Jabatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="jabatan-edit" name="jabatan">
                        </div>
                        <div class="form-group">
                            <label for="file-uraian-edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-uraian-edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>

                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-uraian">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->



    <!-- Modal View Ijzah PDF -->
    <div class="modal fade " id="modalIjazah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ijazah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-ijazah-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Transkrip PDF -->
    <div class="modal fade " id="modalTranskrip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trannskrip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-transkrip-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View STR PDF -->
    <div class="modal fade " id="modalSTR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Surat Tanda Registrasi (STR)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-str-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View SIP PDF -->
    <div class="modal fade " id="modalSIP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Surat Izin Praktik (SIP)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-sip-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Riwayat PDF -->
    <div class="modal fade " id="modalRiwayat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dokumen Riwayat Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-riwayat-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Identitas PDF -->
    <div class="modal fade " id="modalLain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Berkas Identitas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-lain-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View orinetasi PDF -->
    <div class="modal fade " id="modal-orientasi" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sertifikat Orientasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-ori-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Lain-lain PDF -->
    <div class="modal fade " id="modal-lainlain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Berkas Lain-Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-lainlain-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Bukti Verifikasi Ijazah PDF -->
    <div class="modal fade " id="modal-verijazah" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bukti Verifikasi Ijazah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapsepdf" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        File Bukti Verifikasi
                                    </button>
                                </h2>
                            </div>

                            <div id="collapsepdf" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div id="view-verijazah-modal"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseKet" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Keteranagan / Catatatan
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseKet" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p id="ket-verif-ijazah"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Bukti Verifikasi Ijazah PDF -->
    <div class="modal fade " id="modal-verstr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bukti Verifikasi STR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapsepdfstr" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        File Bukti Verifikasi
                                    </button>
                                </h2>
                            </div>

                            <div id="collapsepdfstr" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div id="view-verstr-modal"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseKetstr" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Keteranagan / Catatatan
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseKetstr" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p id="ket-verif-str"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View SPK PDF -->
    <div class="modal fade " id="modal-view-spk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Berkas Surat Penugsan Klinik & RINCIAN KEWENANGAN
                        KLINIS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-spk-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Uraian Tugas PDF -->
    <div class="modal fade " id="modal-view-uraian" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Berkas Uraian Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-uraian-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Tambah Verifikasi SIP -->
    <div class="modal fade" id="modal-add-masa-berlaku" data-backdrop="static" data-keyboard="false"
        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Masa Berlaku SIP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_berlaku_sip"></div>
                    <form method="POST" id="form-masa-berlaku-sip" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="sip_id_masa_berlaku" name="sip_id_masa_berlaku">
                        <div class="form-group">
                            <label for="tgl_ed_sip" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed_sip" id="tgl_ed_sip" name="tgl_ed_sip">
                        </div>
                        <div class="form-group">
                            <label for="pengingat_sip" class="col-form-label">Tgl Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat_sip" id="pengingat_sip"
                                name="pengingat_sip">
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add_masa_berlaku">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->



@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>
        document.getElementById('enable_exp_str').onchange = function() {
            if (this.checked) {
                document.getElementById('masa-berlaku').innerHTML = `
                        <div class="form-group">
                            <label for="tgl_ed" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed" disabled>
                        </div>
                        <div class="form-group">
                            <label for="pengingat" class="col-form-label">Tgl Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat" id="pengingat" name="pengingat" disabled>
                        </div>
                `
            } else {
                document.getElementById('masa-berlaku').innerHTML = ``
            }
            document.getElementById('tgl_ed').disabled = !this.checked;
            //document.getElementById("tgl_ed").required = this.checked;
            document.getElementById('pengingat').disabled = !this.checked;
            //document.getElementById("pengingat").required = this.checked;
        };
        document.getElementById('enable_exp_str_edit').onchange = function() {
            if (this.checked) {
                document.getElementById('masa-berlaku-edit').innerHTML = `
                        <div class="form-group">
                            <label for="tgl_ed_edit" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed_edit" id="tgl_ed_edit" name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat_edit" class="col-form-label">Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat_edit" id="pengingat_edit"
                                name="pengingat">
                        </div>
                `
            } else {
                document.getElementById('masa-berlaku-edit').innerHTML = ``
            }
            document.getElementById('tgl_ed_edit').disabled = !this.checked;
            //document.getElementById("tgl_ed").required = this.checked;
            document.getElementById('pengingat_edit').disabled = !this.checked;
            //document.getElementById("pengingat").required = this.checked;
        };
    </script>
    <!-- Page level custom scripts -->
    <!--Ijazah------------------->
    @include('pages.Karyawan.js.ijazah')
    <!--Transkrip------------------->
    @include('pages.Karyawan.js.transkrip')

    <!--str------------------->
    @include('pages.Karyawan.js.str')

    <!--SIP------------------->
    @include('pages.Karyawan.js.sip')

    <!--Riwayat kerja------------------->
    @include('pages.Karyawan.js.riwayatkerja')

    <!--Identitas------------------->
    @include('pages.Karyawan.js.identitas')

    <!--Orientasi------------------->
    @include('pages.Karyawan.js.orientasi')

    <!--Lain-Lain------------------->
    @include('pages.Karyawan.js.lain-lain')

    <!--SPK RKK ------------------>
    @include('pages.Karyawan.js.spk-rkk')

    <!--Uraian ------------------>
    @include('pages.Karyawan.js.uraian')
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
