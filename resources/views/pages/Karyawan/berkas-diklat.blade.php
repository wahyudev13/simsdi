@extends('layouts.app')
@section('title', 'Dokumen Diklat')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Dokumen Diklat</h1>

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

                            <i class="fas fa-user-graduate fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="sertif-tab" data-toggle="tab" data-target="#sertif" type="button"
                        role="tab" aria-controls="sertif" aria-selected="true">Sertifikat Pelatihan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inhouse-tab" data-toggle="tab" data-target="#inhouse" type="button"
                        role="tab" aria-controls="berkala" aria-selected="false">Riwayat Pelatihan IHT</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="sertif" role="tabpanel" aria-labelledby="sertif-tab">

                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladd_sertif">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Sertifikat</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-sertifikat" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sertifikat</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tgl Kegiatan</th>
                                    <th>Tempat Kegiatan</th>
                                    <th>Penyelenggara</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane fade show" id="inhouse" role="tabpanel" aria-labelledby="inhouse-tab">
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="row">
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
                                        <input type="date" class="form-control to_date" id="to_date" name="to_date">
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="filter"><i
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
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tb-pelatihan" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Karyawan</th>
                                                <th>Unit Penyelenggara</th>
                                                <th>Kegiatan</th>
                                                <th>Tempat</th>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                {{-- <th>Total Waktu (jam)</th> --}}
                                                <th>Poin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            {{-- <tr class="table-info">
                                                <th colspan="8" class="text-right">Total Jam Diklat</th>
                                                <th class="total"></th>
                                            </tr> --}}
                                            <tr class="table-info">
                                                <th colspan="7" class="text-right">Total Poin Diklat</th>
                                                <th class="poin"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.container-fluid -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

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
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <!--Button Dattable-->
    <script src="{{ asset('/vendor/datatables/button/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.print.min.js') }}"></script>
    <!--SUM Datatable-->
    <script src="{{ asset('/vendor/datatables/button/js/sum().js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/plug-ins/1.13.1/api/sum().js"></script> --}}

    <script>
        $(document).ready(function() {
            var idpegawai = $('.id-pegawai').val();
            $('#tb-sertifikat').DataTable({
                paging: false,
                scrollX: false,
                bInfo: false,
                searching: false,
                // processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('karywan.diklat.sertif.get') }}',
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
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalviewSer" id="view-sertif">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#editmodal_sertif" id="edit_sertif">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" data-berkas="${data.berkas_id}" data-pegawai="${data.id_pegawai}" id="hapus"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                        }
                    },

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
                    url: "{{ route('karywan.diklat.sertif.store') }}",
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
                    url: "{{ route('karywan.diklat.sertif.edit') }}",
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
                    url: "{{ route('karywan.diklat.sertif.update') }}",
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
                        url: "{{ route('karywan.diklat.sertif.destroy') }}",
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

    <script>
        $(document).ready(function() {
            var idpegawai = $('.id-pegawai').val();
            load_data();

            function load_data(from_date = '', to_date = '') {
                $('#tb-pelatihan').DataTable({
                    paging: false,
                    scrollX: false,
                    bInfo: false,
                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('karywan.diklat.absen_iht') }}',
                        data: {
                            'id': idpegawai,
                            'from_date': from_date,
                            'to_date': to_date,
                        },
                    },
                    dom: 'Blfrtip',
                    lengthMenu: [
                        [4, 25, 50, -1],
                        ['4 Filas', '25 Filas', '50 Filas', 'Mostrar todo']
                    ],
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            footer: true
                        },
                        {
                            extend: 'pdfHtml5',
                            footer: true
                        },
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            customize: (xlsx, config, dataTable) => {
                                let sheet = xlsx.xl.worksheets['sheet1.xml'];
                                let footerIndex = $('sheetData row', sheet).length;
                                let $footerRows = $('tr', dataTable.footer());

                                // If there are more than one footer rows
                                if ($footerRows.length > 1) {
                                    // First header row is already present, so we start from the second row (i = 1)
                                    for (let i = 1; i < $footerRows.length; i++) {
                                        // Get the current footer row
                                        let $footerRow = $footerRows[i];

                                        // Get footer row columns
                                        let $footerRowCols = $('th', $footerRow);

                                        // Increment the last row index
                                        footerIndex++;

                                        // Create the new header row XML using footerIndex and append it at sheetData
                                        $('sheetData', sheet).append(`
                                            <row r="${footerIndex}">
                                            ${$footerRowCols.map((index, el) => `
                                                                                    <c t="inlineStr" r="${String.fromCharCode(65 + index)}${footerIndex}" s="2">
                                                                                    <is>
                                                                                        <t xml:space="preserve">${$(el).text()}</t>
                                                                                    </is>
                                                                                    </c>
                                                                                `).get().join('')}
                                            </row>
                                        `);
                                    }
                                }
                            }
                        },
                        'pageLength',

                    ],
                    "drawCallback": function() {
                        var api = this.api();
                        var poin = api.column(7, {
                            page: 'current'
                        }).data().sum();
                        $('.poin').text(poin);

                        // var poin = total / 4;
                        // $('.poin').text(poin);

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama_pegawai',
                            name: 'nama_pegawai'
                        },
                        {
                            data: 'nama_dep',
                            name: 'nama_dep'
                        },
                        {
                            data: 'nama_kegiatan',
                            name: 'nama_kegiatan'
                        },
                        {
                            data: 'tempat',
                            name: 'tempat'
                        },
                        {
                            data: 'masuk_at',
                            name: 'masuk_at'
                        },
                        {
                            data: 'selesai_at',
                            name: 'selesai_at'
                        },
                        // {
                        //     data: 'total_waktu',
                        //     name: 'total_waktu'
                        // },
                        {
                            data: 'poin',
                            name: 'poin'
                        },
                        // {
                        //     'data': null,
                        //     render: function(data, row, type) {
                        //         return `<a href="#" data-id="${data.id}"  data-idpegawai="${data.id_pegawai}"class="btn btn-danger btn-icon-split btn-sm"
                    //                 id="hapus-absen" title="Hapus Absen">
                    //                     <span class="icon text-white">
                    //                         <i class="fas fa-trash fa-xs"></i>
                    //                     </span>
                    //                 </a>

                    //                 `;
                        //     }
                        // },

                    ]
                });
            }

            $('#filter').click(function(e) {
                e.preventDefault();

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date != '' && to_date != '') {

                    $('#tb-pelatihan').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    // $('#tb-presensi').DataTable().destroy();
                    // load_data();
                    alert('Isi Tanggal Terlebih Dahulu')
                }


            });

            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#tb-pelatihan').DataTable().destroy();
                load_data();
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

    <link href="{{ asset('/vendor/datatables/button/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush
