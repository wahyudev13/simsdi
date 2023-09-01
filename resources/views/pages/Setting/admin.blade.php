@extends('layouts.app')
@section('title', 'Set Administrator')
@section('setting', 'active')
@section('setting2', 'show')
@section('admin', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Set Administrator</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdAdmin">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Administrator</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbAdmin" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Admin -->
    <div class="modal fade"id="modaladdAdmin" data-backdrop="static" tabindex="-1" role="dialog"
       aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form id="form-add-admin">
                        {{-- <div class="form-group">
                            <label for="namaadmin" class="col-form-label">Nama Administrator<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control namaadmin" id="namaadmin" name="namaadmin"
                                placeholder="Nama Administrator">
                        </div> --}}
                        <div class="form-group">
                            <label for="username" class="col-form-label">Username<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control username" id="username" placeholder="Username"
                                name="username">
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
                    <button type="button" class="btn btn-primary" id="add-admin">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

     <!-- Modal Edit Admin -->
     <div class="modal fade"id="modaleditAdmin" data-backdrop="static" tabindex="-1" role="dialog"
     aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Administrator</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div id="error_list_edit"></div>
                  <form id="form-edit-admin">
                      {{-- <div class="form-group">
                          <label for="namaadmin" class="col-form-label">Nama Administrator<label
                                  class="text-danger">*</label></label>
                          <input type="text" class="form-control namaadmin" id="namaadmin" name="namaadmin"
                              placeholder="Nama Administrator">
                      </div> --}}
                      <input type="hidden" class="id-admin" id="id-admin">
                      <div class="form-group">
                          <label for="username-edit" class="col-form-label">Username<label
                                  class="text-danger">*</label></label>
                          <input type="text" class="form-control username-edit" id="username-edit" placeholder="Username"
                              name="username">
                      </div>
                      <div class="form-group">
                          <label for="password-edit" class="col-form-label">Password<label
                                  class="text-danger">*</label></label>
                          <input type="text" class="form-control password-edit" id="password-edit"
                              placeholder="Password Pengguna" name="password">
                      </div>
                  </form>
                  <p class="text-danger">*Wajib Diisi</p>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="edit-admin">Update</button>
              </div>
          </div>
      </div>
  </div>
  <!-- ./ end Modal -->

    <!-- Modal Setting Role-->
    <div class="modal fade" id="setting-role-admin" data-backdrop="static" tabindex="-1" role="dialog"
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

                    {{-- <div class="form-group">
                        <select class="form-select select2-role" id="select-role-setting" name="role[]"
                            data-placeholder="Pilih Role Akses" multiple>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

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



@endsection
@push('custom-scripts')
    <!-- Scripts Select 2-->
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#select-role-setting').select2({
            theme: "bootstrap-5",
            dropdownParent: "#setting-role",
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
            $('#tbAdmin').DataTable({
                // processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                ordering: false,
                serverSide: true,
                bInfo: false,
                bPaginate: false,
                ajax: '{{ route('setting.admin.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-edit btn-icon-split btn-sm"
                            data-toggle="modal" data-target="#modaleditAdmin" id="edit" title="Edit Admin">
                                        <span class="icon text-white">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>

                                    <a href="#" data-id="${data.id}" class="btn btn-danger btn-hapus btn-icon-split btn-sm" id="hapus" title="Hapus Admin">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            //STORE ADMIN
            $(document).on('click', '#add-admin', function(e) {
                e.preventDefault();
                var data = {
                    'username': $('.username').val(),
                    'password': $('.password').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('setting.admin.store') }}",
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

                            $('#modaladdAdmin').modal('hide');
                            $('#modaladdAdmin').find('.form-control').val("")
        
                            var tbAdmin = $('#tbAdmin').DataTable();
                            tbAdmin.ajax.reload();
                        }
                    }
                });
            });
        });
        //END DOCUMENT READY FUNCTION

        $('#modaladdAdmin').on('hidden.bs.modal', function() {
            $('#modaladdAdmin').find('.form-control').val("");
            $('.alert-danger').addClass('d-none');
        });


        //EDIT ADMIN
        $(document).on('click', '#edit', function() {
            $.ajax({
                type: "GET",
                url: "{{ route('setting.admin.show') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id-admin').val(response.data.id);
                    $('#username-edit').val(response.data.username);
                }
            });
        });

        //UPDATE ADMIN
        $(document).on('click', '#edit-admin', function(e) {
            e.preventDefault();

            var data = {
                'id': $('#id-admin').val(),
                'username': $('#username-edit').val(),
                'password': $('#password-edit').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('setting.admin.update') }}",
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
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)

                        $('#modaleditAdmin').modal('hide')
                        $('#modaleditAdmin').find('.form-control').val("");

                        var tbAdmin = $('#tbAdmin').DataTable();
                        tbAdmin.ajax.reload();


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
                    url: "{{ route('setting.admin.destroy') }}",
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

                        var tbAdmin = $('#tbAdmin').DataTable();
                        tbAdmin.ajax.reload();
                    }
                });
            }
        });
    </script>
    <!-- END Script Table Pengguna -->

    <!--  Script Role Akses -->
@endpush

@push('custom-css')
    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">

    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
