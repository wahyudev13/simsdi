@extends('layouts.app')
@section('title', 'Data Perizinan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-izin', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Perizinan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
        <div class="card-header py-3">
            @can('user-str-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdSTR">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas STR</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-perizinan" id="tbSTR" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor REG</th>
                                <th>Bidang Kesehatan</th>
                                <th>Masa Berlaku</th>
                                <th>Verifikasi</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-str-view') ||
                                        auth()->user()->can('user-str-edit') ||
                                        auth()->user()->can('user-str-delete'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    {{-- SIP --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-sip-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdSIP">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas SIP</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-perizinan" id="tbSIP" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor SIP</th>
                                <th>Nomor Reg STR</th>
                                <th>Bidang Kesehatan</th>
                                <th>Masa Berlaku</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-sip-view') ||
                                        auth()->user()->can('user-sip-edit') ||
                                        auth()->user()->can('user-sip-delete'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    <!-- Modal STR -->
    @include('components.modal-str')
    @include('components.modal-sip')
    @include('components.modal-verifikasi')
    @include('components.modals.modal-str-view')
    @include('components.modals.modal-sip-view')
    @include('components.modals.modal-verifikasi-str-view')
    @include('components.modal-bukti-str')

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select-str').select2({
                minimumResultsForSearch: -1,
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('pengguna.str.get') }}',
                    dataType: 'json',
                    // data: function(params) {
                    //     var query = {
                    //         search: params.term,
                    //     }

                    //     // Query parameters will be ?search=[term]&type=public
                    //     return query;
                    // },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaladdSIP",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                //placeholder: $(this).data('placeholder'),

            });

            $('.select-str-edit').select2({
                //minimumInputLength: 3,
                minimumResultsForSearch: -1,
                ajax: {
                    type: "GET",
                    url: '{{ route('pengguna.str.selected.get') }}',
                    data: function(params) {
                        return {
                            id: $('#id-sip-edit').val()
                        };
                    },
                    dataType: 'json',
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaleditSIP",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                //placeholder: $(this).data('placeholder'),

            });
        });
    </script>

    <!-- STR -->
    @include('components.str-script', [
        'config' => [
            'tableId' => 'tbSTR',
            'getRoute' => 'pengguna.getSTR',
            'storeRoute' => 'pengguna.str.store',
            'editRoute' => 'pengguna.str.edit',
            'updateRoute' => 'pengguna.str.update',
            'destroyRoute' => 'pengguna.str.destroy',
            'statusRoute' => 'pengguna.str.status',
            'verifStoreRoute' => 'pengguna.verif.str.store',
            'verifDestroyRoute' => 'pengguna.verif.str.destroy',
            'enableStatusControl' => false,
            'enablePaging' => true,
            'enableSearch' => true,
            'enableInfo' => true,
            'serverSide' => true,
            'idPegawai' => null,
            'showActions' => true,
            'permissions' => [
                'view' => auth()->user()->can('user-str-view'),
                'edit' => auth()->user()->can('user-str-edit'),
                'delete' => auth()->user()->can('user-str-delete'),
            ],
        ],
    ])

    <!-- SIP -->
    @include('components.sip-script', [
        'tableId' => 'tbSIP',
        'strRoute' => 'pengguna.str.get',
        'sipRoute' => 'pengguna.getSIP',
        'sipStoreRoute' => 'pengguna.sip.store',
        'sipEditRoute' => 'pengguna.sip.edit',
        'sipUpdateRoute' => 'pengguna.sip.update',
        'sipDestroyRoute' => 'pengguna.sip.destroy',
        'strSelectedRoute' => 'pengguna.str.selected.get',
        'sipExpRoute' => 'pengguna.sip.masaberlaku.add',
        'sipDesexpRoute' => 'pengguna.sip.masaberlaku.destroy',
        'sipStatusRoute' => 'pengguna.sip.status.update',
        'enablePaging' => true,
        'enableSearch' => true,
        'enableInfo' => true,
        'showActions' => true,
        'showStatusActions' => true,
        'modalParent' => '#modaladdSIP',
        'editModalParent' => '#modaleditSIP',
    ])

    <script>
        // JavaScript for checkbox functionality
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
            document.getElementById('pengingat').disabled = !this.checked;
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
            document.getElementById('pengingat_edit').disabled = !this.checked;
        };
    </script>
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
