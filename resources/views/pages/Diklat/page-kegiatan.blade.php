@extends('layouts.app')
@section('title', 'Jenis Kegiatan Diklat')
@section('diklat-main1', 'active')
@section('diklat-main2', 'show')
@section('diklat-kegiatan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kegiatan Diklat</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdKegiatan">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Kegiatan</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-kegiatan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>Nama Kegiatan</th>
                            <th>Jenis Kegiatan</th>
                            <th>Tempat</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Kegiatan -->
    <div class="modal fade" id="modaladdKegiatan" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form id="form-add-kegiatan">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit" class="col-form-label">Unit<label
                                            class="text-danger">*</label></label>
                                    <select class="form-select select-unit" id="unit"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama-kegiatan" class="col-form-label">Nama Kegiatan<label
                                            class="text-danger">*</label></label>
                                    <input type="text" class="form-control" id="nama-kegiatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis-kegiatan" class="col-form-label">Jenis Kegiatan<label
                                            class="text-danger">*</label></label>
                                    <select class="form-select select-jenis" id="jenis-kegiatan"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tmp-kegiatan" class="col-form-label">Tempat Kegiatan<label
                                            class="text-danger">*</label></label>
                                    <input type="text" class="form-control" id="tmp-kegiatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mulai-kegiatan" class="col-form-label">Mulai<label
                                            class="text-danger">*</label></label>
                                    <input type="date" class="form-control" id="mulai-kegiatan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selesai-kegiatan" class="col-form-label">Selesai<label
                                            class="text-danger">*</label></label>
                                    <input type="date" class="form-control" id="selesai-kegiatan">
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="text-danger">*Wajib Diisi</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add-kegiatan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal Kegiatan -->

    <!-- Modal Edit Kegiatan -->
    <div class="modal fade" id="modaleditKegiatan" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mr-2" id="exampleModalLabel">Edit Kegiatan<h5 class="modal-title"
                            id="title-nm-kegiatab"></h5>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form id="form-edit-kegiatan">
                        <input type="hidden" class="form-control" id="id-kegiatan">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit-edit" class="col-form-label">Unit<label
                                            class="text-danger">*</label></label>
                                    <select class="form-select select-unit-edit" id="unit-edit"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama-kegiatan-edit" class="col-form-label">Nama Kegiatan<label
                                            class="text-danger">*</label></label>
                                    <input type="text" class="form-control" id="nama-kegiatan-edit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis-kegiatan-edit" class="col-form-label">Jenis Kegiatan<label
                                            class="text-danger">*</label></label>
                                    <select class="form-select select-jenis-edit" id="jenis-kegiatan-edit"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tmp-kegiatan-edit" class="col-form-label">Tempat Kegiatan<label
                                            class="text-danger">*</label></label>
                                    <input type="text" class="form-control" id="tmp-kegiatan-edit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mulai-kegiatan-edit" class="col-form-label">Mulai<label
                                            class="text-danger">*</label></label>
                                    <input type="date" class="form-control" id="mulai-kegiatan-edit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selesai-kegiatan-edit" class="col-form-label">Selesai<label
                                            class="text-danger">*</label></label>
                                    <input type="date" class="form-control" id="selesai-kegiatan-edit">
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="text-danger">*Wajib Diisi</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit-kegiatan">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal Kegiatan -->

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page level custom scripts -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            $('.select-unit').select2({
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('departemen.get') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },

                },
                theme: "bootstrap-5",
                dropdownParent: "#modaladdKegiatan",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: 'Pilih Unit Penyelenggaran Kegiatan',

            });

            $('.select-jenis').select2({
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('jenis.get') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },

                },
                theme: "bootstrap-5",
                dropdownParent: "#modaladdKegiatan",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: 'Pilih Jenis Kegiatan',

            });
        });
    </script>

    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            $('.select-unit-edit').select2({
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('departemen.get') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaleditKegiatan",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: 'Pilih Unit Penyelenggaran Kegiatan',

            });

            $('.select-jenis-edit').select2({
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('jenis.get') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaleditKegiatan",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: 'Pilih Jenis Kegiatan',

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tb-kegiatan').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('kegiatan.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'nama_jenis',
                        name: 'nama_jenis'
                    },
                    {
                        data: 'tempat',
                        name: 'tempat'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'tanggal2',
                        name: 'tanggal2'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                    <div class="btn-group">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" title="Absen" aria-expanded="false">
                                            <i class="fas fa-fingerprint"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" id="masuk" href="{{ url('diklat/absensi/masuk/${data.id}') }}" target="_blank" >Masuk</a>
                                            <a class="dropdown-item" href="{{ url('diklat/absensi/selesai/${data.id}') }}" target="_blank" id="selesai">Selesai</a>
                                            <a class="dropdown-item" href="{{ url('diklat/absensi/manual/${data.id}') }}" target="_blank"  id="manual">Manual</a>
                                            <a class="dropdown-item text-primary" href="{{ url('diklat/absensi/rekab/${data.id}') }}" target="_blank"  id="rekab">Rekab Absen</a>
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" title="Aksi" aria-expanded="false">
                                            <i class="fas fa-solid fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-id="${data.id}" href="#" data-toggle="modal" data-target="#modaleditKegiatan" id="edit">Edit</a>
                                            <a class="dropdown-item text-danger" data-id="${data.id}"  data-name="${data.nama_kegiatan}" href="#" id="hapus">Hapus</a>
                                        </div>
                                    </div>
                                `;
                        }
                    },

                ]
            });

            $(document).on('click', '#add-kegiatan', function(e) {
                e.preventDefault();
                var data = {
                    'departemen': $('#unit').val(),
                    'nama': $('#nama-kegiatan').val(),
                    'jenis_kegiatan': $('#jenis-kegiatan').val(),
                    'tempat': $('#tmp-kegiatan').val(),
                    'tanggal': $('#mulai-kegiatan').val(),
                    'tanggal2': $('#selesai-kegiatan').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('kegiatan.store') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list').html("")
                            $('#error_list').addClass("alert alert-danger")
                            $('#error_list').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list').append('<li>' + error_value + '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladdKegiatan').modal('hide')
                            $('#modaladdKegiatan').find('.form-control').val("");
                            $('.select-unit').val(null).trigger('change');
                            $('.select-jenis').val(null).trigger('change');
                            $('#tb-kegiatan').DataTable().ajax.reload();
                        }
                    }
                });
            });


            $('#modaladdKegiatan').on('hidden.bs.modal', function() {
                $('#modaladdKegiatan').find('.form-control').val("");
                $('.select-unit').val(null).trigger('change');
                $('.select-jenis').val(null).trigger('change');
                $('.alert-danger').addClass('d-none');
            });

            //EDIT KEGIATAN
            $(document).on('click', '#edit', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kegiatan.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-kegiatan').val(response.data.id);
                        $('#unit-edit').val(response.data.departemen_id);
                        $('#nama-kegiatan-edit').val(response.data.nama);
                        $('#jenis-kegiatan-edit').val(response.data.jenis_kegiatans_id);
                        $('#tmp-kegiatan-edit').val(response.data.tempat);
                        $('#mulai-kegiatan-edit').val(response.data.tanggal);
                        $('#selesai-kegiatan-edit').val(response.data.tanggal2);
                        $('#title-nm-kegiatab').text(response.data.nama);
                    }
                });
            });

            //UPDATE KEGIATAN
            $(document).on('click', '#edit-kegiatan', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-kegiatan').val(),
                    'departemen': $('#unit-edit').val(),
                    'nama': $('#nama-kegiatan-edit').val(),
                    'jenis_kegiatan': $('#jenis-kegiatan-edit').val(),
                    'tempat': $('#tmp-kegiatan-edit').val(),
                    'tanggal': $('#mulai-kegiatan-edit').val(),
                    'tanggal2': $('#selesai-kegiatan-edit').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('kegiatan.update') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_edit').html("")
                            $('#error_list_edit').addClass("alert alert-danger")
                            $('#error_list_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            $('#success_message').text(response.message)
                            $('#modaleditKegiatan').modal('hide')
                            $('#modaleditKegiatan').find('.form-control').val("")
                            $('.select-unit-edit').val(null).trigger('change')
                            $('.select-jenis-edit').val(null).trigger('change')
                            $('#tb-kegiatan').DataTable().ajax.reload();
                        }
                    }
                });

            });

            $('#modaleditKegiatan').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none')
                $('.select-unit-edit').val(null).trigger('change')
                $('.select-jenis-edit').val(null).trigger('change');
            });

            //HAPUS KEGIATAN
            $(document).on('click', '#hapus', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('kegiatan.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'name': $(this).data('name')
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tb-kegiatan').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush

@push('custom-css')
    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
