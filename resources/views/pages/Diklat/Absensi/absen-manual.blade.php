@extends('layouts.app')
@section('title', 'Absensi Masuk Kegiatan Diklat')
@section('diklat-main1', 'active')
@section('diklat-main2', 'show')
@section('diklat-kegiatan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Absensi Manual Masuk Kegiatan {{ $kegiatan2->nama }}</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div id="error_list"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <input type="hidden" class="id-kegiatan" id="id-kegiatan" value="{{ $kegiatan2->id }}">
            <form id="form-absen-manual">
                <div class="form-group row">
                    <div class="col-md-3 col-lg-3">
                        <label for="nama" class="form-label">ID Pegawai<label class="text-danger">*</label></label>
                        <input type="text" class="form-control idpegawai" id="id-pegawai" placeholder="ID Pegawai"
                            name="id-pegawai" readonly>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <label for="nip-pegawai" class="form-label">NIK Pegawai<label class="text-danger">*</label></label>
                        <input type="text" class="form-control nip" id="nip-pegawai" placeholder="NIP Pegawai"
                            name="nip-pegawai" readonly>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label for="nama" class="form-label">Nama Pegawai<label class="text-danger">*</label></label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control nama" id="nama" placeholder="Nama Pegawai"
                                aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" id="bt-nama-pengguna"
                                    data-toggle="modal" data-target="#modalPegawai">
                                    <i class="fas fa-user-tie"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 col-lg-6">
                        <label for="masuk" class="form-label">Mulai<label class="text-danger">*</label></label>
                        <input type="datetime-local" class="form-control" id="masuk" placeholder="Waktu Mulai">
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <label for="selesai" class="form-label">Selesai<label class="text-danger">*</label></label>
                        <input type="datetime-local" class="form-control" id="selesai" placeholder="Waktu Selesai">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5 col-lg-12">
                        <button type="submit" class="btn btn-primary" id="add">Simpan</button>
                        <button type="submit" class="btn btn-success d-none" id="update">Update</button>
                        <button type="submit" class="btn btn-secondary" id="batal">Clear</button>
                    </div>
                </div>
            </form>
            {{-- <input type="hidden" class="form-control nik-pegawai" id="nik-pegawai"> --}}

            {{-- <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdKegiatan">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Kegiatan</span>
            </a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-absen-manual" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Unit</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Total Waktu (jam)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Pegawai -->
    <div class="modal fade bd-example-modal-xl"id="modalPegawai" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar List Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <div class="input-group">
                                <div class="col-sm-10 col-lg-3">
                                    <input type="text" class="form-control form-control-sm" id="cari-nip"
                                        placeholder="Cai NIP">
                                </div>
                                <div class="col-sm-10 col-lg-3">
                                    <input type="text" class="form-control form-control-sm" id="cari-nama-pegawai"
                                        placeholder="Cari Nama Pegawai">
                                </div>
                                <div class="col-sm-10 col-lg-3">
                                    <input type="text" class="form-control form-control-sm" id="cari-departemen"
                                        placeholder="Cari Departemen">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive-xl">
                        <table class="table table-bordered table-sm" id="tbPegawai" width="100%" cellspacing="0"
                            style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>jenis Kelamin</th>
                                    <th>Departemen</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/datatables/button/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.print.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script> --}}
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <script>
        $(document).ready(function() {
            var tbpegawai = $('#tbPegawai').DataTable({
                // processing: true,
                // searching: false,
                serverSide: true,
                ajax: '{{ route('karyawan.getPegawai') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jk',
                        name: 'jk'
                    },
                    {
                        data: 'nama_dep',
                        name: 'nama_dep'
                    },
                    {
                        data: 'jbtn',
                        name: 'jbtn'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-icon-split btn-sm"
                                    id="pilih-pegawai" title="Pilih Pengguna">
                                        <span class="icon text-white">
                                            <i class="fas fa-user-plus fa-xs"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            $('#cari-nip').on('keyup', function() {
                tbpegawai
                    .columns(1)
                    .search(this.value)
                    .draw();
            });
            $('#cari-nama-pegawai').on('keyup', function() {
                tbpegawai
                    .columns(2)
                    .search(this.value)
                    .draw();
            });
            $('#cari-departemen').on('keyup', function() {
                tbpegawai
                    .columns(4)
                    .search(this.value)
                    .draw();
            });

            $('table').on('click', '#pilih-pegawai', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.maping.load') }}",
                    data: {
                        'id_pegawai': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-pegawai').val(response.data.id);
                        $('#nip-pegawai').val(response.data.nik);
                        $('#nama').val(response.data.nama);
                        $('#modalPegawai').modal('hide')
                    }
                });
            });

            //STORE
            $(document).on('click', '#add', function(e) {
                e.preventDefault();
                var data = {
                    'id_kegiatan': $('#id-kegiatan').val(),
                    'id_pegawai': $('#id-pegawai').val(),
                    'masuk': $('#masuk').val(),
                    'selesai': $('#selesai').val()

                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('absensi.diklat.store_manual') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list').html("")
                            $('#success_message').addClass("d-none")
                            $('#error_list').addClass("alert alert-danger")
                            $('#error_list').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list').append('<li>' + error_value + '</li>');
                            });
                        } else if (response.status == 402) {
                            $('#success_message').html("")
                            $('#error_list').addClass("d-none")
                            $('#success_message').removeClass("d-none")
                            $('#success_message').removeClass("alert-danger")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)

                            // $('#form-add-pengguna').find('.form-control').val("");

                        } else {
                            $('#success_message').html("")
                            $('#error_list').addClass("d-none")
                            $('#success_message').removeClass("d-none")
                            $('#success_message').removeClass("alert-danger")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)

                            $('#form-absen-manual').find('.form-control').val("");

                            $('#tb-absen-manual').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#batal').click(function(e) {
                e.preventDefault();
                $('#form-absen-manual').find('.form-control').val("");
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tb-absen-manual').DataTable({

                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('absensi.diklat.masuk.get') }}',
                    data: {
                        'kegiatan_id': $('#id-kegiatan').val(),
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama_pegawai'
                    },
                    {
                        data: 'nama_dep',
                        name: 'nama_dep'
                    },
                    {
                        data: 'masuk_at',
                        name: 'masuk_at'
                    },
                    {
                        data: 'selesai_at',
                        name: 'selesai_at'
                    },
                    {
                        data: 'total_waktu',
                        name: 'total_waktu'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}"  data-idpegawai="${data.id_pegawai}"class="btn btn-danger btn-icon-split btn-sm"
                                    id="hapus-absen" title="Hapus Absen">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash fa-xs"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            $(document).on('click', '#hapus-absen', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('absensi.diklat.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'id_kegiatan': $('#id-kegiatan').val(),
                            'id_pegawai': $(this).data('idpegawai'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tb-absen-manual').DataTable().ajax.reload();

                        }
                    });
                }
            });

        });
    </script>
@endpush

@push('custom-css')
    <!-- Custom styles for this page -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}"> --}}
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endpush
