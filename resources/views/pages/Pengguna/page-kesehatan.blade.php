@extends('layouts.app')
@section('title', 'Tes Kesehatan Karyawan')
@section('user-main3', 'active')
@section('user-main4', 'show')
@section('user-kes', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tes Kesehatan Karyawan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-kesehatan-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdAwal">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Tes Kesehatan</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">

                <div class="table-responsive">
                    <table class="table table-bordered berkas-lain" id="tbkesAwal" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-kesehatan-view') ||
                                        auth()->user()->can('user-kesehatan-edit') ||
                                        auth()->user()->can('user-kesehatan-delete'))
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

    <!-- Modal ADD Kesehatan Awal -->
    <div class="modal fade" id="modaladdAwal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Kesehatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form method="POST" id="form-add-kesehatan-awal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        <div class="form-group">
                            <label for="nama_file" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file" id="nama_file" name="nama_file">
                                <option value="" selected>Choose...</option>
                                @foreach ($berkas_kesehatan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemeriksaan" class="col-form-label">Nama Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nama_pemeriksaan" id="nama_pemeriksaan"
                                name="nama_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_pemeriksaan" class="col-form-label">Tanggal Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_pemeriksaan" id="tgl_pemeriksaan"
                                name="tgl_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_awal">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Kesehatan -->
    <div class="modal fade" id="modaleditAwal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Kesehatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form method="POST" id="form-edit-kesehatan-awal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai_edit" id="id_pegawai_edit" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        <input type="hidden" class="id_kesehatan_awal" id="id_kesehatan_awal" name="id">
                        <div class="form-group">
                            <label for="nama_file_edit" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_edit" id="nama_file_edit" name="nama_file">
                                <option value="">Choose...</option>
                                @foreach ($berkas_kesehatan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemeriksaan_edit" class="col-form-label">Nama Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nama_pemeriksaan_edit" id="nama_pemeriksaan_edit"
                                name="nama_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_pemeriksaan_edit" class="col-form-label">Tanggal Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_pemeriksaan_edit" id="tgl_pemeriksaan_edit"
                                name="tgl_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="file_edit" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="edit_awal">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View PDF -->
    <div class="modal fade " id="modalKesehatanAwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kesehatan Awal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-kesehatan-awal-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script>
        $(document).ready(function() {
            var idpegawai = $('#id-pegawai').val();
            $('#tbkesAwal').DataTable({
                paging: true,
                scrollX: false,
                bInfo: true,
                searching: true,
                processing: false,
                serverSide: true,
                ajax: '{{ route('pengguna.getKesehatan') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_berkas',
                        name: 'nama_berkas'
                    },
                    {
                        data: 'nama_pemeriksaan',
                        name: 'nama_pemeriksaan'
                    },
                    {
                        data: 'tgl_pemeriksaan',
                        name: 'tgl_pemeriksaan'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-kesehatan-view') ||
                            auth()->user()->can('user-kesehatan-edit') ||
                            auth()->user()->can('user-kesehatan-delete'))
                        {
                            'data': null,
                            render: function(data, row, type) {
                                return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('user-kesehatan-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalKesehatanAwal" id="view-kesehatan-awal">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-kesehatan-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditAwal" id="edit-kes-awal">Edit Dokumen</a>
                                        @endcan
                                        @can('user-kesehatan-delete')
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                                `;
                            }
                        },
                    @endif
                ]
            }); //End Datatable


            //VIEW Berkas Kesehatan Awal
            $(document).on('click', '#view-kesehatan-awal', function(e) {
                e.preventDefault();
                var namafile = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Kesehatan/Kesehatan/' + namafile,
                    "#view-kesehatan-awal-modal");
            });
            //ADD KESEHATAN AWAL
            $('#form-add-kesehatan-awal').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-add-kesehatan-awal')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.kesehatan.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list').html("")
                            $('#error_list').addClass("alert alert-danger")
                            $('#error_list').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modaladdAwal').modal('hide')
                            $('#modaladdAwal').find('.form-control').val("");

                            var tbkesAwal = $('#tbkesAwal').DataTable();
                            tbkesAwal.ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdAwal').on('hidden.bs.modal', function() {
                $('#modaladdAwal').find('.form-control').val("");
                $('#modaladdAwal').find('.custom-select').val("");
                $('.alert-danger').addClass('d-none');
            });

            //EDIT KESEHATAN AWAL
            $(document).on('click', '#edit-kes-awal', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.kesehatan.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                        $('#id_kesehatan_awal').val(response.data.id);
                        $('#nama_file_edit').val(response.data.nama_file_kesehatan_id);
                        $('#nama_pemeriksaan_edit').val(response.data.nama_pemeriksaan);
                        $('#tgl_pemeriksaan_edit').val(response.data.tgl_pemeriksaan);
                        // $('#file_edit').val(response.data.file);
                    }
                });
            });

            //UPDATE KESEHATAN AWAL
            $('#form-edit-kesehatan-awal').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id_kesehatan_awal').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-kesehatan-awal')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.kesehatan.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
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

                            $('#modaleditAwal').modal('hide')
                            $('#modaleditAwal').find('.form-control').val("");
                            $('#modaladdAwal').find('.custom-select').val("");

                            var tbkesAwal = $('#tbkesAwal').DataTable();
                            tbkesAwal.ajax.reload();


                        }
                    }
                });

            });

            $('#modaleditAwal').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS KESEHATAN AWAL
            $(document).on('click', '#hapus', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.kesehatan.destroy') }}",
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
                            var tbkesAwal = $('#tbkesAwal').DataTable();
                            tbkesAwal.ajax.reload();

                        }
                    });
                }
            });

        }); //End Jquery Document Ready
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
