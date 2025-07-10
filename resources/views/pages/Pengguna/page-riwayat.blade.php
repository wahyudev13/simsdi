@extends('layouts.app')
@section('title', 'Data Riwayat Pekerjaan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-riwayat', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Riwayat Pekerjaan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
        <div class="card-header py-3">
            @can('user-riwayat-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdRiwayat">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas Riwayat Pekerjaan</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-bordered berkas-perizinan" id="tbRiwayat" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nomor</th>
                                    <th>Berlaku Sampai</th>
                                    <th>Update</th>
                                    @if (auth()->user()->can('user-riwayat-view') ||
                                            auth()->user()->can('user-riwayat-edit') ||
                                            auth()->user()->can('user-riwayat-delete'))
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

    <!-- Modal Tambah Riwayat Pekerjaan -->
    <div class="modal fade" id="modaladdRiwayat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Riwayat Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_rw"></div>
                    <form method="POST" id="form-tambah-rw" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="id_pegawai_rw" id="id_pegawai_rw" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_rw" id="nik_rw" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_riwayat_id" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_riwayat_id" id="nama_file_riwayat_id"
                                name="nama_file_riwayat_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_perjanjian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_rw" class="col-form-label">Nomor <label class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor_rw" id="nomor_rw" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="tgl_ed" class="col-form-label">Berkalu Sampai</label>
                            <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat" class="col-form-label">Pengingat</label>
                            <input type="date" class="form-control pengingat" id="pengingat" name="pengingat">
                        </div>
                        <div class="form-group">
                            <label for="filerw" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control filerw" id="filerw" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="add_lain">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Riwayat Pekerjaan -->
    <div class="modal fade" id="modaleditRiwayat" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Riwayat Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_rw_edit"></div>
                    <form method="POST" id="form-edit-riwayat" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id-riwayat-edit" id="id-riwayat-edit" name="id">
                        <input type="hidden" class="id_pegawai_rw_edit" id="id_pegawai_rw_edit"
                            value="{{ $pegawai->id }}" name="id_pegawai">
                        {{-- <input type="hidden" class="nik_rw_edit" id="nik_rw_edit" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_riwayat_id_edit" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_riwayat_id_edit" id="nama_file_riwayat_id_edit"
                                name="nama_file_riwayat_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_perjanjian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_rw_edit" class="col-form-label">Nomor <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nomor_rw_edit" id="nomor_rw_edit" name="nomor">
                        </div>
                        <div class="form-group">
                            <label for="tgl_ed_rw_edit" class="col-form-label">Berkalu Sampai</label>
                            <input type="date" class="form-control tgl_ed_rw_edit" id="tgl_ed_rw_edit"
                                name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label>
                            <input type="date" class="form-control pengingat_rw_edit" id="pengingat_rw_edit"
                                name="pengingat">
                        </div>
                        <div class="form-group">
                            <label for="filerw" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filerw" id="filerw" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="add_lain">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View Riwayat PDF -->
    <div class="modal fade " id="modalRiwayat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dokumen Riwayat Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-riwayat-modal"></div>
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
            var tbRiwayat = $('#tbRiwayat').DataTable({
                // ordering: false,
                paging: true,
                // scrollX: true,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengguna.getRiwayat') }}',
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
                        data: function(data, row, type) {
                            if (data.tgl_ed === null && data.pengingat === null) {
                                return `
                                <center><span class="badge badge-danger"><i class="fas fa-bell-slash"></i> Tidak Ada</span></center>
                                `;
                            } else {
                                if (data.status === 'nonactive') {
                                    return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-danger"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                `;
                                } else if (data.status === 'proses') {
                                    return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Akan Berakhir (Ingatkan)</small>
                                `;
                                } else if (data.status === 'changed') {
                                    return `
                                <span class="badge badge-secondary"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-secondary"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                `;
                                } else {
                                    return `
                                <span class="badge badge-success"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span>
                                
                                `;
                                }
                            }

                        },

                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-riwayat-view') ||
                            auth()->user()->can('user-riwayat-edit') ||
                            auth()->user()->can('user-riwayat-delete'))
                        {
                            // {{ asset('/Pegawai/Dokumen/STR/${data.file}') }}
                            data: null,
                            render: function(data, row, type) {
                                return `
                           
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('user-riwayat-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-rw"  data-toggle="modal" data-target="#modalRiwayat">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-riwayat-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditRiwayat" id="edit_riwayat">Edit Dokumen</a>
                                        @endcan
                                        @can('user-riwayat-delete')
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_riwayat"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                           
                                `;
                            }
                        },
                    @endif

                ]
            });


            //VIEW Berkas Riwayat Pekerjaan
            $(document).on('click', '#view-rw', function(e) {
                e.preventDefault();
                var namafile = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/RiwayatKerja/' + namafile,
                    "#view-riwayat-modal");
            });

            $('#form-tambah-rw').on('submit', function(e) {
                e.preventDefault();
                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-rw')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.riwayat.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_rw').html("")
                            $('#error_list_rw').addClass("alert alert-danger")
                            $('#error_list_rw').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_rw').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladdRiwayat').modal('hide')
                            $('#modaladdRiwayat').find('.form-control').val("");

                            var tbRiwayat = $('#tbRiwayat').DataTable();
                            tbRiwayat.ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdRiwayat').on('hidden.bs.modal', function() {
                $('#modaladdRiwayat').find('.form-control').val("");
                $('#modaladdRiwayat').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas Riwayat Kerja
            $(document).on('click', '#edit_riwayat', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.riwayat.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-riwayat-edit').val(response.data.id);
                        $('#id_pegawai_rw_edit').val(response.data.id_pegawai);
                        //$('#nik_rw_edit').val(response.data.nik_pegawai);
                        $('#nama_file_riwayat_id_edit').val(response.data.nama_file_riwayat_id);
                        $('#nomor_rw_edit').val(response.data.nomor);
                        $('#tgl_ed_rw_edit').val(response.data.tgl_ed);
                        $('#pengingat_rw_edit').val(response.data.pengingat);
                    }
                });
            });

            //UPDATE Berkas Riwayat Kerja
            $('#form-edit-riwayat').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-riwayat-edit').val(),
                }

                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-riwayat')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.riwayat.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_rw_edit').html("")
                            $('#error_list_rw_edit').addClass("alert alert-danger")
                            $('#error_list_rw_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_rw_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditRiwayat').modal('hide')
                            $('#modaleditRiwayat').find('.form-control').val("");
                            var tbRiwayat = $('#tbRiwayat').DataTable();
                            tbRiwayat.ajax.reload();


                        }
                    }
                });
            });

            $('#modaleditRiwayat').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS Berkas Riwayat Kerja
            $(document).on('click', '#hapus_riwayat', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas Riwayat Kerja ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.riwayat.destroy') }}",
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
                            var tbRiwayat = $('#tbRiwayat').DataTable();
                            tbRiwayat.ajax.reload();

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
