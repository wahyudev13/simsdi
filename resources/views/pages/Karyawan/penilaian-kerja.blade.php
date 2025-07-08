@extends('layouts.app')
@section('title', 'Penilaian Kerja')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Penilaian Kerja</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            <div class="card border-left-primary mb-4 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $pegawai->jbtn }} / {{ $pegawai->nama_dep }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pegawai->nama }} ({{ $pegawai->nik }})
                            </div>
                            <input type="hidden" class="id-pegawai" value="{{ $pegawai->id }}">
                            <input type="hidden" class="nik-pegawai" value="{{ $pegawai->nik }}">
                        </div>
                        <div class="col-auto">

                            <i class="fas fa-user-edit fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="awal-tab" data-toggle="tab" data-target="#awal"
                        type="button" role="tab" aria-controls="awal" aria-selected="true">Test Kesehatan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="berkala-tab" data-toggle="tab" data-target="#berkala" type="button"
                        role="tab" aria-controls="berkala" aria-selected="false">Test Kesehatan Berkala</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="riwayat-tab" data-toggle="tab" data-target="#riwayat" type="button"
                        role="tab" aria-controls="riwayat" aria-selected="false">Test Kesehatan Khusus</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vaksin-tab" data-toggle="tab" data-target="#vaksin" type="button"
                        role="tab" aria-controls="vaksin" aria-selected="false">Vaksinasi</button>
                </li>
            </ul> --}}

            {{-- <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="awal" role="tabpanel" aria-labelledby="awal-tab">  --}}
            <div class="button-add mb-4">
                <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                    data-target="#modal-add-penilaian">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Penilaian</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="tb-penilaian" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Penilaian</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Total Nilai</th>
                            <th>Keteranagan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Tambah Penilaian -->
    <div class="modal fade" id="modal-add-penilaian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Penilaian Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_penilaian"></div>
                    <form method="POST" id="form-tambah-penilaian" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_pegawai_penilaian" value="{{ $pegawai->id }}" name="id_pegawai">
                        <div class="form-group">
                            <label for="tgl-penilaian" class="col-form-label">Tanggal Penilaian <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl-penilaian" name="tgl_penilaian">
                        </div>
                        <div class="form-group">
                            <label for="dep-penilaian">Unit Kerja <label class="text-danger">*</label></label>
                            <select class="form-select select2 select-departemen" id="dep-penilaian"
                                data-placeholder="Pilih Unit Kerja" name="dep_penilaian">

                                @foreach ($deparetemen as $item)
                                    <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan" class="col-form-label">Jabatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan">
                        </div>
                        <div class="form-group">
                            <label for="nilai" class="col-form-label">Total Nilai <label
                                    class="text-danger">*</label></label>
                            <input type="number" class="form-control" id="nilai" name="nilai">
                        </div>
                        {{-- <div class="form-group">
                            <label for="ket" class="col-form-label">Keterangan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="ket" name="ket">
                        </div> --}}
                        <div class="form-group">
                            <label for="file-penilaian" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-penilaian" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>

                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-spk">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Penilaian -->
    <div class="modal fade" id="modal-edit-penilaian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Penilaian Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_penilaian_edit"></div>
                    <form method="POST" id="form-update-penilaian" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id_pegawai_penilaian_edit" name="id_pegawai">
                        <input type="hidden" id="id-penilaian" name="id">
                        <div class="form-group">
                            <label for="tgl-penilaian-edit" class="col-form-label">Tanggal Penilaian <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control" id="tgl-penilaian-edit" name="tgl_penilaian">
                        </div>
                        <div class="form-group">
                            <label for="dep-penilaian-edit">Unit Kerja <label class="text-danger">*</label></label>
                            <select class="form-select select2 select-departemen-edit" id="dep-penilaian-edit"
                                data-placeholder="Pilih Unit Kerja" name="dep_penilaian">

                                @foreach ($deparetemen as $item)
                                    <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan-edit" class="col-form-label">Jabatan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="jabatan-edit" name="jabatan">
                        </div>
                        <div class="form-group">
                            <label for="nilai-edit" class="col-form-label">Total Nilai <label
                                    class="text-danger">*</label></label>
                            <input type="number" class="form-control" id="nilai-edit" name="nilai">
                        </div>
                        {{-- <div class="form-group">
                            <label for="ket" class="col-form-label">Keterangan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control" id="ket" name="ket">
                        </div> --}}
                        <div class="form-group">
                            <label for="file-penilaian-edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control" id="file-penilaian-edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>

                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="edit-penilaian-submit">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Penilaian PDF -->
    <div class="modal fade " id="modal-view-nilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Berkas Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-nilai"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select-departemen').select2({
                //minimumInputLength: 3,
                // minimumResultsForSearch: -1,
                theme: "bootstrap-5",
                dropdownParent: "#modal-add-penilaian",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),

            });

            $('.select-departemen-edit').select2({
                //minimumInputLength: 3,
                // minimumResultsForSearch: -1,
                theme: "bootstrap-5",
                dropdownParent: "#modal-edit-penilaian",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),

            });
        });
    </script>

    <script>
        var idpegawai = $('.id-pegawai').val();
        $(document).ready(function() {
            $('#tb-penilaian').DataTable({
                paging: false,
                scrollX: false,
                bInfo: false,
                searching: false,
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('penilaian.berkas.get') }}',
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
                        data: 'tgl_penilaian',
                        name: 'tgl_penilaian'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'jml_total',
                        name: 'jml_total'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                    
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-solid fa-bars"></i>
                                           
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modal-view-nilai" id="view-penilaian">Lihat Dokumen</a>
                                            <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-penilaian" id="edit-penilaian">Edit Dokumen</a>
                                            <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus-penilaian"  title="Hapus Dokumen">Hapus</a>
                                        </div>
                                    </div>
                                    `;
                        }
                    },

                ]
            });

            //VIEW Berkas Penilaian
            $(document).on('click', '#view-penilaian', function(e) {
                e.preventDefault();
                var penilaian = $(this).data('file');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Penilaian/' + penilaian, "#view-nilai");
            });

            //Store Berkas Penilaian
            $('#form-tambah-penilaian').on('submit', function(e) {
                e.preventDefault();
                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-penilaian')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('penilaian.berkas.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_penilaian').html("")
                            $('#error_list_penilaian').addClass("alert alert-danger")
                            $('#error_list_penilaian').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_penilaian').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modal-add-penilaian').modal('hide')
                            $('#modal-add-penilaian').find('.form-control').val("");

                            $('#tb-penilaian').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#modal-add-penilaian').on('hidden.bs.modal', function() {
                $('#modal-add-penilaian').find('.form-control').val("");
                $('#modal-add-penilaian').find('.custom-file-input').val("");
                $('.select-departemen').val(null).trigger('change');
                $('.alert-danger').addClass('d-none');
            });

            //EDIT  Berkas Penilaian
            $(document).on('click', '#edit-penilaian', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('penilaian.berkas.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-penilaian').val(response.data.id);
                        $('#id_pegawai_penilaian_edit').val(response.data.id_pegawai);
                        $('#tgl-penilaian-edit').val(response.data.tgl_penilaian);
                        $('.select-departemen-edit').val(response.data.departemen_id).trigger(
                            'change');
                        $('#jabatan-edit').val(response.data.jabatan);
                        $('#nilai-edit').val(response.data.jml_total);
                    }
                });
            });

            //UPDATE Berkas Penilaian
            $('#form-update-penilaian').on('submit', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-update-penilaian')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('penilaian.berkas.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_penilaian_edit').html("")
                            $('#error_list_penilaian_edit').addClass("alert alert-danger")
                            $('#error_list_penilaian_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_penilaian_edit').append('<li>' +
                                    error_value + '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            $('#success_message').text(response.message)
                            $('#modal-edit-penilaian').modal('hide')
                            $('#modal-edit-penilaian').find('.form-control').val("");
                            $('#tb-penilaian').DataTable().ajax.reload();
                        }
                    }
                });

            });

            $('#modal-edit-penilaian').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS  Berkas Penilaian
            $(document).on('click', '#hapus-penilaian', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Penilaian ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('penilaian.berkas.destroy') }}",
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
                            $('#tb-penilaian').DataTable().ajax.reload();

                        }
                    });
                }
            });

        });
        //END DOCUMENT READY FUNCTION
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <<<<<<< HEAD <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    =======
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    >>>>>>> 45cadeb52b1c52222b2ce0a7ea4ac6c53377f75d
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">

    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
