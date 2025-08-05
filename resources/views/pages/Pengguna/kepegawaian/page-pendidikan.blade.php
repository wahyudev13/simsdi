@extends('layouts.app')
@section('title', 'Data Pendidikan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-pendidikan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pendidikan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <!-- Ijazah -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-ijazah-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modal-add-ijazah">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas Ijazah</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                @can('user-ijazah-view')
                    <input type="hidden" class="id-pegawai" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-ijazah" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Asal</th>
                                    <th>Tahun Lulus</th>
                                    <th>Verifikasi</th>
                                    <th>Update</th>
                                    @if (auth()->user()->can('user-ijazah-view') ||
                                            auth()->user()->can('user-ijazah-edit') ||
                                            auth()->user()->can('user-ijazah-delete'))
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end-->
                @else
                    <div class="alert alert-warning mt-2">Anda tidak memiliki akses untuk melihat data ijazah.</div>
                @endcan
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    <!-- Transkrip -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-transkrip-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modal-add-transkrip">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas Transkrip</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                @can('user-transkrip-view')
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-transkrip" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Update</th>
                                    @if (auth()->user()->can('user-transkrip-view') ||
                                            auth()->user()->can('user-transkrip-edit') ||
                                            auth()->user()->can('user-transkrip-delete'))
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end-->
                @else
                    <div class="alert alert-warning mt-2">Anda tidak memiliki akses untuk melihat data transkrip.</div>
                @endcan
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    @include('components.modals-add-update.modal-kepegawaian.modal-pendidikan')
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    @include('components.script-berkas-kepegawaian.pendidikan-script', [
        //ijazah
        'tableIjazahId' => 'tb-ijazah',
        'ijazahRoute' => 'pengguna.getijazah',
        'ijazahStoreRoute' => 'pengguna.ijazah.store',
        'ijazahEditRoute' => 'pengguna.ijazah.edit',
        'ijazahUpdateRoute' => 'pengguna.ijazah.update',
        'ijazahDestroyRoute' => 'pengguna.ijazah.destroy',
        //transkrip
        'tableTranskripId' => 'tb-transkrip',
        'transkripRoute' => 'pengguna.gettrans',
        'transkripStoreRoute' => 'pengguna.trans.store',
        'transkripEditRoute' => 'pengguna.trans.edit',
        'transkripUpdateRoute' => 'pengguna.trans.update',
        'transkripDestroyRoute' => 'pengguna.trans.destroy',
        //pdf
        'routeIjazahPDF' => '/pengguna/ijazah/view/',
        'routeTranskripPDF' => '/pengguna/transkrip/view/',
        'aksesPage' => 'user',
    ]);
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
