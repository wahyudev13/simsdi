@extends('layouts.app')
@section('title', 'Master Pengguna')
@section('master1', 'active')
@section('master2', 'show')
@section('master-role', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Master Role</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdRole">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Role</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbRole" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Role -->
    <div class="modal fade bd-example-modal-md" id="modaladdRole" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="success_pengguna"></div>
                    <div id="error_list"></div>
                    <form id="form-add-role">
                        <div class="form-group">
                            <label for="namarole" class="col-form-label">Nama Role<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control namarole" id="namarole" name="namarole"
                                placeholder="Nama Role" required>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_role">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Role -->
    <div class="modal fade bd-example-modal-md" id="modaleditRole" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="success_pengguna"></div>
                    <div id="error_list"></div>
                    <form id="form-add-role">
                        <div class="form-group">
                            <input type="hidden" class="form-control idrole_edit" id="idrole_edit" name="idrole_edit">
                            <label for="namarole_edit" class="col-form-label">Nama Role<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control namarole_edit" id="namarole_edit" name="namarole_edit"
                                placeholder="Nama Role" required>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_role">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

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

                    <input type="hidden" class="id-role-permis" name="id-role-permis" id="id-role-permis">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama-role-permis" readonly>
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
                    <input type="text" class="form-control form-control-sm mt-4" id="cari-permis"
                        placeholder="Cari Permission">
                </div>
            </div>
        </div>
    </div>




@endsection
@push('custom-scripts')
    <!-- select2 -->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#select-permis-setting').select2({
                theme: "bootstrap-5",
                dropdownParent: "#setting-permis",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
            });
        })
    </script>

    <!-- Script Table Role -->
    <script>
        $(document).ready(function() {
            $('#tbRole').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('master.role.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-edit btn-icon-split btn-sm"
                            data-toggle="modal" data-target="#modaleditRole" id="edit_role" title="Edit Role">
                                        <span class="icon text-white">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>
                                    <a href="#" data-id="${data.id}" class="btn btn-warning btn-role btn-icon-split btn-sm" 
                                    data-toggle="modal" data-target="#setting-permis" id="permis-button" title="Setting Permission">
                                        <span class="icon text-white">
                                            <i class="fas fa-user-lock"></i>
                                        </span>
                                    </a>
                                    <a href="#" data-id="${data.id}" data-nama="${data.name}" class="btn btn-danger btn-hapus btn-icon-split btn-sm" id="hapus_role" title="Hapus Role">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            //STORE ROLE
            $(document).on('click', '#add_role', function(e) {
                e.preventDefault();
                var data = {
                    'name': $('.namarole').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.role.store') }}",
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

                            $('#modaladdRole').modal('hide');
                            $('#modaladdRole').find('.form-control').val("")
                            $('.alert-danger').addClass('d-none');

                            $('#tbRole').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdRole').on('hidden.bs.modal', function() {
                $('#modaladdRole').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //EDIT ROLE
            $(document).on('click', '#edit_role', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.role.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#idrole_edit').val(response.id);
                        $('#namarole_edit').val(response.name);
                    }
                });
            });

            //UPDATE ROLE
            $(document).on('click', '#update_role', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#idrole_edit').val(),
                    'name': $('#namarole_edit').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.role.update') }}",
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
                            $('#modaleditRole').modal('hide')
                            $('#modaleditRole').find('.form-control').val("");
                            $('#tbRole').DataTable().ajax.reload();
                        }
                    }
                });

            });

            $('#modaleditRole').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
                $('#modaleditRole').find('.form-control').val("");
            });

            //HAPUS ROLE
            $(document).on('click', '#hapus_role', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('master.role.delete') }}",
                        data: {
                            'id': $(this).data('id'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tbRole').DataTable().ajax.reload();
                        }
                    });
                }
            });

        });
        //END DOCUMENT READY FUNCTION
    </script>
    <!-- END Script Table Role -->

    <!-- Script Table Permission Role -->
    <script>
        //SIMPAN PERMISSION ROLE
        $(document).on('click', '#simpan-permis', function(e) {
            e.preventDefault();
            var data = {
                'id': $('.id-role-permis').val(),
                'permis': $('.select2-permis').val(),
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('master.role.addPermissionRole') }}",
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
                        $('.select2-permis').val(null).trigger('change');

                        $('#tb-permis').DataTable().ajax.reload();

                    }
                }
            });
        });

        //SHOW PERMISSION ROLE
        $(document).on('click', '#permis-button', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.role.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    $('#id-role-permis').val(response.id);
                    $('#nama-role-permis').val(response.name);

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
                            url: "{{ route('master.role.getPermission') }}",
                            data: {
                                'id': response.id,
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
                                         id="hapus-permis-role" title="Hapus Permission">
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

        //DELETE PERMISSION ROLE
        $(document).ready(function() {
            $('table').on('click', '#hapus-permis-role', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.role.deletePermission') }}",
                    data: {
                        'id': $('#id-role-permis').val(),
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
            });
        });

        $('#cari-permis').on('keyup', function() {
            $('#tb-permis').DataTable()
                .columns(0)
                .search(this.value)
                .draw();
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
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">
@endpush
