@props([
    'tableId' => 'tbRiwayat',
    'riwayatRoute' => 'berkas.riwayat.getRiwayat',
    'riwayatStoreRoute' => 'berkas.riwayat.store',
    'riwayatEditRoute' => 'berkas.riwayat.edit',
    'riwayatUpdateRoute' => 'berkas.riwayat.update',
    'riwayatDestroyRoute' => 'berkas.riwayat.destroy',
    'riwayatStatusRoute' => 'berkas.riwayat.update.status',
    'enablePaging' => false,
    'enableSearch' => false,
    'enableInfo' => false,
    'showActions' => true,
    'showStatusActions' => true,
    'modalParent' => 'modaladdRiwayat',
    'editModalParent' => 'modaleditRiwayat',
    'routePDF' => '/karyawan/berkas/riwayat/view/',
    'aksesPage' => 'admin',
])

<script>
    $(document).ready(function() {
        // Variabel untuk menyimpan instance DataTable
        let tbRiwayat = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        //============================AKSES PAGE PENGGUNA============================//
        if ('{{ $aksesPage }}' == 'user') {
            @if ($permissions['view'] ?? true)
                initRiwayatTable();
            @endif
        }

        // Inisialisasi DataTable Riwayat
        function initRiwayatTable() {
            if (tbRiwayat) return; // Sudah diinisialisasi

            tbRiwayat = $('#{{ $tableId }}').DataTable({
                paging: {{ $enablePaging ? 'true' : 'false' }},
                bInfo: {{ $enableInfo ? 'true' : 'false' }},
                searching: {{ $enableSearch ? 'true' : 'false' }},
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($riwayatRoute) }}',
                    data: {
                        'id': idpegawai
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
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: function(data, row, type) {
                            if (data.tgl_ed === null) {
                                return `<center><span class="badge badge-danger" title="Tidak Ada Masa Berlaku"><i class="fas fa-calendar-alt"></i> Tidak Ada</span></center>`;
                            } else if (data.status === 'nonactive') {
                                return `
                                    <span class="badge badge-danger"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                    <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                `;
                            } else if (data.status === 'akan_berakhir') {
                                return `
                                    <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> ${data.tgl_ed}</span><br>
                                    <small><i class="fas fa-info-circle"></i> Masa berlaku dokumen akan segera berakhir</small>
                                `;
                            } else if (data.status === 'active') {
                                return `
                                    <center><span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span></center>
                                `;
                            } else {
                                return `<center><span class="badge badge-danger" title="Tidak Ada Masa Berlaku"><i class="fas fa-calendar-alt"></i> Tidak Ada</span></center>`;
                            }
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if ($showActions)
                        {
                            data: null,
                            render: function(data) {
                                let actionButtons = `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if ($permissions['view'] ?? true)
                                            <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" id="view-rw" data-toggle="modal" data-target="#modalRiwayat">Lihat Dokumen</a>
                                        @endif
                                        @if ($permissions['edit'] ?? true)
                                            <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modaleditRiwayat" id="edit_riwayat">Edit Dokumen</a>
                                        @endif
                                        @if ($permissions['delete'] ?? true)
                                            <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus_riwayat" title="Hapus Dokumen">Hapus</a>
                                        @endif
                                    </div>
                                </div>
                            `;

                                @if ($showStatusActions)
                                    if (data.tgl_ed !== null) {
                                        actionButtons = `
                                    <div class="btn-group">
                                        <button class="btn btn-info btn-sm dropdown-toggle" title="Set Status Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item set-status-riwayat" href="#" data-id="${data.id}" data-status="active" data-naber="${data.nama_berkas}" id="active" title="Aktif">Aktif</a>
                                            <a class="dropdown-item set-status-riwayat" href="#" data-id="${data.id}" data-status="akan_berakhir" data-naber="${data.nama_berkas}" id="akan_berakhir" title="Akan Berakhir">Akan Berakhir</a>
                                            <a class="dropdown-item set-status-riwayat" href="#" data-id="${data.id}" data-status="nonactive" data-naber="${data.nama_berkas}" id="nonactive" title="Berakhir">Berakhir</a>
                                        </div>
                                    </div>
                                    ${actionButtons}
                                `;
                                    }
                                @endif

                                return actionButtons;
                            }
                        },
                    @endif
                ]
            });
        }

        // Event listener untuk load data tab riwayat
        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#riwayat') {
                initRiwayatTable();
            }
        });

        // Reset form/modal saat modal ditutup
        $('#{{ $modalParent }}, #{{ $editModalParent }}').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        // VIEW dokumen
        $(document).on('click', '#view-rw', function(e) {
            e.preventDefault();
            const filename = $(this).data('id');
            var url = baseUrl + '{{ $routePDF }}' + encodeURIComponent(filename);
            PDFObject.embed(url, "#view-riwayat-modal");
        });

        // Tambah Riwayat
        $('#form-tambah-rw').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-rw')[0];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(form);
            $('#add_riwayat').addClass("d-none");
            $('#add_riwayat_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($riwayatStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_rw').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_rw').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add_riwayat').removeClass("d-none");
                        $('#add_riwayat_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#{{ $modalParent }}').modal('hide');
                        $('#{{ $modalParent }}').find('.form-control').val("");
                        $('#add_riwayat').removeClass("d-none");
                        $('#add_riwayat_disabled').addClass("d-none");
                        tbRiwayat.ajax.reload();
                    }
                },
                error: function() {
                    $('#add_riwayat').removeClass("d-none");
                    $('#add_riwayat_disabled').addClass("d-none");
                }
            });
        });

        // Edit Riwayat
        $(document).on('click', '#edit_riwayat', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($riwayatEditRoute) }}",
                data: {
                    'id': $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $('#id-riwayat-edit').val(response.data.id);
                    $('#id_pegawai_rw_edit').val(response.data.id_pegawai);
                    $('#nama_file_riwayat_id_edit').val(response.data.nama_file_riwayat_id);
                    $('#nomor_rw_edit').val(response.data.nomor);
                    $('#tgl_ed_rw_edit').val(response.data.tgl_ed);
                    $('#pengingat_rw_edit').val(response.data.pengingat);
                }
            });
        });

        // Update Riwayat
        $('#form-edit-riwayat').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-riwayat')[0];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(form);
            // Sembunyikan tombol Update, tampilkan tombol loading
            $('#update_riwayat').addClass('d-none');
            $('#update_riwayat_disabled_edit').removeClass('d-none');
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($riwayatUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_rw_edit').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_rw_edit').append('<li>' + error_value +
                                '</li>');
                        });
                        // Kembalikan tombol Update, sembunyikan tombol loading
                        $('#update_riwayat').removeClass('d-none');
                        $('#update_riwayat_disabled_edit').addClass('d-none');
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#{{ $editModalParent }}').modal('hide');
                        $('#{{ $editModalParent }}').find('.form-control').val("");
                        // Kembalikan tombol Update, sembunyikan tombol loading
                        $('#update_riwayat').removeClass('d-none');
                        $('#update_riwayat_disabled_edit').addClass('d-none');
                        tbRiwayat.ajax.reload();
                    }
                },
                error: function() {
                    // Kembalikan tombol Update, sembunyikan tombol loading
                    $('#update_riwayat').removeClass('d-none');
                    $('#update_riwayat_disabled_edit').addClass('d-none');
                }
            });
        });

        // Hapus Riwayat
        $(document).on('click', '#hapus_riwayat', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas Riwayat Kerja ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($riwayatDestroyRoute) }}",
                    data: {
                        'id': $(this).data('id')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        tbRiwayat.ajax.reload();
                    }
                });
            }
        });

        @if ($riwayatStatusRoute)
            // Update Status
            $(document).on('click', '.set-status-riwayat', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route($riwayatStatusRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                        'status': $(this).data('status'),
                        'naber': $(this).data('naber'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                                "alert-warning alert-success").addClass(
                                "alert alert-primary")
                            .text(response.message);
                        tbRiwayat.ajax.reload();
                    }
                });
            });
        @endif
    });
</script>
