@extends('layouts.app')
@section('title', 'Maping No Rekam Medis')
@section('master1', 'active')
@section('master2', 'show')
@section('master-mapingrm', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Maping No Rekam Medis</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div id="error_list"></div>
    <div class="card shadow mb-4 d-none" id="card-form">
        {{-- <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdMaping">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
        </div> --}}
        <div class="card-body">

            <form id="form-add-pengguna">
                <div id="title-add" class="row mb-4">
                    <div class="col-md-3 col-lg-4">
                        <h4 class="h4 mb-2 text-gray-800">Tambah Maping No Rekam Medis</h4>
                    </div>
                    <div class="col-md-6 col-lg-8">

                    </div>
                </div>
                <div id="title-edit" class="row mb-4 d-none">
                    <div class="col-md-3 col-lg-4">
                        <h4 class="h4 mb-2 text-gray-800">Edit Mamping No Rekam Medis</h4>
                    </div>
                    <div class="col-md-6 col-lg-8">

                    </div>
                </div>

                <input type="hidden" class="form-control id-maping" id="id-maping" name="id-maping">
                <div class="form-group row">
                    <div class="col-md-3 col-lg-4">
                        <label for="nama" class="form-label">ID Pegawai<label class="text-danger">*</label></label>
                        <input type="text" class="form-control idpegawai" id="id-pegawai" placeholder="ID Pegawai"
                            name="id-pegawai" readonly>
                    </div>
                    <div class="col-md-6 col-lg-8">
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
                    <div class="col-md-3 col-lg-4">
                        <label for="namapasien" class="form-label ">No Rekam Medis<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control no-rkm-medis" id="no-rkm-medis" name="no-rkm-medis"
                            placeholder="No RM" readonly>
                    </div>
                    <div class="col-md-6 col-lg-8">
                        <label for="namapasien" class="form-label ">Nama Pasien<label class="text-danger">*</label></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control namapasien" id="namapasien" placeholder="Nama Pasien"
                                aria-describedby="button-addon2">

                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" id="bt-nama-pasien"
                                    data-toggle="modal" data-target="#modalPasien"><i
                                        class="fas fa-hospital-user"></i></button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5 col-lg-12">
                        <button type="submit" class="btn btn-primary" id="add_maping">Simpan</button>
                        <button type="submit" class="btn btn-success d-none" id="update_maping">Update</button>
                        <button type="submit" class="btn btn-secondary" id="batal">Close</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdMaping">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a> --}}
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" id="button-show-card">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="tb-maping-norm" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>No Rekam Medis</th>
                            <th>Nama Pasien</th>
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
                                        placeholder="Cari NIP">
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

    <!-- Modal Pasien -->
    <div class="modal fade bd-example-modal-xl"id="modalPasien" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar List Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <div class="input-group">
                                <div class="col-sm-10 col-lg-2">
                                    <input type="text" class="form-control form-control-sm" id="cari-norm"
                                        placeholder="Cai NO RM">
                                </div>
                                {{-- <div class="col-sm-10 col-lg-3">
                                    <input type="text" class="form-control form-control-sm" id="cari-nama"
                                        placeholder="Cari Nama">
                                </div> --}}
                                <div class="col-sm-10 col-lg-2">
                                    <input type="text" class="form-control form-control-sm" id="cari-ktp"
                                        placeholder="Cari NIK">
                                </div>
                                <div class="col-sm-10 col-lg-2">
                                    <input type="text" class="form-control form-control-sm" id="cari-alamat"
                                        placeholder="Cari Alamat">
                                </div>
                                <div class="col-sm-10 col-lg-2">
                                    <input type="text" class="form-control form-control-sm" id="cari-nama2"
                                        placeholder="Cari Nama">
                                </div>
                                <div class="col-lg-4">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary btn-sm" id="filter-nama">
                                            Filter Nama</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            id="refresh">Reset</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm " id="tbPasien" width="100%" cellspacing="0"
                            style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NO RM</th>
                                    <th>Nama</th>
                                    <th>NO KTP</th>
                                    <th>JK</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tgl Lahir</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

                {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="add_pengguna">Simpan</button>
              </div> --}}
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

