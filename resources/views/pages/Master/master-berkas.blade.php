@extends('layouts.app')
@section('title', 'Master Berkas Pegawai')
@section('master1', 'active')
@section('master2', 'show')
@section('master-berkas', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Master Berkas Pegawai</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modalBerkas">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Master Berkas</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbJenjang" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Berkas</th>
                            <th>Kategori</th>
                            <th>Nama berkas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Devisi -->
    <div class="modal fade" id="modalBerkas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Berkas Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form>
                        <div class="form-group">
                            <label for="kd_berkas" class="col-form-label">Kode Berkas</label>
                            <input type="text" class="form-control kd_berkas " id="kd_berkas">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control kategori" name="kategori" id="kategori">
                                <option value="pendidikan">Berkas Pendidikan</option>
                                <option value="ijin">Berkas Ijin Praktek</option>
                                <option value="identitas">Berkas Identitas</option>
                                <option value="kompetensi">Berkas Kompetensi</option>
                                <option value="kesehatan">Berkas Kesehatan</option>
                                <option value="perjanjian">Berkas Perjanjian</option>
                                <option value="orientasi">Berkas Orientasi</option>
                                <option value="lain">Berkas Lain-Lain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_berkas" class="col-form-label">Nama Berkas</label>
                            <input type="text" class="form-control nama_berkas" id="nama_berkas">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_berkas">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal Devisi -->

    <!-- Modal Edit Devisi -->
    <div class="modal fade" id="editmodalBerkas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Berkas Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form>
                        <input type="hidden" id="id-berkas-edit">
                        <div class="form-group">
                            <label for="kd-berkas-edit" class="col-form-label">Kode Berkas</label>
                            <input type="text" class="form-control kd-berkas-edit " id="kd-berkas-edit" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori-edit">Kategori</label>
                            <select class="form-control kategori-edit" name="kategori-edit" id="kategori-edit">
                                <option value="pendidikan">Berkas Pendidikan</option>
                                <option value="ijin">Berkas Ijin Praktek</option>
                                <option value="identitas">Berkas Identitas</option>
                                <option value="kompetensi">Berkas Kompetensi</option>
                                <option value="kesehatan">Berkas Kesehatan</option>
                                <option value="perjanjian">Berkas Perjanjian</option>
                                <option value="orientasi">Berkas Orientasi</option>
                                <option value="lain">Berkas Lain-Lain</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama-berkas-edit" class="col-form-label">Nama Berkas</label>
                            <input type="text" class="form-control nama-berkas-edit" id="nama-berkas-edit">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit_berkas">Simpan</button>
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
            $('#tbJenjang').DataTable({
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: '{{ route('master.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        // data: 'kategori',
                        data: function(data, row, type) {
                            if (data.kategori === 'pendidikan') {
                                return "Berkas Pendidikan";
                            } else if (data.kategori === 'ijin') {
                                return "Berkas Ijin Praktek";
                            } else if (data.kategori === 'identitas') {
                                return "Berkas Identitas";
                            } else if (data.kategori === 'kompetensi') {
                                return "Berkas Kompetensi";
                            } else if (data.kategori === 'kesehatan') {
                                return "Berkas Kesehatan";
                            } else if (data.kategori == 'lain') {
                                return "Berkas Lain-Lain"
                            } else if (data.kategori == 'perjanjian') {
                                return "Berkas Perjanjian"
                            } else if (data.kategori == 'orientasi') {
                                return "Berkas Orientasi"
                            }
                        }
                    },
                    {
                        data: 'nama_berkas',
                        name: 'nama_berkas'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `<a href="#" data-id="${data.id}" class="btn btn-primary btn-edit btn-icon-split btn-sm"
                            data-toggle="modal" data-target="#editmodalBerkas" id="edit">
                                        <span class="icon text-white">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>

                                    <a href="#" data-id="${data.id}" class="btn btn-danger btn-hapus btn-icon-split btn-sm" id="hapus">
                                        <span class="icon text-white">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>
                                    
                                    `;
                        }
                    },

                ]
            });

            $(document).on('click', '#add_berkas', function(e) {
                e.preventDefault();
                var data = {
                    'kode': $('.kd_berkas').val(),
                    'kategori': $('.kategori').val(),
                    'nama_berkas': $('.nama_berkas').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.store') }}",
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
                            $('#modalBerkas').modal('hide')
                            $('#modalBerkas').find('.form-control').val("");
                            var oTable = $('#tbJenjang').DataTable();
                            oTable.ajax.reload();
                            //fetchData();


                        }
                    }
                });
            });

            $('#modalBerkas').on('hidden.bs.modal', function() {
                $('#modalBerkas').find('.form-control').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT DEVISI
            $(document).on('click', '#edit', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.berkas.show') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                        $('#id-berkas-edit').val(response.data.id);
                        $('#kd-berkas-edit').val(response.data.kode);
                        $('#kategori-edit').val(response.data.kategori);
                        $('#nama-berkas-edit').val(response.data.nama_berkas);
                    }
                });
            });
            //UPDATE DEVISI
            $(document).on('click', '#edit_berkas', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-berkas-edit').val(),
                    'kode': $('#kd-berkas-edit').val(),
                    'kategori': $('#kategori-edit').val(),
                    'nama_berkas': $('#nama-berkas-edit').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('master.berkas.update') }}",
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
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#editmodalBerkas').modal('hide')
                            $('#editmodalBerkas').find('.form-control').val("");
                            var oTable = $('#tbJenjang').DataTable();
                            oTable.ajax.reload();
                            //fetchData();


                        }
                    }
                });

            });

            $('#editmodalBerkas').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS
            $(document).on('click', '#hapus', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('master.berkas.destroy') }}",
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
                            var oTable = $('#tbJenjang').DataTable();
                            oTable.ajax.reload();
                        }
                    });
                }
            });
        });
        //END DOCUMENT READY FUNCTION
    </script>
@endpush
