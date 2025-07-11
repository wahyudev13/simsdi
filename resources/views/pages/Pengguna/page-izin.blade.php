@extends('layouts.app')
@section('title', 'Data Perizinan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-izin', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Perizinan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
        <div class="card-header py-3">
            @can('user-str-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdSTR">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas STR</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-perizinan" id="tbSTR" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor REG</th>
                                <th>Bidang Kesehatan</th>
                                <th>Masa Berlaku</th>
                                <th>Verifikasi</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-str-view') ||
                                        auth()->user()->can('user-str-edit') ||
                                        auth()->user()->can('user-str-delete'))
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

    {{-- SIP --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-sip-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdSIP">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas SIP</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-perizinan" id="tbSIP" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor SIP</th>
                                <th>Nomor Reg STR</th>
                                <th>Bidang Kesehatan</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-sip-view') ||
                                        auth()->user()->can('user-sip-edit') ||
                                        auth()->user()->can('user-sip-delete'))
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

    <!-- Modal STR -->
    @include('components.modal-str')
    @include('components.modal-sip')
    @include('components.modal-verifikasi')
    @include('components.modals.modal-str-view')
    @include('components.modals.modal-sip-view')
    @include('components.modals.modal-verifikasi-str-view')
    @include('components.modal-bukti-str')

@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select-str').select2({
                minimumResultsForSearch: -1,
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('str.get') }}',
                    dataType: 'json',
                    // data: function(params) {
                    //     var query = {
                    //         search: params.term,
                    //     }

                    //     // Query parameters will be ?search=[term]&type=public
                    //     return query;
                    // },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaladdSIP",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                //placeholder: $(this).data('placeholder'),

            });

            $('.select-str-edit').select2({
                //minimumInputLength: 3,
                minimumResultsForSearch: -1,
                ajax: {
                    type: "GET",
                    url: '{{ route('str.get') }}',
                    dataType: 'json',
                    // data: function(params) {
                    //     var query = {
                    //         search: params.term,
                    //     }

                    //     // Query parameters will be ?search=[term]&type=public
                    //     return query;
                    // },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaleditSIP",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                //placeholder: $(this).data('placeholder'),

            });
        });
    </script>

    <!-- STR -->
    <script>
        var idpegawai = $('#id-pegawai').val();
        $(document).ready(function() {

            var tabelSTR = $('#tbSTR').DataTable({
                // ordering: false,
                paging: true,
                // scrollX: true,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengguna.getSTR') }}',
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
                        data: 'no_reg_str',
                        name: 'no_reg_str'
                    },
                    {
                        data: 'kompetensi',
                        name: 'kompetensi'
                    },
                    {
                        data: function(data, row, type) {
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
                            } else if (data.status === 'lifetime') {
                                return `
                            <span class="badge badge-success">STR Seumur Hidup</span>
                                `;
                            } else {
                                return `
                                <span class="badge badge-success"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span>
                                
                                `;
                            }
                        }
                    },
                    {
                        data: function(data, row, type) {
                            if (data.id_verif_str === null) {
                                return `
                            <a class="badge badge-danger" href="#" data-id="${data.id}" title="Upload Bukti" data-toggle="modal" data-target="#modal-add-bukti-str" id="add-bukti-str">
                               <i class="fas fa-times"></i> Belum Ada Bukti Verifikasi
                            </a>
                            `
                            } else {
                                return ` 
                            <a class="badge badge-success" href="#" data-verifstr="${data.file_verif}" data-ket="${data.keterangan}" title="Lihat Bukti" data-toggle="modal" data-target="#modal-verstr" id="view-bukti-str">
                               <i class="fas fa-check"></i> Sudah Ada Bukti Verifikasi
                            </a><br>
                            
                            <a class="badge badge-danger" href="#" data-id="${data.id_verif_str}" title="Hapus Bukti" id="hapus-bukti-str">
                               <i class="fas fa-trash"></i> Hapus
                            </a>
                            `
                            }
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-str-view') ||
                            auth()->user()->can('user-str-edit') ||
                            auth()->user()->can('user-str-delete'))
                        {
                            // {{ asset('/File/Pegawai/Dokumen/STR/${data.file}') }}
                            data: null,
                            render: function(data, row, type) {
                                return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" title="Aksi Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('user-str-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-str"  data-toggle="modal" data-target="#modalSTR">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-str-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSTR" id="edit_str">Edit Dokumen</a>
                                        @endcan
                                        @can('user-str-delete')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_str"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                        `;
                            }
                        },
                    @endif
                ]
            });


            //VIEW Berkas STR
            $(document).on('click', '#view-str', function(e) {
                e.preventDefault();
                var namafile = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/STR/' + namafile, "#view-str-modal");
            });

            $('#form-tambah-str').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-str')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.str.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_str').html("")
                            $('#error_list_str').addClass("alert alert-danger")
                            $('#error_list_str').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_str').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladdSTR').modal('hide')
                            $('#modaladdSTR').find('.form-control').val("");
                            $('#tbSTR').DataTable().ajax.reload();

                            // location.reload();
                        }
                    }
                });
            });

            $('#modaladdSTR').on('hidden.bs.modal', function() {
                $('#modaladdSTR').find('.form-control').val("");
                $('#modaladdSTR').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas STR
            $(document).on('click', '#edit_str', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.str.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-str-edit').val(response.data.id);
                        $('#id-str-pegawai-edit').val(response.data.id_pegawai);
                        // $('#nik-str-edit').val(response.data.nik_pegawai);
                        $('#nama_file_str_id_edit').val(response.data.nama_file_str_id);
                        $('#no_reg_str_edit').val(response.data.no_reg_str);
                        $('#kompetensi_edit').val(response.data.kompetensi);
                        $('#tgl_ed_edit').val(response.data.tgl_ed);
                        $('#pengingat_edit').val(response.data.pengingat);
                    }
                });
            });

            //UPDATE Berkas STR
            $('#form-edit-str').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-str-edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-str')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.str.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_str_edit').html("")
                            $('#error_list_str_edit').addClass("alert alert-danger")
                            $('#error_list_str_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_str_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditSTR').modal('hide')
                            $('#modaleditSTR').find('.form-control').val("");
                            var tbSTR = $('#tbSTR').DataTable();
                            tbSTR.ajax.reload();

                            // location.reload();


                        }
                    }
                });
            });

            $('#modaleditSTR').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS STR
            $(document).on('click', '#hapus_str', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas STR ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.str.destroy') }}",
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
                            var tbSTR = $('#tbSTR').DataTable();
                            tbSTR.ajax.reload();

                            // location.reload();

                        }
                    });
                }
            });


        });
    </script>

    <!-- VERIF STR -->
    <script>
        $(document).ready(function() {
            //VIEW Bukti Verifikasi
            $(document).on('click', '#view-bukti-str', function(e) {
                e.preventDefault();
                var bukti = $(this).data('verifstr');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/STR/Verifikasi/' + bukti,
                    "#view-verstr-modal");

                var keterangan = $(this).data('ket');
                $('#ket-verif-str').text(keterangan);
            });

            //View Modal ADD Bukti Verifikasi Ijazah
            $('table').on('click', '#add-bukti-str', function(e) {
                e.preventDefault();
                var str = $(this).data('id');
                $('#id-str-bukti').val(str);

            });

            $('#modal-add-bukti-str').on('hidden.bs.modal', function() {
                $('#modal-add-bukti-str').find('.form-control').val("");
                $('#modal-add-bukti-str').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            $('#form-tambah-bukti-str').on('submit', function(e) {
                e.preventDefault();
                // var file = $('.file').val();
                // var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-bukti-str')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.verif.str.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_bukti_str').html("")
                            $('#error_list_bukti_str').addClass("alert alert-danger")
                            $('#error_list_bukti_str').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_bukti_str').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modal-add-bukti-str').modal('hide')
                            $('#modal-add-bukti-str').find('.form-control').val("");

                            var tbSTR = $('#tbSTR').DataTable();
                            tbSTR.ajax.reload();
                        }
                    }
                });
            });

            //HAPUS Bukti Verifikasi STR
            $(document).on('click', '#hapus-bukti-str', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Bukti Verifikasi STR ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.verif.str.destroy') }}",
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
                            var tbSTR = $('#tbSTR').DataTable();
                            tbSTR.ajax.reload();

                        }
                    });
                }
            });
        });
    </script>


    <!-- SIP -->
    <script>
        $(document).ready(function() {
            var tabelSTR = $('#tbSIP').DataTable({
                // ordering: false,
                paging: true,
                // scrollX: true,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengguna.getSIP') }}',
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
                        data: 'no_sip',
                        name: 'no_sip'
                    },
                    {
                        data: 'no_reg_str',
                        name: 'no_reg_str'
                    },
                    {
                        data: 'kompetensi',
                        name: 'kompetensi'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-sip-view') ||
                            auth()->user()->can('user-sip-edit') ||
                            auth()->user()->can('user-sip-delete'))
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
                                        @can('user-sip-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}"   title="Lihat Dokumen" id="view-sip"  data-toggle="modal" data-target="#modalSIP">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-sip-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSIP" id="edit_sip">Edit Dokumen</a>
                                        @endcan
                                        @can('user-sip-delete')
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_sip"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                           
                                `;
                            }
                        },
                    @endif
                ]
            });

            //VIEW Berkas SIP
            $(document).on('click', '#view-sip', function(e) {
                e.preventDefault();
                var fileSIP = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/SIP/' + fileSIP, "#view-sip-modal");
            });

            $('#form-tambah-sip').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-sip')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.sip.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_sip').html("")
                            $('#error_list_sip').addClass("alert alert-danger")
                            $('#error_list_sip').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_sip').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladdSIP').modal('hide')
                            $('#modaladdSIP').find('.form-control').val("");

                            var tbSIP = $('#tbSIP').DataTable();
                            tbSIP.ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdSIP').on('hidden.bs.modal', function() {
                $('#modaladdSIP').find('.form-control').val("");
                $('#modaladdSIP').find('.custom-file-input').val("");
                $('.select-str').val(null).trigger('change');
                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas SIp
            $(document).on('click', '#edit_sip', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.sip.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {

                        $('#id-sip-edit').val(response.data.id);
                        $('#nama_file_sip_id_edit').val(response.data.nama_file_sip_id);
                        $('#no_sip_edit').val(response.data.no_sip);
                        $('#no_reg_sip_edit').val(response.data.no_reg);
                    }
                });
            });

            //UPDATE Berkas SIP
            $('#form-edit-sip').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-sip-edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-sip')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.sip.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_sip_edit').html("")
                            $('#error_list_sip_edit').addClass("alert alert-danger")
                            $('#error_list_sip_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_sip_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditSIP').modal('hide')
                            $('#modaleditSIP').find('.form-control').val("");
                            var tbSIP = $('#tbSIP').DataTable();
                            tbSIP.ajax.reload();
                        }
                    }
                });
            });

            $('#modaleditSIP').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
                $('.select-str-edit').val(null).trigger('change');
            });

            //HAPUS SIP
            $(document).on('click', '#hapus_sip', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas SIP ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.sip.destroy') }}",
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
                            var tbSIP = $('#tbSIP').DataTable();
                            tbSIP.ajax.reload();

                        }
                    });
                }
            });

            // JavaScript for checkbox functionality
            document.getElementById('enable_exp_str').onchange = function() {
                if (this.checked) {
                    document.getElementById('masa-berlaku').innerHTML = `
                        <div class="form-group">
                            <label for="tgl_ed" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed" disabled>
                        </div>
                        <div class="form-group">
                            <label for="pengingat" class="col-form-label">Tgl Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat" id="pengingat" name="pengingat" disabled>
                        </div>
                    `
                } else {
                    document.getElementById('masa-berlaku').innerHTML = ``
                }
                document.getElementById('tgl_ed').disabled = !this.checked;
                document.getElementById('pengingat').disabled = !this.checked;
            };

            document.getElementById('enable_exp_str_edit').onchange = function() {
                if (this.checked) {
                    document.getElementById('masa-berlaku-edit').innerHTML = `
                        <div class="form-group">
                            <label for="tgl_ed_edit" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed_edit" id="tgl_ed_edit" name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat_edit" class="col-form-label">Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat_edit" id="pengingat_edit"
                                name="pengingat">
                        </div>
                    `
                } else {
                    document.getElementById('masa-berlaku-edit').innerHTML = ``
                }
                document.getElementById('tgl_ed_edit').disabled = !this.checked;
                document.getElementById('pengingat_edit').disabled = !this.checked;
            };
        });
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">

    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
