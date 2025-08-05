@extends('layouts.app')
@section('title', 'Penilaian Kerja')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Penilaian Kerja</h1>

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

                            <i class="fas fa-user-edit fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="button-add mb-4">
                <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                    data-target="#modal-add-penilaian">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Penilaian</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="tb-penilaian" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Penilaian</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Total Nilai</th>
                            <th>Keteranagan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    @include('components.modals-add-update.modal-penilaian.modal-penilaian-kerja');
    @include('components.modals.modal-penilaian-kerja-view');

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>

    @include('pages.Karyawan.js.penilaian.penilaian')
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">

    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
