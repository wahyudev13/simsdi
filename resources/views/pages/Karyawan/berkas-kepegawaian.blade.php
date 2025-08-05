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
                <!-- Data Pendidikan -->
                <div class="tab-pane fade show active" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modal-add-ijazah">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas Ijazah</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-pendidikan" id="tb-ijazah" width="100%"
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
                            data-target="#modal-add-transkrip">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Berkas Transkrip</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-pendidikan" id="tb-transkrip" width="100%"
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
                <!-- Data Perizinan -->
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
                <!-- Data Riwayat Pekerjaan -->
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
                <!-- Data Diri Karyawan -->
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
                        <table class="table table-bordered berkas-lain" id="tbIdentitas" width="100%" cellspacing="0">
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
                <!-- Data Orientasi -->
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
                <!-- Data SPK & RKK -->
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
                <!-- Data Uraian Tugas -->
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
                <!-- Data Lain-Lain -->
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
    @include('components.modals-add-update.modal-kepegawaian.modal-pendidikan')
    @include('components.modals-add-update.modal-kepegawaian.modal-str')
    @include('components.modals-add-update.modal-kepegawaian.modal-sip')
    @include('components.modals-add-update.modal-kepegawaian.modal-riwayat')
    @include('components.modals-add-update.modal-kepegawaian.modal-identitas')
    @include('components.modals-add-update.modal-kepegawaian.modal-orientasi')
    @include('components.modals-add-update.modal-kepegawaian.modal-spk')
    @include('components.modals-add-update.modal-kepegawaian.modal-uraian')
    @include('components.modals-add-update.modal-kepegawaian.modal-lain')
    @include('components.modals-add-update.modal-kepegawaian.modal-verifikasi')
    @include('components.modal-view')

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>

    <script>
        // Script untuk menyimpan dan memulihkan tab aktif
        document.addEventListener('DOMContentLoaded', function() {
            // Variabel untuk melacak tab yang sudah di-load
            const loadedTabs = new Set();

            // Fungsi untuk menyimpan tab aktif ke localStorage
            function saveActiveTab(tabId) {
                localStorage.setItem('activeTabKepegawaian', tabId);
            }

            // Fungsi untuk memulihkan tab aktif dari localStorage
            function restoreActiveTab() {
                const activeTabId = localStorage.getItem('activeTabKepegawaian');
                console.log('Restoring tab from localStorage:', activeTabId);
                if (activeTabId) {
                    // Hapus kelas active dari semua tab dan content
                    document.querySelectorAll('.nav-link').forEach(tab => {
                        tab.classList.remove('active');
                        tab.setAttribute('aria-selected', 'false');
                    });
                    document.querySelectorAll('.tab-pane').forEach(content => {
                        content.classList.remove('show', 'active');
                    });

                    // Aktifkan tab yang tersimpan
                    const targetTab = document.querySelector(`[data-target="${activeTabId}"]`);
                    const targetContent = document.querySelector(activeTabId);

                    if (targetTab && targetContent) {
                        targetTab.classList.add('active');
                        targetTab.setAttribute('aria-selected', 'true');
                        targetContent.classList.add('show', 'active');

                        // Simpan tab yang perlu di-load ulang setelah semua JS siap
                        window.tabToReloadAfterReady = activeTabId;
                    }
                }
            }

            // Fungsi untuk load data berdasarkan tab
            function loadTabData(tabId) {
                console.log('loadTabData called for:', tabId);
                if (loadedTabs.has(tabId)) {
                    console.log('Tab already loaded:', tabId);
                    return; // Data sudah di-load
                }

                // Tambahkan ke set tab yang sudah di-load
                loadedTabs.add(tabId);
                console.log('Loading tab:', tabId);

                // Trigger custom event untuk load data berdasarkan tab
                const event = new CustomEvent('loadTabData', {
                    detail: {
                        tabId: tabId
                    }
                });
                document.dispatchEvent(event);
            }

            // Event listener untuk setiap tab
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('data-target');
                    saveActiveTab(targetId);

                    // Load data untuk tab yang diklik
                    loadTabData(targetId);
                });
            });

            // Reset localStorage untuk pengujian (sementara)
            // localStorage.removeItem('activeTabKepegawaian');

            // Pulihkan tab aktif saat halaman dimuat
            restoreActiveTab();

            // Jika tidak ada tab yang tersimpan di localStorage, load tab pertama
            if (!localStorage.getItem('activeTabKepegawaian')) {
                // Tunggu sebentar untuk memastikan semua event listener sudah terpasang
                setTimeout(() => {
                    // Panggil loadTabData untuk tab pertama
                    const firstTab = document.querySelector('.nav-link.active');
                    console.log('First tab detected:', firstTab ? firstTab.getAttribute('data-target') :
                        'none');
                    if (firstTab) {
                        const targetId = firstTab.getAttribute('data-target');
                        // Pastikan tab pertama di-load
                        loadTabData(targetId);
                    }
                }, 100);
            }
        });

        // Script untuk STR masa berlaku
        document.addEventListener('DOMContentLoaded', function() {
            const enableExpStr = document.getElementById('enable_exp_str');
            const enableExpStrEdit = document.getElementById('enable_exp_str_edit');

            if (enableExpStr) {
                enableExpStr.onchange = function() {
                    if (this.checked) {
                        document.getElementById('masa-berlaku').innerHTML = `
                                <div class="form-group">
                                    <label for="tgl_ed" class="col-form-label">Berlaku Sampai <label
                                            class="text-danger">*</label></label>
                                    <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed" disabled>
                                </div>
                                
                        `
                    } else {
                        document.getElementById('masa-berlaku').innerHTML = ``
                    }
                    const tglEd = document.getElementById('tgl_ed');
                    if (tglEd) tglEd.disabled = !this.checked;
                };
            }

            if (enableExpStrEdit) {
                enableExpStrEdit.onchange = function() {
                    if (this.checked) {
                        document.getElementById('masa-berlaku-edit').innerHTML = `
                                <div class="form-group">
                                    <label for="tgl_ed_edit" class="col-form-label">Berlaku Sampai <label
                                            class="text-danger">*</label></label>
                                    <input type="date" class="form-control tgl_ed_edit" id="tgl_ed_edit" name="tgl_ed">
                                </div>
                              
                        `
                    } else {
                        document.getElementById('masa-berlaku-edit').innerHTML = ``
                    }
                    const tglEdEdit = document.getElementById('tgl_ed_edit');
                    if (tglEdEdit) tglEdEdit.disabled = !this.checked;
                };
            }
        });
    </script>
    <!-- Page level custom scripts -->
    <!--Pendidikan (Ijazah & Transkrip)------------------->
    @include('pages.Karyawan.js.kepegawaian.pendidikan')

    <!--str------------------->
    @include('pages.Karyawan.js.kepegawaian.str')

    <!--SIP------------------->
    @include('pages.Karyawan.js.kepegawaian.sip')

    <!--Riwayat kerja------------------->
    @include('pages.Karyawan.js.kepegawaian.riwayat-kerja')

    <!--Identitas------------------->
    @include('pages.Karyawan.js.kepegawaian.identitas')

    <!--Orientasi------------------->
    @include('pages.Karyawan.js.kepegawaian.orientasi')

    <!--SPK RKK ------------------>
    @include('pages.Karyawan.js.kepegawaian.spk-rkk')

    <!--Uraian ------------------>
    @include('pages.Karyawan.js.kepegawaian.uraian')

    <!--Lain-Lain------------------->
    @include('pages.Karyawan.js.kepegawaian.lain-lain')


    <script>
        // Tambahan agar event loadTabData dipanggil ulang setelah semua JS siap
        $(document).ready(function() {
            if (window.tabToReloadAfterReady) {
                setTimeout(function() {
                    if (typeof window.loadTabData === 'function') {
                        window.loadTabData(window.tabToReloadAfterReady);
                    }
                }, 100);
            }
        });
    </script>
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
