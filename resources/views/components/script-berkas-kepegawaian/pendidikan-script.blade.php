@props([
    //ijazah
    'tableIjazahId' => 'tb-ijazah',
    'ijazahRoute' => 'berkas.getIjazah',
    'ijazahStoreRoute' => 'berkas.ijazah.store',
    'ijazahEditRoute' => 'berkas.ijazah.edit',
    'ijazahUpdateRoute' => 'berkas.ijazah.update',
    'ijazahDestroyRoute' => 'berkas.ijazah.destroy',
    'verifIjazahStoreRoute' => 'verif.ijazah.store',
    'verifIjazahDestroyRoute' => 'verif.ijazah.destroy',
    //transkrip
    'tableTranskripId' => 'tb-transkrip',
    'transkripRoute' => 'berkas.getTranskrip',
    'transkripStoreRoute' => 'berkas.transkrip.store',
    'transkripEditRoute' => 'berkas.transkrip.edit',
    'transkripUpdateRoute' => 'berkas.transkrip.update',
    'transkripDestroyRoute' => 'berkas.transkrip.destroy',
    //pdf
    'routeIjazahPDF' => '/karyawan/ijazah/view/',
    'routeVerifIjazahPDF' => '/karyawan/ijazah/verif/view/',
    'routeTranskripPDF' => '/karyawan/transkrip/view/',
    'aksesPage' => 'admin',
])

