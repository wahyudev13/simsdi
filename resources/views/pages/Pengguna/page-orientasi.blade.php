@extends('layouts.app')
@section('title', 'Data Orientasi')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-orientasi', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Orientasi</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <input type="hidden" id="id-pegawai" value="{{ $pegawai->id_pegawai }}">
        <div class="card-header py-3">
            @can('Tambah Orientasi')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modal-add-orientasi">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Sertifikat Orientasi</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-orientasi" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>Tanggal Orientasi</th>
                                    @if (auth()->user()->can('View Orientasi') ||
                                            auth()->user()->can('Edit Orientasi') ||
                                            auth()->user()->can('Hapus Orientasi'))
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    <!-- Modal Tambah Orientasi -->
    <div class="modal fade" id="modal-add-orientasi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat Orientasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_ori"></div>
                    <form method="POST" id="form-tambah-orientasi" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_orientasi" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        <div class="form-group">
                            <label for="nomor_orientasi" class="col-form-label">Nomor Sertifikat <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="nomor_orientasi" name="nomor_orientasi">
                        </div>
                        <div class="form-group">
                            <label for="tgl_mulai" class="col-form-label">Tanggal Mulai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tgl_selesai" class="col-form-label">Tanggal Selesai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        </div>
                        <div class="form-group">
                            <label for="file_orientasi" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file_orientasi" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_ori">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Orientasi -->
    <div class="modal fade" id="modal-edit-orientasi" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sertifikat Orientasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_ori_edit"></div>
                    <form method="POST" id="form-edit-orientasi" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_orientasi_edit" name="id_pegawai">
                        <input type="hidden" class="id_orientasi" id="id_orientasi" name="id_orientasi">
                        <div class="form-group">
                            <label for="nomor_orientasi_edit" class="col-form-label">Nomor Sertifikat <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="nomor_orientasi_edit" name="nomor_orientasi">
                        </div>
                        <div class="form-group">
                            <label for="tgl_mulai_edit" class="col-form-label">Tanggal Mulai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_mulai_edit" name="tgl_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tgl_selesai_edit" class="col-form-label">Tanggal Selesai<label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_selesai_edit" name="tgl_selesai">
                        </div>
                        <div class="form-group">
                            <label for="file_orientasi_edit" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file_orientasi_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="edit_ori">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View orinetasi PDF -->
    <div class="modal fade " id="modal-orientasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sertifikat Orientasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-ori-modal"></div>
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
        var idpegawai = $('#id-pegawai').val();
        $(document).ready(function() {
            $('#tb-orientasi').DataTable({
                ordering: false,
                paging: false,
                bInfo: false,
                searching: false,
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('pengguna.getOrientasi') }}',
                    data: {
                        'id': idpegawai,
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: null,
                        render: function(data, row, type) {
                            return `
                            <span class="badge badge-primary"> <i class="fas fa-calendar-alt"></i> Tanggal Mulai   : ${data.tgl_mulai}</span><br>
                            <span class="badge badge-primary"> <i class="fas fa-calendar-alt"></i> Tanggal Selesai : ${data.tgl_selesai}</span>
                            
                            `;
                        }
                    },
                    @if (auth()->user()->can('View Orientasi') ||
                            auth()->user()->can('Edit Orientasi') ||
                            auth()->user()->can('Hapus Orientasi'))
                        {
                            data: null,
                            render: function(data, row, type) {
                                return `
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-solid fa-bars"></i>
                                           
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('View Orientasi')
                                            <a class="dropdown-item" href="#" data-file="${data.file}"  title="Lihat Dokumen" id="view-orientasi"  data-toggle="modal" data-target="#modal-orientasi">Lihat Dokumen</a>
                                            @endcan
                                            @can('Edit Orientasi')
                                            <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-orientasi" id="edit-orientasi">Edit Dokumen</a>
                                            @endcan
                                            @can('Hapus Orientasi')
                                            <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" data-nomor="${data.nomor}" id="hapus-orientasi"  title="Hapus Dokumen">Hapus</a>
                                            @endcan
                                        </div>
                                    </div>
                                    `;
                            }
                        },
                    @endif

                ]
            });

            //VIEW Orientasi
            $(document).on('click', '#view-orientasi', function(e) {
                e.preventDefault();
                var namafile = $(this).data('file');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/Orientasi/' + namafile, "#view-ori-modal");
            });

            $('#form-tambah-orientasi').on('submit', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-orientasi')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.orientasi.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_ori').html("")
                            $('#error_list_ori').addClass("alert alert-danger")
                            $('#error_list_ori').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_ori').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modal-add-orientasi').modal('hide')
                            $('#modal-add-orientasi').find('.form-control').val("");

                            $('#tb-orientasi').DataTable().ajax.reload();

                        }
                    }
                });
            });

            $('#modal-add-orientasi').on('hidden.bs.modal', function() {
                $('#modal-add-orientasi').find('.form-control').val("");
                $('#modal-add-orientasi').find('.custom-file-input').val("");
                $('.alert-danger').addClass('d-none');
            });

            //EDIT Orientasi
            $(document).on('click', '#edit-orientasi', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.orientasi.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id_orientasi').val(response.data.id);
                        $('#id_pegawai_orientasi_edit').val(response.data.id_pegawai);
                        $('#nomor_orientasi_edit').val(response.data.nomor);
                        $('#tgl_mulai_edit').val(response.data.tgl_mulai);
                        $('#tgl_selesai_edit').val(response.data.tgl_selesai);
                    }
                });
            });

            //UPDATE Berkas Lain
            $('#form-edit-orientasi').on('submit', function(e) {
                e.preventDefault();

                // var data = {
                //     'id': $('#id-lain-edit').val(),
                // }

                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-orientasi')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.orientasi.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_ori_edit').html("")
                            $('#error_list_ori_edit').addClass("alert alert-danger")
                            $('#error_list_ori_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_ori_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modal-edit-orientasi').modal('hide')
                            $('#modal-edit-orientasi').find('.form-control').val("");
                            $('#tb-orientasi').DataTable().ajax.reload();


                        }
                    }
                });
            });

            $('#modal-edit-orientasi').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS Lain
            $(document).on('click', '#hapus-orientasi', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.orientasi.destroy') }}",
                        data: {
                            'id_orientasi': $(this).data('id'),
                            'nomor': $(this).data('nomor'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tb-orientasi').DataTable().ajax.reload();

                        }
                    });
                }
            });
        });
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
