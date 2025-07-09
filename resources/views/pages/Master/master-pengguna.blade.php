@extends('layouts.app')
@section('title', 'Master Pengguna')
@section('master1', 'active')
@section('master2', 'show')
@section('master-pengguna', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Master Pengguna</h1>
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
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control password" id="password"
                                placeholder="Password Pengguna" name="password">
                        </div>
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
                    <div id="error_list_edit"></div>
                    <form id="form-edit-pengguna">

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
                                placeholder="Username" name="username" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password_edit" class="col-form-label">Password <label class="text-danger">
                                    (Kosongkan jika tidak ingin mengubah password)</label></label>
                            <input type="text" class="form-control password_edit" id="password_edit"
                                placeholder="Password Pengguna" name="password">
                        </div>

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="simpan-role">Simpan</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('custom-scripts')
    <!-- Scripts Select 2-->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
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
    </script>

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
                        name: 'jbtn'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
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

                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading pegawai data:', error);
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
                    },
                    error: function(xhr, status, error) {
                        console.error('Error storing pengguna:', error);
                        $('#error_list').html("")
                        $('#error_list').addClass("alert alert-danger")
                        $('#error_list').removeClass("d-none")
                        $('#error_list').append(
                            '<li>Terjadi kesalahan sistem. Silakan coba lagi.</li>');
                    }
                });
            });

            // Reset form saat modal tambah pengguna ditutup
            $('#modaladdPengguna').on('hidden.bs.modal', function() {
                $('#modaladdPengguna').find('.form-control').val("");
                $('.select2').val(null).trigger('change');
                $('.alert-danger').addClass('d-none');
                $('#error_list').html("").removeClass("alert alert-danger").addClass("d-none");
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
                        $('#password_edit').val(''); // Clear password field
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading pengguna data:', error);
                    }
                });
            });

            //UPDATE PENGGUNA
            $(document).on('click', '#edit-pengguna', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-pengguna').val(),
                    'pengguna': $('#namapegawai_edit').val(),
                    'username': $('#username_edit').val(),
                    'password': $('#password_edit').val(),
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
                            $('#error_list_edit').addClass(
                                "alert alert-danger")
                            $('#error_list_edit').removeClass("d-none")

                            $.each(response.error, function(key,
                                error_value) {
                                $('#error_list_edit').append(
                                    '<li>' + error_value +
                                    '</li>');
                            });
                        } else if (response.status == 401) {
                            $('#error_list_edit').html("")
                            $('#error_list_edit').addClass(
                                "alert alert-danger")
                            $('#error_list_edit').removeClass("d-none")
                            $('#error_list_edit').text(response.error)
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass(
                                "alert-success")
                            $('#success_message').removeClass(
                                "alert-warning")
                            $('#success_message').addClass(
                                "alert alert-primary")
                            $('#success_message').text(response.message)
                            $('#modaleditPengguna').modal('hide')
                            $('#modaleditPengguna').find(
                                '.form-control').val("");

                            $('#tbPengguna').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating pengguna:', error);
                        $('#error_list_edit').html("")
                        $('#error_list_edit').addClass("alert alert-danger")
                        $('#error_list_edit').removeClass("d-none")
                        $('#error_list_edit').append(
                            '<li>Terjadi kesalahan sistem. Silakan coba lagi.</li>');
                    }
                });
            });

            $('#modaleditPengguna').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
                $('#modaleditPengguna').find('.form-control').val("");
                $('#error_list_edit').html("").removeClass("alert alert-danger").addClass("d-none");
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
                            $('#success_message').removeClass(
                                "alert-primary")
                            $('#success_message').removeClass(
                                "alert-success")
                            $('#success_message').addClass(
                                "alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tbPengguna').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting pengguna:', error);
                            alert('Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            });
        });
    </script>
    <!-- END Script Table Pengguna -->

    <!--  Script Role -->
    <script>
        $(document).ready(function() {
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
                                $('#error_setting_role').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#error_setting_role').addClass("d-none")

                            $('#success_setting_role').html("")
                            $('#success_setting_role').addClass(
                                "alert alert-success alert-role")
                            $('#success_setting_role').removeClass("d-none")
                            $('#success_setting_role').removeClass("alert-warning")
                            $('#success_setting_role').removeClass("alert-danger")
                            $('#success_setting_role').text(response.message)

                            $('.select2-role').val(null).trigger('change');

                            var tbRole = $('#tbRole').DataTable();
                            tbRole.ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding role:', error);
                        $('#error_setting_role').html("")
                        $('#error_setting_role').addClass("alert alert-danger")
                        $('#error_setting_role').removeClass("d-none")
                        $('#error_setting_role').append(
                            '<li>Terjadi kesalahan sistem. Silakan coba lagi.</li>');
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



                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading role data:', error);
                    }
                });
            });

            $('table').on('click', '#hapus-role-user', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });
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
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting role:', error);
                        alert('Terjadi kesalahan saat menghapus role.');
                    }
                });


            });

            $('#setting-role').on('hidden.bs.modal', function() {
                $('.select2-role').val(null).trigger('change');
                $('.alert-danger').addClass('d-none');
                $('.alert-role').addClass('d-none');
                $('.alert-warning').addClass('d-none');
                $('#error_setting_role').html("").removeClass("alert alert-danger").addClass("d-none");
                $('#success_setting_role').html("").removeClass("alert alert-success alert-role").addClass(
                    "d-none");
            });
        });
    </script>
@endpush

@push('custom-css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">
@endpush
