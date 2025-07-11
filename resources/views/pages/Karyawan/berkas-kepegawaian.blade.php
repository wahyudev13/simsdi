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

    <!-- Include Modal Components -->
    @include('components.modal-ijazah')
    @include('components.modal-transkrip')
    @include('components.modal-str')
    @include('components.modal-sip')
    @include('components.modal-riwayat')
    @include('components.modal-identitas')
    @include('components.modal-orientasi')
    @include('components.modal-spk')
    @include('components.modal-uraian')
    @include('components.modal-lain')
    @include('components.modal-verifikasi')
    @include('components.modal-view')
    @include('components.modal-bukti-str')

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>

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
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">

    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