<script>
    $(document).ready(function() {
        // Variabel untuk menyimpan instance DataTable
        let ijazahTable = null;
        let transkripTable = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        //============================AKSES PAGE PENGGUNA============================//
        if ('{{ $aksesPage }}' == 'user') {
            @if (auth()->user()->can('user-ijazah-view'))
                initIjazahTable();
            @endif
            @if (auth()->user()->can('user-transkrip-view'))
                initTranskripTable();
            @endif
        }

        // Fungsi untuk inisialisasi DataTable Ijazah
        function initIjazahTable() {
            if (ijazahTable) return;
            ijazahTable = $('#{{ $tableIjazahId }}').DataTable({
                paging: false,
                bInfo: false,
                searching: false,
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($ijazahRoute) }}',
                    data: {
                        'id': idpegawai
                    }
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
                        data: null,
                        render: function(data) {
                            @if ($aksesPage === 'admin')
                                if (data.id_verif === null) {
                                    return `<a class="badge badge-danger" id="upload-verif-ijazah" href="#" data-id="${data.id_ijazah}" data-toggle="modal" data-target="#modal-add-bukti">Belum Diverifikasi</a>`;
                                } else {
                                    return `<span class="d-flex align-items-center gap-2">
                                        <a class="badge badge-success mr-2" id="view-verif-ijazah" href="#" data-file="${data.file_verif}" data-ket="${data.keterangan}" data-toggle="modal" data-target="#modal-verijazah">Sudah Diverifikasi</a>
                                        <a class="badge badge-danger" href="#" data-id="${data.id_verif}" title="Hapus" id="hapus-verif-ijazah"><i class="fas fa-trash"></i> Hapus</a>
                                    </span>`;
                                }
                            @else
                                if (data.id_verif === null) {
                                    return `<span class="badge badge-danger">Belum Diverifikasi</span>`;
                                } else {
                                    return `<span class="badge badge-success">Sudah Diverifikasi</span>`;
                                }
                            @endif
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-ijazah-view') ||
                            auth()->user()->can('user-ijazah-edit') ||
                            auth()->user()->can('user-ijazah-delete'))
                        {
                            data: null,
                            render: function(data) {
                                return `
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-solid fa-bars"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('user-ijazah-view')
                                    <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalIjazah" id="view-ijazah">Lihat Dokumen</a>
                                @endcan
                                @can('user-ijazah-edit')
                                    <a class="dropdown-item" href="#" data-id="${data.id_ijazah}" title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-ijazah" id="edit-ijazah">Edit Dokumen</a>
                                @endcan
                                @can('user-ijazah-delete')
                                    <a class="dropdown-item text-danger" href="#" data-id="${data.id_ijazah}" id="hapus" title="Hapus Dokumen">Hapus</a>
                                @endcan    
                            </div>
                        </div>
                    `;
                            }
                        }
                    @endif
                ]
            });
        }

        // Fungsi untuk inisialisasi DataTable Transkrip
        function initTranskripTable() {
            if (transkripTable) return;
            transkripTable = $('#{{ $tableTranskripId }}').DataTable({
                paging: false,
                bInfo: false,
                searching: false,
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($transkripRoute) }}',
                    data: {
                        'id': idpegawai
                    }
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
                        data: 'nomor_transkrip',
                        name: 'nomor_transkrip'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-transkrip-view') ||
                            auth()->user()->can('user-transkrip-edit') ||
                            auth()->user()->can('user-transkrip-delete'))
                        {
                            data: null,
                            render: function(data) {
                                return `
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-solid fa-bars"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('user-transkrip-view')
                                    <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalTranskrip" id="view-transkrip">Lihat Dokumen</a>
                                @endcan
                                @can('user-transkrip-edit')
                                    <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-transkrip" id="edittranskrip">Edit Dokumen</a>
                                @endcan
                                @can('user-transkrip-delete')
                                    <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus-transkrip" title="Hapus Dokumen">Hapus</a>
                                @endcan
                            </div>
                        </div>
                    `;
                            }
                        }
                    @endif
                ]
            });
        }

        // Event listener untuk load data tab pendidikan
        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#pendidikan') {
                initIjazahTable();
                initTranskripTable();
            }
        });

        // Tambah Ijazah
        $('#form-tambah-ijazah').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-ijazah')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#add_ijazah').addClass("d-none");
            $('#add_ijazah_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($ijazahStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_ijazah').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_ijazah').append('<li>' +
                                error_value +
                                '</li>');
                        });
                        $('#add_ijazah').removeClass("d-none");
                        $('#add_ijazah_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#modal-add-ijazah').modal('hide');
                        $('#modal-add-ijazah').find('.form-control').val("");
                        $('#add_ijazah').removeClass("d-none");
                        $('#add_ijazah_disabled').addClass("d-none");
                        ijazahTable.ajax.reload();
                    }
                },
                error: function() {
                    $('#add_ijazah').removeClass("d-none");
                    $('#add_ijazah_disabled').addClass("d-none");
                }
            });
        });

        // Reset form/modal saat modal ditutup
        $('#modal-add-ijazah, #modal-edit-ijazah').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        //EDIT Ijazah
        $(document).on('click', '#edit-ijazah', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($ijazahEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_ijazah').val(response.data.id);
                    $('#id_pegawai_ijazah_edit').val(response.data.id_pegawai);
                    $('#nama_file_ijazah_edit').val(response.data.nama_file_id);
                    $('#nomor_ijazah_edit').val(response.data.nomor);
                    $('#asal_ijazah_edit').val(response.data.asal);
                    $('#thn_lulus_ijazah_edit').val(response.data.thn_lulus);
                }
            });
        });

        //UPDATE Ijazah
        $('#form-edit-ijazah').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-ijazah')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#update_ijazah').addClass("d-none");
            $('#update_ijazah_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($ijazahUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_ijazah_edit').html("").addClass(
                                "alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_ijazah_edit').append('<li>' +
                                error_value + '</li>');
                        });
                        $('#update_ijazah').removeClass("d-none");
                        $('#update_ijazah_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#modal-edit-ijazah').modal('hide');
                        $('#modal-edit-ijazah').find('.form-control').val("");
                        $('#update_ijazah').removeClass("d-none");
                        $('#update_ijazah_disabled').addClass("d-none");
                        ijazahTable.ajax.reload();
                    }
                }
            });
        });

        //HAPUS Ijazah
        $(document).on('click', '#hapus', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($ijazahDestroyRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        ijazahTable.ajax.reload();
                    }
                });
            }
        });

        //VIEW Ijazah
        $(document).on('click', '#view-ijazah', function(e) {
            e.preventDefault();
            var namafile = $(this).data('file');
            var url = baseUrl + '{{ $routeIjazahPDF }}' + encodeURIComponent(namafile);
            //console.log(url);
            PDFObject.embed(url, "#view-ijazah-modal");
        });

        if ('{{ $aksesPage }}' == 'admin') {
            //============================VERIFIKASI============================//

            // Event untuk tombol upload verifikasi ijazah (baik di aksi maupun kolom status)
            $(document).on('click', '#upload-verif-ijazah', function(e) {
                e.preventDefault();
                var idIjazah = $(this).data('id');
                $('#id-ijazah-bukti').val(idIjazah);
                // Reset form modal verifikasi
                $('#form-tambah-bukti')[0].reset();
                $('#error_list_bukti').addClass('d-none').find('ul').html('');
                $('#error_file-bukti').addClass('d-none').text('');
                $('#error_ket-bukti').addClass('d-none').text('');
            });

            // Submit verifikasi ijazah
            $('#form-tambah-bukti').on('submit', function(e) {
                e.preventDefault();
                var form = $('#form-tambah-bukti')[0];
                var formData = new FormData(form);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#add_verif_ijazah').addClass('d-none');
                $('#add_verif_ijazah_disabled').removeClass('d-none');
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "{{ route($verifIjazahStoreRoute) }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_bukti').removeClass('d-none').find('ul')
                                .html(
                                    '');
                            $.each(response.error, function(key, error_value) {
                                $('#error_list_bukti ul').append('<li>' +
                                    error_value +
                                    '</li>');
                            });
                            $('#add_verif_ijazah').removeClass('d-none');
                            $('#add_verif_ijazah_disabled').addClass('d-none');
                        } else {
                            $('#success_message').html('').removeClass(
                                'alert-warning alert-primary').addClass(
                                'alert alert-success').text(response.message);
                            $('#modal-add-bukti').modal('hide');
                            $('#form-tambah-bukti')[0].reset();
                            $('#add_verif_ijazah').removeClass('d-none');
                            $('#add_verif_ijazah_disabled').addClass('d-none');
                            if (ijazahTable) ijazahTable.ajax.reload();
                        }
                    },
                    error: function() {
                        $('#add_verif_ijazah').removeClass('d-none');
                        $('#add_verif_ijazah_disabled').addClass('d-none');
                    }
                });
            });

            //VIEW Bukti Verifikasi Ijazah
            $(document).on('click', '#view-verif-ijazah', function(e) {
                e.preventDefault();
                var filename = $(this).data('file');
                var keterangan = $(this).data('ket');
                $('#ket-verif-ijazah').text(keterangan);
                var url = baseUrl + '{{ $routeVerifIjazahPDF }}' + encodeURIComponent(filename);
                PDFObject.embed(url, "#view-verijazah-modal");
            });

            // Hapus Bukti Verifikasi Ijazah
            $(document).on('click', '#hapus-verif-ijazah', function(e) {
                e.preventDefault();
                var idVerif = $(this).data('id');
                if (confirm('Yakin ingin menghapus bukti verifikasi ini?')) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route($verifIjazahDestroyRoute) }}",
                        data: {
                            id: idVerif,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#success_message').html('').removeClass(
                                'alert-warning alert-primary').addClass(
                                'alert alert-success').text(response.message);
                            ijazahTable.ajax.reload();
                        },
                        error: function() {
                            alert('Gagal menghapus bukti verifikasi.');
                        }
                    });
                }
            });
        }
        //============================TRANSKRIP============================//

        // Tambah Transkrip
        $('#form-tambah-transkrip').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-transkrip')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#add_transkrip').addClass("d-none");
            $('#add_transkrip_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($transkripStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_transkrip').html("").addClass(
                                "alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_transkrip').append('<li>' +
                                error_value +
                                '</li>');
                        });
                        $('#add_transkrip').removeClass("d-none");
                        $('#add_transkrip_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#modal-add-transkrip').modal('hide');
                        $('#modal-add-transkrip').find('.form-control').val("");
                        $('#add_transkrip').removeClass("d-none");
                        $('#add_transkrip_disabled').addClass("d-none");
                        transkripTable.ajax.reload();
                    }
                },
                error: function() {
                    $('#add_transkrip').removeClass("d-none");
                    $('#add_transkrip_disabled').addClass("d-none");
                }
            });
        });

        // Reset form/modal saat modal ditutup
        $('#modal-add-transkrip, #modal-edit-transkrip').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        //EDIT Transkrip
        $(document).on('click', '#edittranskrip', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($transkripEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id-trans-edit').val(response.data.id);
                    $('#id-trans-pegawai-edit').val(response.data.id_pegawai);
                    $('#nama_file_trans_id_edit').val(response.data.nama_file_trans_id);
                    $('#nomor_transkrip_edit').val(response.data.nomor_transkrip);
                }
            });
        });

        //UPDATE Transkrip
        $('#form-edit-transkrip').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-transkrip')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#update_transkrip').addClass("d-none");
            $('#update_transkrip_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($transkripUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_transkrip_edit').html("").addClass(
                            "alert alert-danger").removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_transkrip_edit').append('<li>' +
                                error_value + '</li>');
                        });
                        $('#update_transkrip').removeClass("d-none");
                        $('#update_transkrip_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#modal-edit-transkrip').modal('hide');
                        $('#modal-edit-transkrip').find('.form-control').val("");
                        $('#update_transkrip').removeClass("d-none");
                        $('#update_transkrip_disabled').addClass("d-none");
                        transkripTable.ajax.reload();
                    }
                }
            });
        });

        //HAPUS Transkrip
        $(document).on('click', '#hapus-transkrip', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($transkripDestroyRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        transkripTable.ajax.reload();
                    }
                });
            }
        });

        //VIEW Transkrip
        $(document).on('click', '#view-transkrip', function(e) {
            e.preventDefault();
            var namafile = $(this).data('file');
            var url = baseUrl + '{{ $routeTranskripPDF }}' + encodeURIComponent(namafile);
            PDFObject.embed(url, "#view-transkrip-modal");
        });




    });
</script>
