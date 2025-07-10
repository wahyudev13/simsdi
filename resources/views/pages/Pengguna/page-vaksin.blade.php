@extends('layouts.app')
@section('title', 'Vaksinasi Karyawan')
@section('user-main3', 'active')
@section('user-main4', 'show')
@section('user-vaksin', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Vaksinasi Karyawan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-vaksin-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdVaksin">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Vaksin</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">


                <div class="table-responsive">
                    <table class="table table-bordered berkas-lain" id="tbVaksin" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th>Nama File</th> --}}
                                <th>Dosis Vaksin</th>
                                <th>Jenis Vaksin</th>
                                <th>Tanggal Vaksin</th>
                                <th>Tempat Vaksin</th>
                                @if (auth()->user()->can('user-vaksin-view') ||
                                        auth()->user()->can('user-vaksin-edit') ||
                                        auth()->user()->can('user-vaksin-delete'))
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

    <!-- Modal ADD Vaksin -->
    <div class="modal fade" id="modaladdVaksin" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Vaksin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_vaksin"></div>
                    <form method="POST" id="form-add-vaksin" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_vaksin" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <div class="form-group">
                         <label for="nama_file_vaksin" class="col-form-label">Nama Dokumen <label class="text-danger">*</label></label>
                         <select class="custom-select nama_file_vaksin" id="nama_file_vaksin" name="nama_file">
                             <option value="" selected>Choose...</option>
                             @foreach ($berkas_kesehatan as $item)
                                 <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                             @endforeach
                         </select>
                     </div> --}}
                        <div class="form-group">
                            <label for="dosis" class="col-form-label">Dosis <label class="text-danger">*</label></label>
                            <input type="text" class="form-control dosis" id="dosis" name="dosis">
                        </div>
                        <div class="form-group">
                            <label for="jenis_vaksin" class="col-form-label">Jenis Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control jenis_vaksin" id="jenis_vaksin" name="jenis_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tgl_vaksin" class="col-form-label">Tanggal Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_vaksin" id="tgl_vaksin" name="tgl_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tempat_vaksin" class="col-form-label">Tempat Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control tempat_vaksin" id="tempat_vaksin"
                                name="tempat_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="file_vaksin" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_vaksin" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_vaksin">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal EDIT Vaksin -->
    <div class="modal fade" id="modaleditVaksin" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Vaksin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_vaksin_edit"></div>
                    <form method="POST" id="form-edit-vaksin" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_vaksin_edit" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        <input type="hidden" class="id_vaksin_edit" id="id_vaksin_edit" name="id">
                        {{-- <div class="form-group">
                         <label for="nama_file_vaksin_edit" class="col-form-label">Nama Dokumen <label class="text-danger">*</label></label>
                         <select class="custom-select nama_file_vaksin_edit" id="nama_file_vaksin_edit" name="nama_file">
                             <option value="" selected>Choose...</option>
                             @foreach ($berkas_kesehatan as $item)
                                 <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                             @endforeach
                         </select>
                     </div> --}}
                        <div class="form-group">
                            <label for="dosis_edit" class="col-form-label">Dosis <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control dosis_edit" id="dosis_edit" name="dosis">
                        </div>
                        <div class="form-group">
                            <label for="jenis_vaksin_edit" class="col-form-label">Jenis Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control jenis_vaksin_edit" id="jenis_vaksin_edit"
                                name="jenis_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tgl_vaksin_edit" class="col-form-label">Tanggal Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_vaksin" id="tgl_vaksin_edit"
                                name="tgl_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tempat_vaksin_edit" class="col-form-label">Tempat Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control tempat_vaksin_edit" id="tempat_vaksin_edit"
                                name="tempat_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="file_vaksin_edit" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_vaksin_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_vaksin">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View PDF -->
    <div class="modal fade " id="modalviewVaksin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dokumen Vaksin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-vaksin-modal"></div>
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

            $('#tbVaksin').DataTable({
                paging: true,
                scrollX: false,
                bInfo: true,
                searching: true,
                processing: false,
                serverSide: true,
                ajax: '{{ route('pengguna.getVaksin') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'dosis',
                        name: 'dosis'
                    },
                    {
                        data: 'jenis_vaksin',
                        name: 'jenis_vaksin'
                    },
                    {
                        data: 'tgl_vaksin',
                        name: 'tgl_vaksin'
                    },
                    {
                        data: 'tempat_vaksin',
                        name: 'tempat_vaksin'
                    },
                    @if (auth()->user()->can('user-vaksin-view') ||
                            auth()->user()->can('user-vaksin-edit') ||
                            auth()->user()->can('user-vaksin-delete'))
                        {
                            'data': null,
                            render: function(data, row, type) {
                                return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('user-vaksin-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalviewVaksin" id="view-vaksin">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-vaksin-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditVaksin" id="edit-vaksin">Edit Dokumen</a>
                                        @endcan
                                        @can('user-vaksin-delete')
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}"  data-jenis="${data.jenis_vaksin}" id="hapus-vaksin"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                                `;
                            }
                        },
                    @endif
                ]
            }); //End Datatable


            //VIEW Vaksin
            $(document).on('click', '#view-vaksin', function(e) {
                e.preventDefault();
                var namafile = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Kesehatan/Vaksin/' + namafile, "#view-vaksin-modal");
            });
            //ADD VAKSIN
            $('#form-add-vaksin').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-add-vaksin')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.vaksin.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_vaksin').html("")
                            $('#error_list_vaksin').addClass("alert alert-danger")
                            $('#error_list_vaksin').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_vaksin').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modaladdVaksin').modal('hide')
                            $('#modaladdVaksin').find('.form-control').val("");

                            var vaksin = $('#tbVaksin').DataTable().ajax.reload();

                        }
                    }
                });
            });

            $('#modaladdVaksin').on('hidden.bs.modal', function() {
                $('#modaladdVaksin').find('.form-control').val("");
                $('#modaladdVaksin').find('.custom-select').val("");
                $('.alert-danger').addClass('d-none');
            });

            //EDIT VAKSIN
            $(document).on('click', '#edit-vaksin', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.vaksin.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                        $('#id_vaksin_edit').val(response.data.id);
                        // $('#nama_file_vaksin_edit').val(response.data.nama_file_kesehatan_id);
                        $('#dosis_edit').val(response.data.dosis);
                        $('#jenis_vaksin_edit').val(response.data.jenis_vaksin);
                        $('#tgl_vaksin_edit').val(response.data.tgl_vaksin);
                        $('#tempat_vaksin_edit').val(response.data.tempat_vaksin);
                        // $('#file_edit').val(response.data.file);
                    }
                });
            });

            //UPDATE VAKSIN
            $('#form-edit-vaksin').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id_vaksin_edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-vaksin')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.vaksin.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_vaksin_edit').html("")
                            $('#error_list_vaksin_edit').addClass("alert alert-danger")
                            $('#error_list_vaksin_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_vaksin_edit').append('<li>' +
                                    error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)

                            $('#modaleditVaksin').modal('hide')
                            $('#modaleditVaksin').find('.form-control').val("");
                            $('#modaleditVaksin').find('.custom-select').val("");

                            var vaksin = $('#tbVaksin').DataTable().ajax.reload();

                        }
                    }
                });

            });

            $('#modaleditVaksin').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS VAKSIN
            $(document).on('click', '#hapus-vaksin', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.vaksin.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'jenis': $(this).data('jenis'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            var vaksin = $('#tbVaksin').DataTable().ajax.reload();

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
