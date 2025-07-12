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
    'modalParent' => '#modaladdSIP',
    'editModalParent' => '#modaleditSIP',
])

<script>
    $(document).ready(function() {
        // Initialize Select2 for STR dropdown
        $('.select-str').select2({
            minimumResultsForSearch: -1,
            ajax: {
                type: "GET",
                url: '{{ route($strRoute) }}',
                @if (isset($idpegawai))
                    data: {
                        'id': {{ $idpegawai }},
                    },
                @endif
                dataType: 'json',
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
            },
            theme: "bootstrap-5",
            dropdownParent: "{{ $modalParent }}",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
        });

        // Initialize DataTable
        var tbSIP = $('#{{ $tableId }}').DataTable({
            paging: {{ $enablePaging ? 'true' : 'false' }},
            bInfo: {{ $enableInfo ? 'true' : 'false' }},
            searching: {{ $enableSearch ? 'true' : 'false' }},
            serverSide: true,
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

                        // Helper untuk badge pengingat
                        const badgePengingat =
                            `<span class="badge ${data.status_sip === 'changed' ? 'badge-secondary' : (data.status_sip === 'nonactive' || data.status_sip === 'proses' ? 'badge-danger' : 'badge-success')}"><i class="fas fa-bell"></i> ${data.pengingat}</span>`;
                        // Helper untuk badge tanggal
                        const badgeTanggal =
                            `<span class="badge ${data.status_sip === 'changed' ? 'badge-secondary' : (data.status_sip === 'nonactive' ? 'badge-danger' : 'badge-info')}"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed_sip}</span>`;

                        switch (data.status_sip) {
                            case 'nonactive':
                                return `
                                        ${badgePengingat}
                                        ${badgeTanggal}<br>
                                        <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                        <br><br>
                                        ${hapusBtn}
                                    `;
                            case 'proses':
                                return `
                                        ${badgePengingat}
                                        ${badgeTanggal}<br>
                                        <small><i class="fas fa-info-circle"></i> Masa Dokumen Akan Berakhir (Ingatkan)</small>
                                        <br><br>
                                        ${hapusBtn}
                                    `;
                            case 'changed':
                                return `
                                        ${badgePengingat}
                                        ${badgeTanggal}<br>
                                        <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                        <br><br>
                                        ${hapusBtn}
                                    `;
                            case 'lifetime':
                                return `<span class="badge badge-success">SIP Seumur Hidup</span>`;
                            default:
                                return `
                                        ${badgePengingat}
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
                                    <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" id="view-sip" data-toggle="modal" data-target="#modalSIP">Lihat Dokumen</a>
                                    <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSIP" id="edit_sip">Edit Dokumen</a>
                                    <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus_sip" title="Hapus Dokumen">Hapus</a>
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
                                        <a class="dropdown-item set-status-sip" href="#" data-id="${data.id_masa_berlaku}" data-status="proses" data-nosip="${data.no_sip}" id="prosessip" title="Ingatkan">Ingatkan</a>
                                        <a class="dropdown-item set-status-sip" href="#" data-id="${data.id_masa_berlaku}" data-status="nonactive" data-nosip="${data.no_sip}" id="nonactivesip" title="Berakhir">Berakhir</a>
                                        <a class="dropdown-item set-status-sip" href="#" data-id="${data.id_masa_berlaku}" data-status="changed" data-nosip="${data.no_sip}" id="changedsip" title="Diperbaharui">Diperbaharui</a>
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
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_berlaku_sip').html("")
                            $('#error_list_berlaku_sip').addClass("alert alert-danger")
                            $('#error_list_berlaku_sip').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_berlaku_sip').append('<li>' +
                                    error_value + '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)
                            $('#modal-add-masa-berlaku').modal('hide')
                            $('#modal-add-masa-berlaku').find('.form-control').val("");

                            tbSIP.ajax.reload();
                        }
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
            if (fileSIP) {
                PDFObject.embed(`${baseUrl}/File/Pegawai/Dokumen/SIP/${fileSIP}`, "#view-sip-modal");
            } else {
                alert('File SIP tidak ditemukan.');
            }
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
                    if ($('#add_sip').length) {
                        $('#add_sip').addClass("d-none");
                        $('#add_sip_disabled').removeClass("d-none");
                    }
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

                        if ($('#add_sip').length) {
                            $('#add_sip').removeClass("d-none");
                            $('#add_sip_disabled').addClass("d-none");
                        }
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modaladdSIP').modal('hide')
                        $('#modaladdSIP').find('.form-control').val("");

                        if ($('#add_sip').length) {
                            $('#add_sip').removeClass("d-none");
                            $('#add_sip_disabled').addClass("d-none");
                        }
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
                        $('#success_message').text(response.message)
                        $('#modaleditSIP').modal('hide')
                        $('#modaleditSIP').find('.form-control').val("");
                        tbSIP.ajax.reload();
                    }
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
