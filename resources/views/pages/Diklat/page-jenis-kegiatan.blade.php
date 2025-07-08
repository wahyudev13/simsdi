@extends('layouts.app')
@section('title', 'Jenis Kegiatan Diklat')
@section('diklat-main1', 'active')
@section('diklat-main2', 'show')
@section('diklat-jeniskegiatan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Jenis Kegiatan Diklat</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdJenis">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Jenis Kegiatan</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-jenis-kegiatan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Kegiatan</th>
                            <th>Keternagan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Devisi -->
    <div class="modal fade" id="modaladdJenis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form id="form-add-jenis">
                        <div class="form-group">
                            <label for="jenis-kegiatan" class="col-form-label">Jenis Kegiatan</label>
                            <input type="text" class="form-control" id="jenis-kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="ket-kegiatan" class="col-form-label">Keterangan</label>
                            <textarea class="form-control" id="ket-kegiatan" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add-jenis">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal Devisi -->

    <!-- Modal Tambah Devisi -->
    <div class="modal fade" id="modaleditJenis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form id="form-add-jenis">
                        <input type="hidden" id="id-jenis-kegiatan" name="id-jenis">
                        <div class="form-group">
                            <label for="jenis-kegiatan" class="col-form-label">Jenis Kegiatan</label>
                            <input type="text" class="form-control" id="jenis-kegiatan-edit">
                        </div>
                        <div class="form-group">
                            <label for="ket-kegiatan" class="col-form-label">Keterangan</label>
                            <textarea class="form-control" id="ket-kegiatan-edit" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit-jenis">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal Devisi -->

@endsection
@push('custom-scripts')
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#tb-jenis-kegiatan').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('diklat.kegiatan.jenis.get') }}',
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
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-edit btn-icon-split btn-sm"
                            data-toggle="modal" data-target="#modaleditJenis" id="edit">
                                        <span class="icon text-white">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>

                                    <a href="#" data-id="${data.id}"  data-name="${data.nama}" class="btn btn-danger btn-hapus btn-icon-split btn-sm" id="hapus">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            $(document).on('click', '#add-jenis', function(e) {
                e.preventDefault();
                var data = {
                    'nama': $('#jenis-kegiatan').val(),
                    'ket': $('#ket-kegiatan').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('diklat.kegiatan.jenis.store') }}",
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
                            $('#modaladdJenis').modal('hide')
                            $('#modaladdJenis').find('.form-control').val("");
                            $('#tb-jenis-kegiatan').DataTable().ajax.reload();
                        }
                    }
                });
            });


            $('#modaladdJenis').on('hidden.bs.modal', function() {
                $('#modaladdJenis').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //EDIT JENIS KEGIATAN
            $(document).on('click', '#edit', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('diklat.kegiatan.jenis.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-jenis-kegiatan').val(response.data.id);
                        $('#jenis-kegiatan-edit').val(response.data.nama);
                        $('#ket-kegiatan-edit').val(response.data.keterangan);
                    }
                });
            });

            //UPDATE JENIS KEGIATAN
            $(document).on('click', '#edit-jenis', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-jenis-kegiatan').val(),
                    'nama': $('#jenis-kegiatan-edit').val(),
                    'ket': $('#ket-kegiatan-edit').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('diklat.kegiatan.jenis.update') }}",
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
                            $('#modaleditJenis').modal('hide')
                            $('#modaleditJenis').find('.form-control').val("");
                            $('#tb-jenis-kegiatan').DataTable().ajax.reload();
                        }
                    }
                });

            });

            $('#modaleditJenis').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS JENIS KEGIATAN
            $(document).on('click', '#hapus', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('diklat.kegiatan.jenis.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'name': $(this).data('name')
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-danger")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tb-jenis-kegiatan').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush
