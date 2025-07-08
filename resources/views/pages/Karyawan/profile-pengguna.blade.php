@extends('layouts.app')
@section('title', 'Profile')
{{-- @section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active') --}}
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profile Pengguna</h1>
    <div class="alert alert-info" role="alert">
        Pengubahan <strong>Nama, TTL, dan Alamat</strong> silakan ke Bagian Kepegawaian/SDI yaa... :)

    </div>
    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div id="error_list"></div>
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3 text-right">
            <button type="button" class="btn btn-warning btn-sm" id="edit">Edit</button>
            <button type="button" class="btn btn-primary btn-sm d-none" id="simpan">Simpan</button>
            <button type="button" class="btn btn-danger btn-sm d-none" id="batal">Batal</button>
        </div> --}}
        <div class="card-body">
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-lg-3 col-md-3 mb-4">
                        <!--left col-->
                        <div class="text-center">
                            {{-- <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"
                                class="rounded-circle avatar img-thumbnail" alt="avatar">
                            <h6>Upload a different photo...</h6>
                            <input type="file" class="text-center center-block file-upload"> --}}
                            {!! QrCode::size(200)->generate($pegawai->nik) !!}
                        </div>
                    </div>
                    <!--/col-3-->
                    <input type="hidden" id="id-pegawai" value="{{ $pegawai->id }}">
                    <div class="col-md-9">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>NIP</strong></td>
                                    <td>{{ $pegawai->nik }}</td>
                                </tr>
                                <tr>
                                    <td> <strong>Nama</strong></td>
                                    <td>{{ $pegawai->nama }}</td>
                                </tr>
                                {{-- <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>{{$pegawai->jk}}</td>
                              </tr> --}}
                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td>{{ $pegawai->jbtn }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Departemen</strong></td>
                                    <td>{{ $pegawai->nm_dep }}</td>
                                </tr>
                                <input type="hidden" name="id" id="id-pengguna" value="{{ $pengguna->id }}">
                                {{-- <tr>
                                    <td><strong>Email</strong></td>
                                    <td><input type="email" id="emailid" value="{{ $pengguna->email }}"
                                            class="form-control-plaintext form-control-sm" readonly></td>
                                </tr> --}}

                            </tbody>
                        </table>
                    </div>

                </div>
                <!--/row-->
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="biodata-tab" data-toggle="tab" data-target="#biodata"
                                    type="button" role="tab" aria-controls="biodata"
                                    aria-selected="true">Biodata</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Karyawan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="alamat-tab" data-toggle="tab" data-target="#alamat"
                                    type="button" role="tab" aria-controls="alamat"
                                    aria-selected="false">Alamat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="absen-tab" data-toggle="tab" data-target="#absen"
                                    type="button" role="tab" aria-controls="absen" aria-selected="false">Riwayat
                                    Presensi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="identitas-tab" data-toggle="tab" data-target="#identitas"
                                    type="button" role="tab" aria-controls="identitas" aria-selected="false">Dokumen
                                    Data Diri</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="biodata" role="tabpanel"
                                aria-labelledby="biodata-tab">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><strong>NIK</strong></td>
                                            <td>{{ $pegawai->no_ktp }}</td>

                                        </tr>
                                        <tr>
                                            <td><strong>Status Aktif</strong></td>
                                            <td>{{ $pegawai->stts_aktif }}</td>

                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Kelamin</strong></td>
                                            <td>{{ $pegawai->jk }}</td>

                                        </tr>
                                        <tr>
                                            <td><strong>Tempat Lahir</strong></td>
                                            <td>{{ $pegawai->tmp_lahir }}</td>

                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Lahir</strong></td>
                                            <td>{{ $pegawai->tgl_lahir }}</td>

                                        </tr>
                                        <tr>
                                            <td><strong>Pendidikan</strong></td>
                                            <td>{{ $pegawai->pendidikan }}</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Status Karyawan</strong></td>
                                            <td>{{ $pegawai->ktg }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mulai Kerja</strong></td>
                                            <td>{{ $pegawai->mulai_kerja }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mulai Kontrak</strong></td>
                                            <td>{{ $pegawai->mulai_kontrak }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Departemen</strong></td>
                                            <td>{{ $pegawai->nm_dep }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Alamat</strong></td>
                                            <td>{{ $pegawai->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kota</strong></td>
                                            <td>{{ $pegawai->kota }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="absen" role="tabpanel" aria-labelledby="absen-tab">
                                <div class="row mt-3">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {{-- <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label> --}}
                                            <input type="date" class="form-control from_date" id="from_date"
                                                name="from_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-1 text-center">
                                        <label for="" class="col-form-label">S/D</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {{-- <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label> --}}
                                            <input type="date" class="form-control to_date" id="to_date"
                                                name="to_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" id="filter-presensi"><i
                                                    class="fas fa-filter"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-warning" id="refresh"><i
                                                    class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered " id="tb-presensi" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Shift</th>
                                                <th>Jama Datang</th>
                                                <th>Jam Pulang</th>
                                                <th>Status</th>
                                                <th>Keterlambatan</th>
                                                <th>Durasi</th>
                                                {{-- <th>Catatan</th> --}}
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="identitas" role="tabpanel" aria-labelledby="identitas-tab">
                                <div class="button-add mb-4 mt-4">
                                    <a href="#" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal"
                                        data-target="#modaladdLain">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Tambah Berkas Data Diri</span>
                                    </a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tb-identitas" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    <!-- Modal Tambah Berkas Data Diri -->
    <div class="modal fade" id="modaladdLain" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Data Diri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_lain"></div>
                    <form method="POST" id="form-tambah-lain" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="id_pegawai_lain" id="id_pegawai_lain" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_lain" id="nik_lain" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_lain_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_lain_id" id="nama_file_lain_id"
                                name="nama_file_lain_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_identitas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filelain" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filelain" id="filelain" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add_lain">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Berkas Data Diri -->
    <div class="modal fade" id="modaleditLain" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_lain_edit"></div>
                    <form method="POST" id="form-edit-lain" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id-lain-edit" name="id">
                        <div class="form-group">
                            <label for="nama_file_lain_id_edit" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_lain_id_edit" id="nama_file_lain_id_edit"
                                name="nama_file_lain_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_identitas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filelain_edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control filelain_edit" id="filelain_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="submit_edit_lain">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal-->
    <!-- Modal View Lain PDF -->
    <div class="modal fade " id="modalLain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Berkas Lain-Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-lain-modal"></div>
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

            load_data();

            function load_data(from_date = '', to_date = '') {
                var tbpresensi = $('#tb-presensi').DataTable({
                    // paging: false,
                    // scrollX: false,
                    // bInfo: false,
                    // searching: false,
                    // processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('pengguna.presensi') }}',
                        data: {
                            'id': idpegawai,
                            'from_date': from_date,
                            'to_date': to_date,
                        },
                    },
                    columns: [{
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'shift',
                            name: 'shift'
                        },
                        {
                            data: 'jam_datang',
                            name: 'jam_datang'
                        },
                        {
                            data: 'jam_pulang',
                            name: 'jam_pulang'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'keterlambatan',
                            name: 'keterlambatan'
                        },
                        {
                            data: 'durasi',
                            name: 'durasi'
                        },
                        // {
                        //     data: 'keterangan',
                        //     name: 'keterangan'
                        // },
                        // {
                        //     'data': null,
                        //     render: function(data, row, type) {
                        //         return `
                    //             <div class="btn-group">
                    //                 <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    //                     <i class="fas fa-solid fa-bars"></i>

                    //                 </button>
                    //                 <div class="dropdown-menu">

                    //                     <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#editmodalUpload" id="editberkas">Edit Dokumen</a>
                    //                     <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus"  title="Hapus Dokumen">Hapus</a>
                    //                 </div>
                    //             </div>
                    //             `;
                        //     }
                        // },

                    ]
                });
            }


            $('#filter-presensi').click(function(e) {
                e.preventDefault();

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date != '' && to_date != '') {

                    $('#tb-presensi').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    // $('#tb-presensi').DataTable().destroy();
                    // load_data();
                    alert('Isi Tanggal Terleih Dahulu')
                }


            });

            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#tb-presensi').DataTable().destroy();
                load_data();
            });

            var tbIdentitas = $('#tb-identitas').DataTable({
                // ordering: false,
                paging: false,
                // scrollX: true,
                bInfo: false,
                searching: false,
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengguna.getFileId') }}',
                // ajax: route('berkas.lain.getFile', +idpegawai),
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
                        data: null,
                        render: function(data, row, type) {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-lain"  data-toggle="modal" data-target="#modalLain">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditLain" id="edit_lain">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_lain"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                        }
                    },

                ]
            });

            //VIEW Berkas Lain
            $(document).on('click', '#view-lain', function(e) {
                e.preventDefault();
                var namafile = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/Identitas/' + namafile, "#view-lain-modal");
            });

            $('#form-tambah-lain').on('submit', function(e) {
                e.preventDefault();
                //var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\","");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-lain')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('berkas.lain.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_lain').html("")
                            $('#error_list_lain').addClass("alert alert-danger")
                            $('#error_list_lain').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_lain').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modaladdLain').modal('hide')
                            $('#modaladdLain').find('.form-control').val("");

                            var tbLain = $('#tb-identitas').DataTable();
                            tbLain.ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdLain').on('hidden.bs.modal', function() {
                $('#modaladdLain').find('.form-control').val("");
                $('#modaladdLain').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas Lain
            $(document).on('click', '#edit_lain', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('berkas.lain.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-lain-edit').val(response.data.id);
                        $('#nama_file_lain_id_edit').val(response.data.nama_file_lain_id);
                    }
                });
            });

            //UPDATE Berkas Lain
            $('#form-edit-lain').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-lain-edit').val(),
                }

                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-lain')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('berkas.lain.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_lain_edit').html("")
                            $('#error_list_lain_edit').addClass("alert alert-danger")
                            $('#error_list_lain_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_lain_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditLain').modal('hide')
                            $('#modaleditLain').find('.form-control').val("");
                            var tbLain = $('#tb-identitas').DataTable();
                            tbLain.ajax.reload();


                        }
                    }
                });
            });

            $('#modaleditLain').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS Lain
            $(document).on('click', '#hapus_lain', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('berkas.lain.destroy') }}",
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
                            var tbLain = $('#tb-identitas').DataTable();
                            tbLain.ajax.reload();

                        }
                    });
                }
            });

            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.avatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-upload").on('change', function() {
                readURL(this);
            });
        });
    </script>
@endpush
@push('custom-css')
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