@endsection
@push('custom-scripts')
    <!-- Scripts Select 2-->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#button-show-card').click(function(e) {
                e.preventDefault();
                $('#card-form').removeClass("d-none")
                $('#button-show-card').addClass("d-none")
            });
            $('#batal').click(function(e) {
                e.preventDefault();
                $('#card-form').addClass("d-none")
                $('#button-show-card').removeClass("d-none")
                $('#form-add-pengguna').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
                $('#success_message').addClass("d-none")
                $('#update_maping').addClass("d-none")
                $('#add_maping').removeClass("d-none")
                $('#title-edit').addClass("d-none")
                $('#title-add').removeClass("d-none")
            });
        });
    </script>

    <!-- Script Table -->
    <script>
        $(document).ready(function() {
            $('#tb-maping-norm').DataTable({
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: '{{ route('master.maping.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id_pegawai',
                        name: 'id_pegawai'
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama_pegawai'
                    },
                    {
                        data: 'no_rkm_medis',
                        nama: 'no_rkm_medis'
                    },
                    {
                        data: 'nama_pasien',
                        nama: 'nama_pasien'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-icon-split btn-sm"
                                    id="edit-maping" title="Edit Maping">
                                        <span class="icon text-white">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>

                                    <a href="#" data-id="${data.id}" data-namap="${data.nama_pasien}" data-rm="${data.no_rkm_medis}" class="btn btn-danger btn-icon-split btn-sm"
                                    id="hapus-maping" title="Hapus Maping">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>

                                    
                                    `;
                        }
                    },

                ]
            });

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

            load_data_pasien();

            function load_data_pasien(nama_pasien = '') {
                var tbpasien = $('#tbPasien').DataTable({
                    // processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('pasien.get') }}',
                        data: {
                            'nama': nama_pasien,
                        },
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'no_rkm_medis',
                            name: 'no_rkm_medis'
                        },
                        {
                            data: 'nm_pasien',
                            name: 'nm_pasien'
                        },
                        {
                            data: 'no_ktp',
                            nama: 'no_ktp'
                        },
                        {
                            data: 'jk',
                            nama: 'jk'
                        },
                        {
                            data: 'tmp_lahir',
                            nama: 'tmp_lahir'
                        },
                        {
                            data: 'tgl_lahir',
                            nama: 'tgl_lahir'
                        },
                        {
                            data: 'alamat',
                            nama: 'alamat'
                        },
                        {
                            'data': null,
                            render: function(data, row, type) {
                                return `<a href="#" data-norm="${data.no_rkm_medis}" class="btn btn-primary btn-icon-split btn-sm"
                                        id="pilih-pasien" title="Pilih Pasien">
                                            <span class="icon text-white">
                                                <i class="fas fa-user-plus fa-xs"></i>
                                            </span>
                                        </a>
                                        
                                        `;
                            }
                        },

                    ]
                });
            }

            $('#filter-nama').click(function(e) {
                e.preventDefault();

                var nama_pasien = $('#cari-nama2').val();

                if (nama_pasien != '') {
                    $('#tbPasien').DataTable().destroy();
                    load_data_pasien(nama_pasien);
                } else {
                    // $('#tbPasien').DataTable().destroy();
                    // load_data_pasien();
                    alert('isi');
                }


            });

            $('#refresh').click(function() {
                $('#cari-norm').val('');
                $('#cari-ktp').val('');
                $('#cari-alamat').val('');
                $('#cari-nama2').val('');
                $('#tbPasien').DataTable().destroy();
                load_data_pasien();
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

            $('#cari-norm').on('keyup', function() {
                $('#tbPasien').DataTable()
                    .columns(1)
                    .search(this.value)
                    .draw();
            });
            // $('#cari-nama').on('keyup', function() {
            //     tbpasien
            //         .columns(2)
            //         .search(this.value)
            //         .draw();
            // });
            $('#cari-ktp').on('keyup', function() {
                $('#tbPasien').DataTable()
                    .columns(3)
                    .search(this.value)
                    .draw();
            });
            $('#cari-alamat').on('keyup', function() {
                $('#tbPasien').DataTable()
                    .columns(7)
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
                        $('#nama').val(response.data.nama);
                        $('#modalPegawai').modal('hide')
                    }
                });
            });

            $('table').on('click', '#pilih-pasien', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.maping.load_pasien') }}",
                    data: {
                        'norm': $(this).data('norm'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#no-rkm-medis').val(response.data.no_rkm_medis);
                        $('#namapasien').val(response.data.nm_pasien);
                        $('#modalPasien').modal('hide')
                    }
                });

            });

            //STORE PENGGUNA
            $(document).on('click', '#add_maping', function(e) {
                e.preventDefault();
                var data = {
                    'id_pegawai': $('#id-pegawai').val(),
                    'norm': $('#no-rkm-medis').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.maping.store') }}",
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
                        } else if (response.status == 401) {
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

                            $('#form-add-pengguna').find('.form-control').val("");

                            $('#tb-maping-norm').DataTable().ajax.reload();
                        }
                    }
                });
            });

            //EDIT
            $(document).on('click', '#edit-maping', function() {
                $('#card-form').removeClass("d-none")
                $('#button-show-card').addClass("d-none")
                $('#add_maping').addClass("d-none")
                $('#update_maping').removeClass("d-none")
                $('#title-edit').removeClass("d-none")
                $('#title-add').addClass("d-none")
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.maping.show') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-maping').val(response.data.id);
                        $('#id-pegawai').val(response.data.id_pegawai);
                        $('#nama').val(response.data.nama_pegawai);
                        $('#no-rkm-medis').val(response.data.no_rkm_medis);
                        $('#namapasien').val(response.data.nama_pasien);
                    }
                });

            });
            //UPDATE
            $(document).on('click', '#update_maping', function(e) {
                e.preventDefault();
                var data = {
                    'id': $('#id-maping').val(),
                    'id_pegawai': $('#id-pegawai').val(),
                    // 'nama_pengguna': $('#nama').val(),
                    'no_rm': $('#no-rkm-medis').val(),
                    //'nama_pasien': $('#namapasien').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.maping.update') }}",
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
                        } else if (response.status == 401) {
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

                            $('#form-add-pengguna').find('.form-control').val("");

                            $('#tb-maping-norm').DataTable().ajax.reload();
                        }
                    }
                });

            });

            //HAPUS
            $(document).on('click', '#hapus-maping', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('master.maping.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'nama': $(this).data('namap'),
                            'norm': $(this).data('rm'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")

                            $('#error_list').addClass("d-none")
                            $('#success_message').removeClass("d-none")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)

                            $('#tb-maping-norm').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
        //END DOCUMENT READY FUNCTION
    </script>
    <!-- END Script Table Pengguna -->
@endpush

@push('custom-css')
    <!-- Select2 -->
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">
@endpush
