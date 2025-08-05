@props([
    'tableId' => 'tbSIP',
    'strRoute' => 'pengguna.str.get',
    'sipRoute' => 'pengguna.getSIP',
    'sipStoreRoute' => 'pengguna.sip.store',
    'sipEditRoute' => 'pengguna.sip.edit',
    'sipUpdateRoute' => 'pengguna.sip.update',
    'sipDestroyRoute' => 'pengguna.sip.destroy',
    'strSelectedRoute' => 'pengguna.str.selected.get',
    'enablePaging' => true,
    'enableSearch' => true,
    'enableInfo' => true,
    'showActions' => true,
    'showStatusActions' => false,
    'sipExpRoute' => null,
    'sipDesexpRoute' => null,
    'sipStatusRoute' => null,
    'permissionsSIP' => [],
    'modalParent' => '#modaladdSIP',
    'editModalParent' => '#modaleditSIP',
    'routePDF' => '/karyawan/sip/view/',
    'aksesPage' => 'admin',
])

<script>
    $(document).ready(function() {
        // Variabel untuk menyimpan instance DataTable
        let tbSIP = null;
        const idpegawai = $('.id-pegawai').val();


        //============================AKSES PAGE PENGGUNA============================//
        if ('{{ $aksesPage }}' == 'user') {
            @if ($permissionsSIP['view'] ?? true)
                initSIPTable();
            @endif
        }

        // Fungsi untuk inisialisasi DataTable SIP
        function initSIPTable() {
            if (tbSIP) return; // Sudah diinisialisasi

            // Initialize Select2 for STR dropdown
            $('.select-str').select2({
                minimumResultsForSearch: -1,
                ajax: {
                    type: "GET",
                    url: '{{ route($strRoute) }}',
                    data: {
                        'id': {{ $idpegawai }},
                    },
                    dataType: 'json',
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "{{ $modalParent }}",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
            });

            // Initialize DataTable
            tbSIP = $('#{{ $tableId }}').DataTable({
                paging: {{ $enablePaging ? 'true' : 'false' }},
                bInfo: {{ $enableInfo ? 'true' : 'false' }},
                searching: {{ $enableSearch ? 'true' : 'false' }},
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($sipRoute) }}',
                    @if (isset($idpegawai))
                        data: {
                            'id': {{ $idpegawai }},
                        },
                    @endif
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
                        data: function(data, row, type) {
                            if (data.id_masa_berlaku === null) {
                                @if ($sipExpRoute)
                                    return `
                                    <a class="badge badge-danger" href="#" data-id="${data.id}" title="Tambah Masa Berlaku SIP" data-toggle="modal" data-target="#modal-add-masa-berlaku" id="add-masa-berlaku">
                                        <i class="fas fa-times"></i> Belum ada masa berlaku
                                    </a>
                                `;
                                @else
                                    return `<span class="badge badge-danger">Belum ada masa berlaku</span>`;
                                @endif
                            }

                            // Helper untuk tombol hapus
                            const hapusBtn =
                                @if ($sipDesexpRoute)
                                    `<a class="badge badge-danger" href="#" data-id="${data.id_masa_berlaku}" title="Hapus" id="hapus-masa-berlaku">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>`;
                                @else
                                    '';
                                @endif

                            // Helper untuk badge tanggal
                            const badgeTanggal =
                                `<span class="badge ${data.status_sip === 'changed' ? 'badge-secondary' : (data.status_sip === 'nonactive' ? 'badge-danger' : 'badge-info')}"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed_sip}</span>`;

                            switch (data.status_sip) {
                                case 'nonactive':
                                    return `
                                            ${badgeTanggal}<br>
                                            <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                            <br><br>
                                            ${hapusBtn}
                                        `;
                                case 'changed':
                                    return `
                                            ${badgeTanggal}<br>
                                            <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                            <br><br>
                                            ${hapusBtn}
                                        `;
                                case 'akan_berakhir':
                                    return `
                                            <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> ${data.tgl_ed_sip}</span><br>
                                            <small><i class="fas fa-info-circle"></i> Masa berlaku dokumen akan segera berakhir</small>
                                            <br><br>
                                            ${hapusBtn}
                                        `;
                                case 'lifetime':
                                    return `<span class="badge badge-success">SIP Seumur Hidup</span>`;
                                default:
                                    return `
                                            ${badgeTanggal}
                                            <br><br>
                                            ${hapusBtn}
                                        `;
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
                            render: function(data, row, type) {
                                let actionButtons = `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if ($permissionsSIP['view'] ?? true)
                                            <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" id="view-sip" data-toggle="modal" data-target="#modalSIP">Lihat Dokumen</a>
                                        @endif
                                        @if ($permissionsSIP['edit'] ?? true)
                                            <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSIP" id="edit_sip">Edit Dokumen</a>
                                        @endif
                                        @if ($permissionsSIP['delete'] ?? true)
                                            <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus_sip" title="Hapus Dokumen">Hapus</a>
                                        @endif
                                    </div>
                                </div>
                                
                            `;

                                @if ($showStatusActions)
                                    if (data.id_masa_berlaku != null) {
                                        actionButtons = `
                                    <div class="btn-group">
                                        <button class="btn btn-info btn-sm dropdown-toggle" title="Set Status Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item set-status-sip" href="#" data-id="${data.id_masa_berlaku}" data-status="active" data-nosip="${data.no_sip}" id="activesip" title="Aktif">Aktif</a>
                                            <a class="dropdown-item set-status-sip" href="#" data-id="${data.id_masa_berlaku}" data-status="akan_berakhir" data-nosip="${data.no_sip}" id="akanberakhirsip" title="Akan Berakhir">Akan Berakhir</a>
                                            <a class="dropdown-item set-status-sip" href="#" data-id="${data.id_masa_berlaku}" data-status="nonactive" data-nosip="${data.no_sip}" id="nonactivesip" title="Berakhir">Berakhir</a>
                                            
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

        // Event listener untuk load data tab perizinan
        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#izin') {
                initSIPTable();
            }
        });

        // Add masa berlaku functionality
        @if ($sipExpRoute)
            $('table').on('click', '#add-masa-berlaku', function(e) {
                e.preventDefault();
                var sip = $(this).data('id');
                $('#sip_id_masa_berlaku').val(sip);
            });

            $('#form-masa-berlaku-sip').on('submit', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-masa-berlaku-sip')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route($sipExpRoute) }}",
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
                            $('#error_list_berlaku_sip').html("")
                            $('#error_list_berlaku_sip').addClass("alert alert-danger")
                            $('#error_list_berlaku_sip').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_berlaku_sip').append('<li>' +
                                    error_value + '</li>');
                            });

                            $('.btn-login').removeClass("d-none");
                            $('.btn-login-disabled').addClass("d-none");
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modal-add-masa-berlaku').modal('hide')
                            $('#modal-add-masa-berlaku').find('.form-control').val("");

                            $('.btn-login').removeClass("d-none");
                            $('.btn-login-disabled').addClass("d-none");

                            tbSIP.ajax.reload();
                        }
                    },
                    error: function() {
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                    }
                });
            });


            $('#modal-add-masa-berlaku').on('hidden.bs.modal', function() {
                $('#modal-add-masa-berlaku').find('.form-control').val("");
                $('#modal-add-masa-berlaku').find('.custom-file-input').val("");
                $('.alert-danger').addClass('d-none');
            });
        @endif

        // View SIP document
        const baseUrl = '{{ url('/') }}';

        $(document).on('click', '#view-sip', function(e) {
            e.preventDefault();
            const fileSIP = $(this).data('id');
            var url = baseUrl + '{{ $routePDF }}' + encodeURIComponent(fileSIP);

            PDFObject.embed(url, "#view-sip-modal");
        });

        // Store SIP
        $('#form-tambah-sip').on('submit', function(e) {
            e.preventDefault();

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
                url: "{{ route($sipStoreRoute) }}",
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
                        $('#error_list_sip').html("")
                        $('#error_list_sip').addClass("alert alert-danger")
                        $('#error_list_sip').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_sip').append('<li>' + error_value +
                                '</li>');
                        });
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modaladdSIP').modal('hide')
                        $('#modaladdSIP').find('.form-control').val("");
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                        tbSIP.ajax.reload();
                    }
                },
                error: function() {
                    $('.btn-login').removeClass("d-none");
                    $('.btn-login-disabled').addClass("d-none");
                }
            });
        });

        $('#modaladdSIP').on('hidden.bs.modal', function() {
            $('#modaladdSIP').find('.form-control').val("");
            $('#modaladdSIP').find('.custom-file-input').val("");
            $('.select-str').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
        });

        // Edit SIP
        $(document).on('click', '#edit_sip', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($sipEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_pegawai_sip_edit').val(response.data.id_pegawai);
                    $('#id-sip-edit').val(response.data.id);
                    $('#nama_file_sip_id_edit').val(response.data.nama_file_sip_id);
                    $('#no_sip_edit').val(response.data.no_sip);
                    $('#no_reg_sip_edit').val(response.data.no_reg);

                    // Initialize Select2 with current STR data
                    $('.select-str-edit').select2({
                        tags: true,
                        minimumResultsForSearch: -1,
                        ajax: {
                            type: "GET",
                            url: "{{ route($strSelectedRoute) }}",
                            data: function(params) {
                                return {
                                    id: response.data.id
                                };
                            },
                            dataType: 'json',
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                        },
                        theme: "bootstrap-5",
                        dropdownParent: "{{ $editModalParent }}",
                        width: $(this).data('width') ? $(this).data('width') : $(
                            this).hasClass('w-100') ? '100%' : 'style',
                    });

                    // Set the selected STR after a short delay to ensure Select2 is initialized
                    setTimeout(function() {
                        if (response.data.no_reg && response.str_data) {
                            var option = new Option(response.str_data.no_reg_str,
                                response.data.no_reg, true, true);
                            $('.select-str-edit').append(option).trigger('change');
                        }
                    }, 100);
                }
            });
        });

        // Update SIP
        $('#form-edit-sip').on('submit', function(e) {
            e.preventDefault();

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
                url: "{{ route($sipUpdateRoute) }}",
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
                        $('#error_list_sip_edit').html("")
                        $('#error_list_sip_edit').addClass("alert alert-danger")
                        $('#error_list_sip_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_sip_edit').append('<li>' + error_value +
                                '</li>');
                        });
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        $('#success_message').text(response.message)
                        $('#modaleditSIP').modal('hide')
                        $('#modaleditSIP').find('.form-control').val("");
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                        tbSIP.ajax.reload();
                    }
                },
                error: function() {
                    $('.btn-login').removeClass("d-none");
                    $('.btn-login-disabled').addClass("d-none");
                }
            });
        });

        $('#modaleditSIP').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
            $('.select-str-edit').val(null).trigger('change');
        });

        // Delete SIP
        $(document).on('click', '#hapus_sip', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas SIP ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($sipDestroyRoute) }}",
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
                        tbSIP.ajax.reload();
                    }
                });
            }
        });

        @if ($sipDesexpRoute)
            // Delete masa berlaku SIP
            $(document).on('click', '#hapus-masa-berlaku', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Masa Berlaku SIP ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route($sipDesexpRoute) }}",
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
                            tbSIP.ajax.reload();
                        }
                    });
                }
            });
        @endif

        @if ($sipStatusRoute)
            // Update status SIP
            $(document).on('click', '.set-status-sip', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route($sipStatusRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                        'status': $(this).data('status'),
                        'nosip': $(this).data('nosip'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').addClass("alert alert-primary")
                        $('#success_message').text(response.message)

                        tbSIP.ajax.reload();
                    }
                });
            });
        @endif
    });
</script>
