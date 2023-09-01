@extends('layouts.app')
@section('title', 'Data Pendidikan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-pendidikan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pendidikan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('Tambah Ijazah')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modal-add-ijazah">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas Ijazah</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tb-pendidikan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor</th>
                                <th>Asal</th>
                                <th>Tahun Lulus</th>
                                <th>Update</th>
                                @if(auth()->user()->can('View Ijazah') || auth()->user()->can('Edit Ijazah') || auth()->user()->can('Hapus Ijazah'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
                <!--end-->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    {{-- Transkrip --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('Tambah Transkrip')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modal-add-trans">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas Transkrip</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="tb-trans" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor</th>
                                <th>Update</th>
                                @if(auth()->user()->can('View Transkrip') || auth()->user()->can('Edit Transkrip') || auth()->user()->can('Hapus Transkrip'))
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
                <!--end-->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    <!-- Modal Tambah Ijzah -->
    <div class="modal fade" id="modal-add-ijazah" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form method="POST" id="form-tambah-ijazah" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik" id="nik" value="{{ $pegawai->nik }}"
                         name="nik_pegawai"> --}}
                        <div class="form-group">
                            <label for="nama_file_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_id" id="nama_file_id" name="nama_file_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach

                            </select>

                        </div>
                        <div class="form-group">
                            <label for="nomor" class="col-form-label">Nomor<label class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor" id="nomor" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="asal" class="col-form-label">Asal<label class="text-danger">*</label></label>
                            <input type="text" class="form-control asal" id="asal" name="asal">
                        </div>
                        <div class="form-group">
                            <label for="thn_lulus" class="col-form-label">Tahun Lulus<label
                                    class="text-danger">*</label></label>
                            <input type="number" class="form-control thn_lulus" id="thn_lulus" name="thn_lulus">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span class="badge badge-secondary">.pdf
                                </span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-login" id="add_file">Simpan</button>
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
    <!-- ./ end Modal Berkas -->

    <!-- Modal Edit Ijzah -->
    <div class="modal fade" id="modal-edit-ijazah" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form method="POST" id="form-update-ijazah" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="form-control" id="id-ijazah-edit" name="id">
                        <input type="hidden" class="form-control" id="id-pegawai-edit" name="id_pegawai">
                        {{-- <input type="hidden" class="form-control" id="nik-edit" name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_id" id="nama-file-edit" name="nama_file_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor" class="col-form-label">Nomor<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor" id="nomor-edit" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="asal" class="col-form-label">Asal<label class="text-danger">*</label></label>
                            <input type="text" class="form-control asal" id="asal_edit" name="asal">
                        </div>
                        <div class="form-group">
                            <label for="thn_lulus" class="col-form-label">Tahun Lulus<label
                                    class="text-danger">*</label></label>
                            <input type="number" class="form-control thn_lulus" id="lulus-edit" name="thn_lulus">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file-edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="update_file">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Berkas -->

    <!-- Modal View Ijzah PDF -->
    <div class="modal fade " id="modalIjazah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ijazah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-ijazah-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Transkrip PDF -->
    <div class="modal fade " id="modalTranskrip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trannskrip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-transkrip-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->


    <!-- Modal Tambah Transkrip Akademik -->
    <div class="modal fade" id="modal-add-trans" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Transkrip Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_trans"></div>
                    <form method="POST" id="form-tambah-trans" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik" id="nik" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}
                        <div class="form-group">
                            <label for="nama_file_trans_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_trans_id" id="nama_file_trans_id"
                                name="nama_file_trans_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_transkrip" class="col-form-label">Nomor Transkrip<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor_transkrip" id="nomor_transkrip"
                                name="nomor_transkrip">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_transkrip">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Transkrip Akademik -->

    <!-- Modal Edit Transkrip Akademik -->
    <div class="modal fade" id="modaleditTrans" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Transkrip Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_trans_edit"></div>
                    <form method="POST" id="form-edit-trans" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="form-control" id="id-trans-edit" name="id">
                        <input type="hidden" class="form-control" id="id-trans-pegawai-edit" name="id_pegawai">
                        {{-- <input type="hidden" class="form-control" id="nik-trans-edit" name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_trans_id_edit" class="col-form-label">Nama Dokumen</label>
                            <select class="custom-select nama_file_trans_id_edit" id="nama_file_trans_id_edit"
                                name="nama_file_trans_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_pendidikan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_transkrip_edit" class="col-form-label">Nomor Transkrip</label>
                            <input type="text" class="form-control nomor_transkrip_edit" id="nomor_transkrip_edit"
                                name="nomor_transkrip">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="update_trans">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Transkrip Akademik -->

    <!-- Modal View Transkrip PDF -->
    <div class="modal fade " id="modalTranskrip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trannskrip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-transkrip-modal"></div>
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
        var idpegawai = $('#id-pegawai').val();
        $(document).ready(function() {
            $('#tb-pendidikan').DataTable({
                paging: true,
                scrollX: false,
                bInfo: true,
                searching: false,
                // processing: true,
                serverSide: true,
                ajax: '{{route('pengguna.getijazah')}}',
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
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'asal',
                        name: 'asal'
                    },
                    {
                        data: 'thn_lulus',
                        name: 'thn_lulus'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if(auth()->user()->can('View Ijazah') || auth()->user()->can('Edit Ijazah') || auth()->user()->can('Hapus Ijazah'))
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                           
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-solid fa-bars"></i>
                                           
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('View Ijazah')
                                            <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalIjazah" id="view-ijazah">Lihat Dokumen</a>
                                            @endcan
                                            @can('Edit Ijazah')
                                            <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-ijazah" id="editberkas">Edit Dokumen</a>
                                            @endcan
                                            @can('Hapus Ijazah')
                                            <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus"  title="Hapus Dokumen">Hapus</a>
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
            $(document).on('click', '#view-ijazah', function(e) {
                e.preventDefault();
                var ijazah = $(this).data('id');
                var url = '{{route('login.index')}}';
                // console.log(url);
                PDFObject.embed(url+'/File/Pegawai/Dokumen/Ijazah/'+ijazah, "#view-ijazah-modal");
            });

            //STORE IJAZAH
            $('#form-tambah-ijazah').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-ijazah')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.ijazah.store') }}",
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
                            $('#modal-add-ijazah').modal('hide')
                            $('#modal-add-ijazah').find('.form-control').val("");

                            $('.btn-login').removeClass("d-none");
                            $('.btn-login-disabled').addClass("d-none");

                            $('#tb-pendidikan').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#modal-add-ijazah').on('hidden.bs.modal', function() {
                $('#modal-add-ijazah').find('.form-control').val("");
                $('#modal-add-ijazah').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT IJAZAH
            $(document).on('click', '#editberkas', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.ijazah.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {

                        // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                        $('#id-ijazah-edit').val(response.data.id);
                        $('#id-pegawai-edit').val(response.data.id_pegawai);
                        // $('#nik-edit').val(response.data.nik_pegawai);
                        $('#nama-file-edit').val(response.data.nama_file_id);
                        $('#nomor-edit').val(response.data.nomor);
                        $('#asal_edit').val(response.data.asal);
                        $('#lulus-edit').val(response.data.thn_lulus);
                        // $('#file-edit').val(response.data.file);

                    }
                });
            });


            //UPDATE Berkas Ijazah
            $('#form-update-ijazah').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-ijazah-edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-update-ijazah')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.ijazah.update') }}",
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
                            $('#modal-edit-ijazah').modal('hide')
                            $('#modal-edit-ijazah').find('.form-control').val("");
                            $('#tb-pendidikan').DataTable().ajax.reload();


                        }
                    }
                });

            });

            $('#modal-edit-ijazah').on('hidden.bs.modal', function() {
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
                        url: "{{ route('pengguna.ijazah.destroy') }}",
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
                            $('#tb-pendidikan').DataTable().ajax.reload();

                        }
                    });
                }
            });
        });
        //END DOCUMENT READY FUNCTION
    </script>

    <script>
        $(document).ready(function() {
            $('#tb-trans').DataTable({
                paging: true,
                scrollX: false,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{route('pengguna.gettrans')}}',
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
                        data: 'nomor_transkrip',
                        name: 'nomor_transkrip'
                    },

                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if(auth()->user()->can('View Transkrip') || auth()->user()->can('Edit Transkrip') || auth()->user()->can('Hapus Transkrip'))
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                            
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-solid fa-bars"></i>
                                        
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('View Transkrip')
                                            <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" data-toggle="modal" data-target="#modalTranskrip" id="view-trasnkrip">Lihat Dokumen</a>
                                            @endcan
                                            @can('Edit Transkrip')
                                            <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditTrans" id="edit_trans">Edit Dokumen</a>
                                            @endcan
                                            @can('Hapus Transkrip')
                                            <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_trans"  title="Hapus Dokumen">Hapus</a>
                                            @endcan
                                        </div>
                                    </div>
                           
                            `;
                        }
                    },
                    @endif

                ]
            });

            //VIEW Berkas Trans
            $(document).on('click', '#view-trasnkrip', function(e) {
                e.preventDefault();
                var transkripfile = $(this).data('id');
                var url = '{{route('login.index')}}';
                PDFObject.embed(url+'/File/Pegawai/Dokumen/Transkrip/' + transkripfile,
                    "#view-transkrip-modal");
            });

            //STORE Trans
            $('#form-tambah-trans').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-trans')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.trans.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_trans').html("")
                            $('#error_list_trans').addClass("alert alert-danger")
                            $('#error_list_trans').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_trans').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modal-add-trans').modal('hide')
                            $('#modal-add-trans').find('.form-control').val("");
                            $('#tb-trans').DataTable().ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdTrans').on('hidden.bs.modal', function() {
                $('#modaladdTrans').find('.form-control').val("");
                $('#modaladdTrans').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas Transkrip
            $(document).on('click', '#edit_trans', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.trans.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-trans-edit').val(response.data.id);
                        $('#id-trans-pegawai-edit').val(response.data.id_pegawai);
                        //$('#nik-trans-edit').val(response.data.nik_pegawai);
                        $('#nama_file_trans_id_edit').val(response.data.nama_file_trans_id);
                        $('#nomor_transkrip_edit').val(response.data.nomor_transkrip);
                    }
                });
            });

            //UPDATE Berkas Transkrip
            $('#form-edit-trans').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-trans-edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-trans')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.trans.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_trans_edit').html("")
                            $('#error_list_trans_edit').addClass("alert alert-danger")
                            $('#error_list_trans_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_trans_edit').append('<li>' +
                                    error_value + '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditTrans').modal('hide')
                            $('#modaleditTrans').find('.form-control').val("");
                            $('#tb-trans').DataTable().ajax.reload();


                        }
                    }
                });
            });

            $('#modaleditTrans').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS transkrip
            $(document).on('click', '#hapus_trans', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data Transkrip ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.transkrip.destroy') }}",
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
                            $('#tb-trans').DataTable().ajax.reload();

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
