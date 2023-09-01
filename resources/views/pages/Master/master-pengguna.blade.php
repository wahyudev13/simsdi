@extends('layouts.app')
@section('title', 'Master Pengguna')
@section('master1', 'active')
@section('master2', 'show')
@section('master-pengguna', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Master Pengguna</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdPengguna">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Master Pengguna</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbPengguna" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Username</th>
                            {{-- <th>Email</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade bd-example-modal-lg"id="modaladdPengguna" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="success_pengguna"></div>
                    <div id="error_list"></div>
                    <form id="form-add-pengguna">
                        <div class="form-group">
                            <label for="nama">Nama Pegawai<label class="text-danger">*</label></label>
                            <select class="form-select select2 selectpegawai" id="single-select-field" id="nama"
                                data-placeholder="Pilih Nama Pegawai">

                                @foreach ($pegawai as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->nik }})
                                        ({{ $item->nama_dep }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control idpegawai" id="id-pegawai" name="id">
                        <div class="form-group">
                            <label for="namapegawai" class="col-form-label">Nama Pengguna<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control namapegawai" id="namapegawai" name="namapegawai"
                                placeholder="Nama Pengguna" readonly>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-form-label">Username<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control username" id="username" placeholder="Username"
                                name="username" readonly>
                        </div>

                        {{-- <div class="form-group">
                            <label for="role">Role Akses<label class="text-danger">*</label></label>
                            <select class="form-select select2" id="single-select-role" id="role" name="role"
                                data-placeholder="Pilih Role Akses" multiple>
                                <option></option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control password" id="password"
                                placeholder="Password Pengguna" name="password">
                        </div>
                        {{-- <div class="form-group">
                            <label for="email" class="col-form-label">Email Pengguna</label>
                            <input type="text" class="form-control email" id="email" placeholder="Email Pengguna"
                                name="email">
                        </div> --}}

                    </form>
                    <p class="text-danger">*Wajib Diisi</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_pengguna">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Pengguna -->
    <div class="modal fade bd-example-modal-lg"id="modaleditPengguna" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div id="success_pengguna_edit"></div> --}}
                    <div id="error_list_edit"></div>
                    <form id="form-add-pengguna">

                        <input type="hidden" class="form-control id-pengguna" id="id-pengguna" name="id">
                        <div class="form-group">
                            <label for="namapegawai_edit" class="col-form-label">Nama Pegawai<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control namapegawai_edit" id="namapegawai_edit"
                                name="namapegawai_edit" placeholder="Nama Pengguna" readonly>
                        </div>
                        <div class="form-group">
                            <label for="username_edit" class="col-form-label">Username<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control username_edit" id="username_edit"
                                placeholder="Username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password_edit" class="col-form-label">Password<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control password_edit" id="password_edit"
                                placeholder="Password Pengguna" name="password">
                        </div>
                        {{-- <div class="form-group">
                            <label for="email_edit" class="col-form-label">Email Pengguna</label>
                            <input type="text" class="form-control email_edit" id="email_edit"
                                placeholder="Email Pengguna" name="email">
                        </div> --}}

                    </form>
                    <p class="text-danger">*Wajib Diisi</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit-pengguna">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Setting Role-->
    <div class="modal fade" id="setting-role" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Setting Role Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_setting_role"></div>
                    <div id="success_setting_role"></div>

                    <input type="hidden" class="id-pengguna-show" name="id-pengguna-show" id="id-pengguna-show">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama-pengguna-show" readonly>
                    </div>

                    <div class="form-group">
                        <select class="form-select select2-role" id="select-role-setting" name="role[]"
                            data-placeholder="Pilih Role Akses" multiple>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table" id="tbRole" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-warning" id="show-role-user">Show Role User</button> --}}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpan-role">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Setting Permission-->
    <div class="modal fade" id="setting-permis" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Setting Permission Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_setting_permis"></div>
                    <div id="success_setting_permis"></div>

                    <input type="hidden" class="id-pengguna-permis" name="id-pengguna-permis" id="id-pengguna-permis">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama-pengguna-permis" readonly>
                    </div>

                    <div class="form-group">
                        <select class="form-select select2-permis" id="select-permis-setting" name="permis[]"
                            data-placeholder="Pilih Permission" multiple>
                            @foreach ($permission as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row text-right mb-3">
                        <div class="col-md-12">
                            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                            <button type="button" class="btn btn-primary btn-sm" id="simpan-permis">Simpan</button>
                        </div>
                    </div>

                    <table class="table" id="tb-permis" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Permission</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    

                </div>
                <div class="modal-footer">
                    <input type="text" class="form-control form-control-sm mt-4" id="cari-permis" placeholder="Cari Permission">
                </div>
            </div>
        </div>
    </div>



@endsection
@push('custom-scripts')
    <!-- Scripts Select 2-->
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#single-select-field').select2({
            theme: "bootstrap-5",
            dropdownParent: "#modaladdPengguna",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),

        });

        $('#single-select-role').select2({
            theme: "bootstrap-5",
            dropdownParent: "#modaladdPengguna",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });

        $('#select-role-setting').select2({
            theme: "bootstrap-5",
            dropdownParent: "#setting-role",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });

        $('#select-permis-setting').select2({
            theme: "bootstrap-5",
            dropdownParent: "#setting-permis",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>

    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <!-- Script Table Pengguna -->
    <script>
        $(document).ready(function() {
            $('#tbPengguna').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('master.pengguna.getuser') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik_pegawai',
                        name: 'nik_pegawai'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jbtn',
                        nama: 'jbtn'
                    },
                    {
                        data: 'username',
                        nama: 'username'
                    },
                    // {
                    //     data: 'email',
                    //     nama: 'email'
                    // },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-edit btn-icon-split btn-sm"
                            data-toggle="modal" data-target="#modaleditPengguna" id="edit" title="Edit Pengguna">
                                        <span class="icon text-white">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>

                                    <a href="#" data-id="${data.id}" class="btn btn-success btn-role btn-icon-split btn-sm" 
                                    data-toggle="modal" data-target="#setting-role" id="role-button" title="Setting Role">
                                        <span class="icon text-white">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </a>
                                    <a href="#" data-id="${data.id}" class="btn btn-warning btn-role btn-icon-split btn-sm" 
                                    data-toggle="modal" data-target="#setting-permis" id="permis-button" title="Setting Permission">
                                        <span class="icon text-white">
                                            <i class="fas fa-user-lock"></i>
                                        </span>
                                    </a>
                                    <a href="#" data-id="${data.id}" data-nama="${data.nama}" class="btn btn-danger btn-hapus btn-icon-split btn-sm" id="hapus" title="Hapus Pengguna">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            //LOAD TAMBAH PENGGUNA
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#single-select-field').change(function(e) {
                    e.preventDefault();
                    var idpegawai = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.pengguna.load_pengguna') }}",
                        data: {
                            'id': idpegawai,
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#id-pegawai').val(response.data.id);
                            $('#username').val(response.data.nik);
                            $('#namapegawai').val(response.data.nama);
                            $('#password').val(response.data.nik);
                            //console.log(response.data.id);

                        }
                    });

                });
            });

            //STORE PENGGUNA
            $(document).on('click', '#add_pengguna', function(e) {
                e.preventDefault();
                var data = {
                    'id_pegawai': $('.idpegawai').val(),
                    'username': $('.username').val(),
                    // 'email': $('.email').val(),
                    'password': $('.password').val(),

                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.pengguna.store') }}",
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
                            $('#success_message').text(response.message)

                            $('#modaladdPengguna').modal('hide');
                            $('#modaladdPengguna').find('.form-control').val("")
                            $('.select2').val(null).trigger('change');
                            $('.alert-danger').addClass('d-none');

                            var tbPengguna = $('#tbPengguna').DataTable();
                            tbPengguna.ajax.reload();
                        }
                    }
                });
            });
        });
        //END DOCUMENT READY FUNCTION

        $('#modaladdPengguna').on('hidden.bs.modal', function() {
            $('#modaladdPengguna').find('.form-control').val("");

            $('.select2').val(null).trigger('change');
            // $(".select2").trigger("change");
            // $(".select2").trigger("change");
            $('.alert-danger').addClass('d-none');
        });


        //EDIT PENGGUNA
        $(document).on('click', '#edit', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.pengguna.show') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id-pengguna').val(response.data.id);
                    $('#namapegawai_edit').val(response.data.nama);
                    $('#username_edit').val(response.data.username);
                    // $('#email_edit').val(response.data.email);
                }
            });
        });

        //UPDATE PENGGUNA
        $(document).on('click', '#edit-pengguna', function(e) {
            e.preventDefault();

            var data = {
                'id': $('#id-pengguna').val(),
                'pengguna' : $('#namapegawai_edit').val(),
                'username': $('#username_edit').val(),
                'password': $('#password_edit').val(),
                // 'email': $('#email_edit').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('master.pengguna.update') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_edit').html("")
                        $('#error_list_edit').addClass("alert alert-danger")
                        $('#error_list_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_edit').append('<li>' + error_value + '</li>');
                        });
                    } else if (response.status == 401) {
                        $('#error_list_edit').html("")
                        $('#error_list_edit').addClass("alert alert-danger")
                        $('#error_list_edit').removeClass("d-none")
                        $('#error_list_edit').text(response.error)
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaleditPengguna').modal('hide')
                        $('#modaleditPengguna').find('.form-control').val("");

                        var tbPengguna = $('#tbPengguna').DataTable();
                        tbPengguna.ajax.reload();


                    }
                }
            });

        });

        $('#modaleditPengguna').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
            $('#modaleditPengguna').find('.form-control').val("");
        });

        //HAPUS PENGGUNA & Role User
        $(document).on('click', '#hapus', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus data ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.pengguna.destroy') }}",
                    data: {
                        'id': $(this).data('id'),
                        'namapeg': $(this).data('nama')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').addClass("alert alert-warning")
                        $('#success_message').text(response.message)
                        var tbPengguna = $('#tbPengguna').DataTable();
                        tbPengguna.ajax.reload();
                    }
                });
            }
        });
    </script>
    <!-- END Script Table Pengguna -->

    <!--  Script Role Akses -->
    <script>
        //SIMPAN ROLE USER
        $(document).on('click', '#simpan-role', function(e) {
            e.preventDefault();
            var data = {
                'id_pengguna': $('.id-pengguna-show').val(),
                'role': $('.select2-role').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('master.pengguna.addRoleUser') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#success_setting_role').addClass("d-none")

                        $('#error_setting_role').html("")
                        $('#error_setting_role').addClass("alert alert-danger")
                        $('#success_setting_role').removeClass("alert-warning")
                        $('#success_setting_role').removeClass("alert-success")
                        $('#error_setting_role').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_setting_role').append('<li>' + error_value + '</li>');
                        });
                    } else {
                        $('#error_setting_role').addClass("d-none")

                        $('#success_setting_role').html("")
                        $('#success_setting_role').addClass("alert alert-success alert-role")
                        $('#success_setting_role').removeClass("d-none")
                        $('#success_setting_role').removeClass("alert-warning")
                        $('#success_setting_role').removeClass("alert-danger")
                        $('#success_setting_role').text(response.message)

                        // $('#setting-role').modal('hide');
                        // $('#setting-role').find('.form-control').val("")
                        $('.select2-role').val(null).trigger('change');
                        // $('.alert-danger').addClass('d-none');

                        var tbRole = $('#tbRole').DataTable();
                        tbRole.ajax.reload();
                    }
                }
            });
        });

        //SHOW ROLE PENGGUNA
        $(document).on('click', '#role-button', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.pengguna.show') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    //console.log(response.data.id);
                    $('#id-pengguna-show').val(response.data.id);
                    $('#nama-pengguna-show').val(response.data.nama);

                    //Datatable Role Akses
                    $('#tbRole').DataTable({
                        // processing: true,
                        destroy: true,
                        searching: false,
                        lengthChange: false,
                        ordering: false,
                        serverSide: true,
                        bInfo: false,
                        bPaginate: false,
                        ajax: {
                            url: "{{ route('master.pengguna.settingRole') }}",
                            data: {
                                'id': response.data.id,
                            },

                        },
                        columns: [{
                                data: 'name',
                                name: 'name'
                            },
                            {
                                'data': null,
                                render: function(data, row, type) {
                                    return `
                                            <a href="#" data-rolename="${data.name}" class="btn btn-danger btn-hapus btn-icon-split btn-sm" id="hapus-role-user" title="Hapus Role">
                                                <span class="icon text-white">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </a>
                                `;
                                }
                            },

                        ]
                    });



                }
            });
        });
       
        //DELETE ROLE USER
        $(document).ready(function () {
            $('table').on('click','#hapus-role-user', function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });
                // if (confirm('Yakin Ingin Menghapus Role ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.pengguna.deleteRoleUser') }}",
                    data: {
                        'id': $('#id-pengguna-show').val(),
                        'rolename': $(this).data('rolename')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#error_setting_role').addClass("d-none")

                        $('#success_setting_role').html("")
                        $('#success_setting_role').addClass("alert alert-warning")
                        $('#success_setting_role').removeClass("alert-danger")
                        $('#success_setting_role').removeClass("alert-success")
                        $('#success_setting_role').removeClass("d-none")
                        $('#success_setting_role').text(response.message)

                        var tbRole = $('#tbRole').DataTable();
                        tbRole.ajax.reload();
                    }
                });
                //}


            });
        });

        $('#setting-role').on('hidden.bs.modal', function() {
            $('.select2-role').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
            $('.alert-role').addClass('d-none');
            $('.alert-warning').addClass('d-none');
        });
    </script>

    <script>
         //SIMPAN PERMISSION USER
         $(document).on('click', '#simpan-permis', function(e) {
            e.preventDefault();

            var data = {
                'id_pengguna': $('.id-pengguna-permis').val(),
                'permis': $('.select2-permis').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('master.pengguna.addPermisUser') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#success_setting_permis').addClass("d-none")

                        $('#error_setting_permis').html("")
                        $('#error_setting_permis').addClass("alert alert-danger")
                        $('#error_setting_permis').removeClass("alert-warning")
                        $('#error_setting_permis').removeClass("alert-success")
                        $('#error_setting_permis').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_setting_permis').append('<li>' + error_value + '</li>');
                        });
                    } else {
                        $('#error_setting_permis').addClass("d-none")

                        $('#success_setting_permis').html("")
                        $('#success_setting_permis').addClass("alert alert-success alert-role")
                        $('#success_setting_permis').removeClass("d-none")
                        $('#success_setting_permis').removeClass("alert-warning")
                        $('#success_setting_permis').removeClass("alert-danger")
                        $('#success_setting_permis').text(response.message)

                        // $('#setting-role').modal('hide');
                        // $('#setting-role').find('.form-control').val("")
                        $('.select2-permis').val(null).trigger('change');
                        // $('.alert-danger').addClass('d-none');

                        var tbpermis = $('#tb-permis').DataTable().ajax.reload();
                        
                    }
                }
            });
        });

        //SHOW PERMISSION USER
        $(document).on('click', '#permis-button', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.pengguna.show') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    //console.log(response.data.id);
                    $('#id-pengguna-permis').val(response.data.id);
                    $('#nama-pengguna-permis').val(response.data.nama);

                    //Datatable Role Akses
                    $('#tb-permis').DataTable({
                        // processing: true,
                        destroy: true,
                        scrollY: "250px",
                        scrollCollapse: false,
                        searching: true,
                        lengthChange: false,
                        ordering: false,
                        serverSide: true,
                        bInfo: false,
                        bPaginate: false,
                        dom: 'lrt',
                        ajax: {
                            url: "{{ route('master.pengguna.settingPermis') }}",
                            data: {
                                'id': response.data.id,
                            },

                        },
                        columns: [{
                                data: 'name',
                                name: 'name'
                            },
                            {
                                'data': null,
                                render: function(data, row, type) {
                                    return `
                                            <a href="#" data-permisname="${data.name}" class="btn btn-danger btn-hapus btn-sm"
                                             id="hapus-permis-user" title="Hapus Permission">
                                                <span class="icon text-white">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </span>
                                            </a>
                                `;
                                }
                            },

                        ]
                    });
                }
            });
        });

        $('#cari-permis').on('keyup', function() {
            $('#tb-permis').DataTable()
                    .columns(0)
                    .search(this.value)
                    .draw();
        });

         //DELETE PERMISSION USER
         $(document).ready(function () {
            $('table').on('click','#hapus-permis-user', function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });
                // if (confirm('Yakin Ingin Menghapus Role ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.pengguna.deletePermisUser') }}",
                    data: {
                        'id': $('#id-pengguna-permis').val(),
                        'permisname': $(this).data('permisname')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#error_setting_permis').addClass("d-none")

                        $('#success_setting_permis').html("")
                        $('#success_setting_permis').addClass("alert alert-warning")
                        $('#success_setting_permis').removeClass("alert-danger")
                        $('#success_setting_permis').removeClass("alert-success")
                        $('#success_setting_permis').removeClass("d-none")
                        $('#success_setting_permis').text(response.message)

                        $('#tb-permis').DataTable().ajax.reload();
                    }
                });
                //}


            });
        });

        $('#setting-permis').on('hidden.bs.modal', function() {
            $('.select2-permis').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
            $('.alert-role').addClass('d-none');
            $('.alert-warning').addClass('d-none');
        });
    </script>
@endpush

@push('custom-css')
    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
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
