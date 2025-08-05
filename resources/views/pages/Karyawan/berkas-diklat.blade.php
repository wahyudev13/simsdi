@extends('layouts.app')
@section('title', 'Dokumen Diklat')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Dokumen Diklat</h1>

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

                            <i class="fas fa-user-graduate fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="sertif-tab" data-toggle="tab" data-target="#sertif" type="button"
                        role="tab" aria-controls="sertif" aria-selected="true">Sertifikat Pelatihan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inhouse-tab" data-toggle="tab" data-target="#inhouse" type="button"
                        role="tab" aria-controls="berkala" aria-selected="false">Riwayat Pelatihan IHT</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="sertif" role="tabpanel" aria-labelledby="sertif-tab">

                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladd_sertif">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Sertifikat</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-sertifikat" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sertifikat</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tgl Kegiatan</th>
                                    <th>Tempat Kegiatan</th>
                                    <th>Penyelenggara</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane fade show" id="inhouse" role="tabpanel" aria-labelledby="inhouse-tab">
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        {{-- <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label> --}}
                                        <input type="date" class="form-control from_date" id="from_date"
                                            name="from_date">
                                    </div>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <label for="" class="col-form-label">S/D</label>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        {{-- <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label> --}}
                                        <input type="date" class="form-control to_date" id="to_date" name="to_date">
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="filter"><i
                                                class="fas fa-filter"></i></button>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-warning" id="refresh"><i
                                                class="fas fa-sync-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tb-riwayat-iht" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Karyawan</th>
                                                <th>Unit Penyelenggara</th>
                                                <th>Kegiatan</th>
                                                <th>Tempat</th>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                {{-- <th>Total Waktu (jam)</th> --}}
                                                <th>Poin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            {{-- <tr class="table-info">
                                                <th colspan="8" class="text-right">Total Jam Diklat</th>
                                                <th class="total"></th>
                                            </tr> --}}
                                            <tr class="table-info">
                                                <th colspan="7" class="text-right">Total Poin Diklat</th>
                                                <th class="poin"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.container-fluid -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    @include('components.modals-add-update.modal-diklat.modal-sertifikat-diklat')
    @include('components.modals.modal-sertifikat-diklat-view')
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <!--Button Dattable-->
    <script src="{{ asset('/vendor/datatables/button/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.print.min.js') }}"></script>
    <!--SUM Datatable-->
    <script src="{{ asset('/vendor/datatables/button/js/sum().js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/plug-ins/1.13.1/api/sum().js"></script> --}}

    <script>
        // Script untuk menyimpan dan memulihkan tab aktif (seperti berkas-kepegawaian)
        document.addEventListener('DOMContentLoaded', function() {
            const loadedTabs = new Set();

            function saveActiveTab(tabId) {
                localStorage.setItem('activeTabDiklat', tabId);
            }

            function restoreActiveTab() {
                const activeTabId = localStorage.getItem('activeTabDiklat');
                if (activeTabId) {
                    document.querySelectorAll('.nav-link').forEach(tab => {
                        tab.classList.remove('active');
                        tab.setAttribute('aria-selected', 'false');
                    });
                    document.querySelectorAll('.tab-pane').forEach(content => {
                        content.classList.remove('show', 'active');
                    });
                    const targetTab = document.querySelector(`[data-target="${activeTabId}"]`);
                    const targetContent = document.querySelector(activeTabId);
                    if (targetTab && targetContent) {
                        targetTab.classList.add('active');
                        targetTab.setAttribute('aria-selected', 'true');
                        targetContent.classList.add('show', 'active');
                        window.tabToReloadAfterReady = activeTabId;
                    }
                }
            }

            function loadTabData(tabId) {
                if (loadedTabs.has(tabId)) return;
                loadedTabs.add(tabId);
                const event = new CustomEvent('loadTabData', {
                    detail: {
                        tabId: tabId
                    }
                });
                document.dispatchEvent(event);
            }
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('data-target');
                    saveActiveTab(targetId);
                    loadTabData(targetId);
                });
            });
            restoreActiveTab();
            if (!localStorage.getItem('activeTabDiklat')) {
                setTimeout(() => {
                    const firstTab = document.querySelector('.nav-link.active');
                    if (firstTab) {
                        const targetId = firstTab.getAttribute('data-target');
                        loadTabData(targetId);
                    }
                }, 100);
            }
        });
    </script>
    <!--Sertifikat Diklat------------------->
    @include('pages.Karyawan.js.diklat.sertifikat-diklat')
    <!--Riwayat Pelatihan IHT------------------->
    @include('pages.Karyawan.js.diklat.riwayat-iht')
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>

    <link href="{{ asset('/vendor/datatables/button/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush
