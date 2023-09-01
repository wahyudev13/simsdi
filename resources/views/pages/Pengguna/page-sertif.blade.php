@extends('layouts.app')
@section('title', 'Sertifikat Pelatihan')
@section('user-main5', 'active')
@section('user-main6', 'show')
@section('user-sertif', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sertifikat Pelatihan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('Tambah Sertif')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladd_sertif">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Sertifikat</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-lain" id="tb-sertifikat" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sertifikat</th>
                                <th>Nama Kegiatan</th>
                                <th>Tgl Kegiatan</th>
                                <th>Tempat Kegiatan</th>
                                <th>Penyelenggara</th>
                                @if (auth()->user()->can('View Sertif') ||
                                        auth()->user()->can('Edit Sertif') ||
                                        auth()->user()->can('Hapus Sertif'))
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

    <!-- Modal Tambah Devisi -->
    <div class="modal fade" id="modaladd_sertif" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form id="form-add-sertif">
                        @csrf
                        <input type="hidden" id="id_pegawai" value="{{ $pegawai->id }}" name="id_pegawai">

                        <div class="form-group">
                            <label for="berkas_id">Sertifikat <label class="text-danger">*</label></label>
                            <select class="form-control" id="berkas_id" name="berkas_id">
                                <option value="" selected>Pilih Jenis Pelatihan</option>
                                @foreach ($master_berkas_kompetensi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nm_kegiatan" class="col-form-label">Nama Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="nm_kegiatan" name="nm_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_kegiatan" class="col-form-label">Tanggal Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_kegiatan" name="tgl_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="tmp_kegiatan" class="col-form-label">Tempat Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="tmp_kegiatan" name="tmp_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="penye_kegiatan" class="col-form-label">Penyelenggara Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="penye_kegiatan" name="penye_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File Sertifikat <span
                                    class="badge badge-secondary">.pdf
                                </span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-login" id="add">Simpan</button>
                            <button class="btn btn-primary btn-login-disabled d-none" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Devisi -->

    <!-- Modal Tambah Devisi -->
    <div class="modal fade" id="editmodal_sertif" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sertifikat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form id="form-edit-sertif">
                        @csrf
                        <input type="hidden" id="id-pegawai-edit" name="id_pegawai">
                        <input type="hidden" id="id_sertif" name="id">

                        <div class="form-group">
                            <label for="berkas_id_edit">Sertifikat <label class="text-danger">*</label></label>
                            <select class="form-control" id="berkas_id_edit" name="berkas_id">
                                <option value="" selected>Pilih Jenis Pelatihan</option>
                                @foreach ($master_berkas_kompetensi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nm_kegiatan_edit" class="col-form-label">Nama Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="nm_kegiatan_edit" name="nm_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_kegiatan_edit" class="col-form-label">Tanggal Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl_kegiatan_edit" name="tgl_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="tmp_kegiatan_edit" class="col-form-label">Tempat Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="tmp_kegiatan_edit" name="tmp_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="penye_kegiatan_edit" class="col-form-label">Penyelenggara Kegiatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="penye_kegiatan_edit" name="penye_kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="file_edit" class="col-form-label">File Sertifikat <span
                                    class="badge badge-secondary">.pdf
                                </span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-login" id="edit">Update</button>
                            <button class="btn btn-primary btn-login-disabled d-none" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Devisi -->

    <!-- Modal View Lain PDF -->
    <div class="modal fade " id="modalviewSer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sertifikat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-sertif-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script>
        $(document).ready(function() {
            var idpegawai = $('.id-pegawai').val();
            $('#tb-sertifikat').DataTable({
                paging: true,
                scrollX: false,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{route('pengguna.getSertif')}}',
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
                        data: 'nm_kegiatan',
                        name: 'nm_kegiatan'
                    },
                    {
                        data: 'tgl_kegiatan',
                        name: 'tgl_kegiatan'
                    },
                    {
                        data: 'tmp_kegiatan',
                        name: 'tmp_kegiatan'
                    },
                    {
                        data: 'penyelenggara',
                        name: 'penyelenggara'
                    },
                    @if (auth()->user()->can('View Sertif') ||
                                        auth()->user()->can('Edit Sertif') ||
                                        auth()->user()->can('Hapus Sertif'))
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('View Sertif')
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalviewSer" id="view-sertif">Lihat Dokumen</a>
                                        @endcan
                                        @can('Edit Sertif')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#editmodal_sertif" id="edit_sertif">Edit Dokumen</a>
                                        @endcan
                                        @can('Hapus Sertif')
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" data-berkas="${data.berkas_id}" data-pegawai="${data.id_pegawai}" id="hapus"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                                `;
                        }
                    },
                    @endif

                ]
            });

            //VIEW Berkas Ijazah
            $(document).on('click', '#view-sertif', function(e) {
                e.preventDefault();
                var sertif = $(this).data('file');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Diklat/Sertifikat-Pelatihan/' + sertif,
                    "#view-sertif-modal");
            });

            $('#form-add-sertif').on('submit', function(e) {
                e.preventDefault();
                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-add-sertif')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: '{{ route('pengguna.sertifikat.store') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $('.btn-login').addClass("d-none");
                        $('.btn-login-disabled').removeClass("d-none");
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list').html("")
                            $('#error_list').addClass("alert alert-danger")
                            $('#error_list').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list').append('<li>' + error_value + '</li>');
                            });

                            $('.btn-login').removeClass("d-none");
                            $('.btn-login-disabled').addClass("d-none");
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladd_sertif').modal('hide')
                            $('#modaladd_sertif').find('.form-control').val("");

                            $('.btn-login').removeClass("d-none");
                            $('.btn-login-disabled').addClass("d-none");
                            $('#tb-sertifikat').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#modaladd_sertif').on('hidden.bs.modal', function() {
                $('#modaladd_sertif').find('.form-control').val("");
                $('#modaladd_sertif').find('.custom-file-input').val("");
                $('.alert-danger').addClass('d-none');
            });

            //EDIT SERTIF
            $(document).on('click', '#edit_sertif', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.sertifikat.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id_sertif').val(response.data.id);
                        $('#id-pegawai-edit').val(response.data.id_pegawai);
                        $('#berkas_id_edit').val(response.data.berkas_id);
                        $('#nm_kegiatan_edit').val(response.data.nm_kegiatan);
                        $('#tgl_kegiatan_edit').val(response.data.tgl_kegiatan);
                        $('#tmp_kegiatan_edit').val(response.data.tmp_kegiatan);
                        $('#penye_kegiatan_edit').val(response.data.penyelenggara);

                    }
                });
            });


            //UPDATE 
            $('#form-edit-sertif').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id_sertif').val(),
                }

                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-sertif')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.sertifikat.update') }}",
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
                            $('#success_message').text(response.message)
                            $('#editmodal_sertif').modal('hide')
                            $('#editmodal_sertif').find('.form-control').val("");
                            $('#tb-sertifikat').DataTable().ajax.reload();

                        }
                    }
                });

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
                        url: "{{ route('pengguna.sertifikat.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'berkas_id': $(this).data('berkas'),
                            'id_pegawai': $(this).data('pegawai'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tb-sertifikat').DataTable().ajax.reload();

                        }
                    });
                }
            });
        });
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
