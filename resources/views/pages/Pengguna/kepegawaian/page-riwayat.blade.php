@extends('layouts.app')
@section('title', 'Data Riwayat Pekerjaan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-riwayat', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Riwayat Pekerjaan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
        <div class="card-header py-3">
            @can('user-riwayat-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdRiwayat">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas Riwayat Pekerjaan</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                @can('user-riwayat-view')
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered berkas-perizinan" id="tbRiwayat" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama File</th>
                                        <th>Nomor</th>
                                        <th>Berlaku Sampai</th>
                                        <th>Update</th>
                                        @if (auth()->user()->can('user-riwayat-view') ||
                                                auth()->user()->can('user-riwayat-edit') ||
                                                auth()->user()->can('user-riwayat-delete'))
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning mt-2">Anda tidak memiliki akses untuk melihat data</div>
                @endcan
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
    @include('components.modals-add-update.modal-kepegawaian.modal-riwayat')
    @include('components.modals.modal-riwayat-view')


@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    @include('components.script-berkas-kepegawaian.riwayat-script', [
        'tableId' => 'tbRiwayat',
        'riwayatRoute' => 'pengguna.getRiwayat',
        'riwayatStoreRoute' => 'pengguna.riwayat.store',
        'riwayatEditRoute' => 'pengguna.riwayat.edit',
        'riwayatUpdateRoute' => 'pengguna.riwayat.update',
        'riwayatDestroyRoute' => 'pengguna.riwayat.destroy',
        'riwayatStatusRoute' => 'pengguna.riwayat.update.status',
        'enablePaging' => false,
        'enableSearch' => false,
        'enableInfo' => false,
        'showActions' => true,
        'showStatusActions' => true,
        'modalParent' => 'modaladdRiwayat',
        'editModalParent' => 'modaleditRiwayat',
        'aksesPage' => 'user',
        'permissions' => [
            'view' => auth()->user()->can('user-riwayat-view'),
            'edit' => auth()->user()->can('user-riwayat-edit'),
            'delete' => auth()->user()->can('user-riwayat-delete'),
        ],
        'routePDF' => '/pengguna/riwayat/view/',
    ])
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
