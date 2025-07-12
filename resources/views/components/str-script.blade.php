@php
    // Default configuration
    $config = array_merge(
        [
            'tableId' => 'tbSTR',
            'getRoute' => 'berkas.getSTR',
            'storeRoute' => 'berkas.str.store',
            'editRoute' => 'berkas.str.edit',
            'updateRoute' => 'berkas.str.update',
            'destroyRoute' => 'berkas.str.destroy',
            'statusRoute' => 'berkas.str.status',
            'verifStoreRoute' => 'verif.str.store',
            'verifDestroyRoute' => 'verif.str.destroy',
            'enableStatusControl' => true,
            'enablePaging' => false,
            'enableSearch' => false,
            'enableInfo' => false,
            'serverSide' => true,
            'idPegawai' => 'idpegawai',
            'showActions' => true,
            'permissions' => [],
        ],
        $config ?? [],
    );
@endphp

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var tabelSTR = $('#{{ $config['tableId'] }}').DataTable({
            paging: {{ $config['enablePaging'] ? 'true' : 'false' }},
            bInfo: {{ $config['enableInfo'] ? 'true' : 'false' }},
            searching: {{ $config['enableSearch'] ? 'true' : 'false' }},
            serverSide: {{ $config['serverSide'] ? 'true' : 'false' }},
            ajax: {
                url: '{{ route($config['getRoute']) }}',
                @if ($config['idPegawai'] === 'idpegawai')
                    data: {
                        'id': idpegawai,
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
                            return `<span class="badge badge-success">STR Seumur Hidup</span>`;
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
                            `;
                        } else {
                            return ` 
                                <a class="badge badge-success" href="#" data-verifstr="${data.file_verif}" data-ket="${data.keterangan}" title="Lihat Bukti" data-toggle="modal" data-target="#modal-verstr" id="view-bukti-str">
                                   <i class="fas fa-check"></i> Sudah Ada Bukti Verifikasi
                                </a><br>
                                <a class="badge badge-danger" href="#" data-id="${data.id_verif_str}" title="Hapus Bukti" id="hapus-bukti-str">
                                   <i class="fas fa-trash"></i> Hapus
                                </a>
                            `;
                        }
                    }
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                @if ($config['showActions'])
                    {
                        data: null,
                        render: function(data, row, type) {
                            let statusControl = '';
                            @if ($config['enableStatusControl'])
                                if (data.status !== 'lifetime') {
                                    statusControl = `
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm dropdown-toggle" title="Set Status Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item set-status" href="#" data-id="${data.id}" data-status="active" data-noreg="${data.no_reg_str}" title="Aktif">Aktif</a>
                                        <a class="dropdown-item set-status" href="#" data-id="${data.id}" data-status="proses" data-noreg="${data.no_reg_str}" title="Ingatkan">Ingatkan</a>
                                        <a class="dropdown-item set-status" href="#" data-id="${data.id}" data-status="nonactive" data-noreg="${data.no_reg_str}" title="Berakhir">Berakhir</a>
                                        <a class="dropdown-item set-status" href="#" data-id="${data.id}" data-status="changed" data-noreg="${data.no_reg_str}" title="Diperbaharui">Diperbaharui</a>
                                    </div>
                                </div>
                            `;
                                }
                            @endif

                            let actionButtons = '';
                            @if (isset($config['permissions']))
                                @if ($config['permissions']['view'] ?? true)
                                    actionButtons +=
                                        `<a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" id="view-str" data-toggle="modal" data-target="#modalSTR">Lihat Dokumen</a>`;
                                @endif
                                @if ($config['permissions']['edit'] ?? true)
                                    actionButtons +=
                                        `<a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSTR" id="edit_str">Edit Dokumen</a>`;
                                @endif
                                @if ($config['permissions']['delete'] ?? true)
                                    actionButtons +=
                                        `<div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus_str" title="Hapus Dokumen">Hapus</a>`;
                                @endif
                            @else
                                actionButtons = `
                                    <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" id="view-str" data-toggle="modal" data-target="#modalSTR">Lihat Dokumen</a>
                                    <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSTR" id="edit_str">Edit Dokumen</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus_str" title="Hapus Dokumen">Hapus</a>
                                `;
                            @endif

                            return `
                            ${statusControl}
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle" title="Aksi Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-solid fa-bars"></i>
                                </button>
                                <div class="dropdown-menu">
                                    ${actionButtons}
                                </div>
                            </div>
                        `;
                        }
                    }
                @endif
            ]
        });

        // Utility functions
        const STRUtils = {
            showMessage: function(message, type = 'success') {
                $('#success_message').html("")
                    .removeClass("alert-primary alert-success alert-warning")
                    .addClass(`alert alert-${type}`)
                    .text(message);
            },

            reloadTable: function() {
                tabelSTR.ajax.reload();
            },

            resetForm: function(formId) {
                $(formId).find('.form-control').val("");
                $(formId).find('.custom-file-input').val("");
                $('.alert-danger').addClass('d-none');
            },

            setupAjax: function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
        };

        // Status control functionality
        @if ($config['enableStatusControl'])
            $(document).on('click', '.set-status', function(e) {
                e.preventDefault();
                STRUtils.setupAjax();

                $.ajax({
                    type: "POST",
                    url: "{{ route($config['statusRoute']) }}",
                    data: {
                        'id': $(this).data('id'),
                        'status': $(this).data('status'),
                        'noreg': $(this).data('noreg'),
                    },
                    dataType: "json",
                    success: function(response) {
                        STRUtils.showMessage(response.message, 'primary');
                        STRUtils.reloadTable();
                    }
                });
            });
        @endif

        // View STR document
        $(document).on('click', '#view-str', function(e) {
            e.preventDefault();
            var namafile = $(this).data('id');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/STR/' + namafile, "#view-str-modal");
        });

        // Add STR form submission
        $('#form-tambah-str').on('submit', function(e) {
            e.preventDefault();
            STRUtils.setupAjax();

            var form = $('#form-tambah-str')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($config['storeRoute']) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $('#add_str').addClass("d-none");
                    $('#add_str_disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_str').html("")
                            .addClass("alert alert-danger")
                            .removeClass("d-none");

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_str').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add_str').removeClass("d-none");
                        $('#add_str_disabled').addClass("d-none");
                    } else {
                        STRUtils.showMessage(response.message, 'success');
                        $('#modaladdSTR').modal('hide');
                        STRUtils.resetForm('#modaladdSTR');
                        $('#add_str').removeClass("d-none");
                        $('#add_str_disabled').addClass("d-none");
                        STRUtils.reloadTable();
                    }
                }
            });
        });

        // Modal reset on hide
        $('#modaladdSTR').on('hidden.bs.modal', function() {
            STRUtils.resetForm('#modaladdSTR');
            $('#enable_exp_str').prop('checked', false);
            document.getElementById('masa-berlaku').innerHTML = ``;
        });

        // Edit STR
        $(document).on('click', '#edit_str', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($config['editRoute']) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id-str-edit').val(response.data.id);
                    $('#id-str-pegawai-edit').val(response.data.id_pegawai);
                    $('#nama_file_str_id_edit').val(response.data.nama_file_str_id);
                    $('#no_reg_str_edit').val(response.data.no_reg_str);
                    $('#kompetensi_edit').val(response.data.kompetensi);

                    if (response.data.tgl_ed == null || response.data.pengingat == null) {
                        $('#enable_exp_str_edit').prop('checked', false);
                        document.getElementById('masa-berlaku-edit').innerHTML = ``;
                    } else {
                        $('#enable_exp_str_edit').prop('checked', true);
                        document.getElementById('masa-berlaku-edit').innerHTML = `
                            <div class="form-group">
                                <label for="tgl_ed_edit" class="col-form-label">Berkalu Sampai <label class="text-danger">*</label></label>
                                <input type="date" class="form-control tgl_ed_edit" id="tgl_ed_edit" name="tgl_ed">
                            </div>
                            <div class="form-group">
                                <label for="pengingat_edit" class="col-form-label">Pengingat <label class="text-danger">*</label></label>
                                <input type="date" class="form-control pengingat_edit" id="pengingat_edit" name="pengingat">
                            </div>
                        `;
                        $('#tgl_ed_edit').val(response.data.tgl_ed);
                        $('#pengingat_edit').val(response.data.pengingat);
                    }
                }
            });
        });

        // Update STR form submission
        $('#form-edit-str').on('submit', function(e) {
            e.preventDefault();
            STRUtils.setupAjax();

            var form = $('#form-edit-str')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($config['updateRoute']) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_str_edit').html("")
                            .addClass("alert alert-danger")
                            .removeClass("d-none");

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_str_edit').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        STRUtils.showMessage(response.message, 'primary');
                        $('#modaleditSTR').modal('hide');
                        STRUtils.resetForm('#modaleditSTR');
                        STRUtils.reloadTable();
                    }
                }
            });
        });

        // Modal edit reset on hide
        $('#modaleditSTR').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
        });

        // Delete STR
        $(document).on('click', '#hapus_str', function() {
            STRUtils.setupAjax();
            if (confirm('Yakin Ingin Menghapus Berkas STR ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($config['destroyRoute']) }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        STRUtils.showMessage(response.message, 'warning');
                        STRUtils.reloadTable();
                    }
                });
            }
        });

        // Verification functionality
        // View verification proof
        $(document).on('click', '#view-bukti-str', function(e) {
            e.preventDefault();
            var bukti = $(this).data('verifstr');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/STR/Verifikasi/' + bukti,
                "#view-verstr-modal");

            var keterangan = $(this).data('ket');
            $('#ket-verif-str').text(keterangan);
        });

        // Add verification proof modal
        $('table').on('click', '#add-bukti-str', function(e) {
            e.preventDefault();
            var str = $(this).data('id');
            $('#id-str-bukti').val(str);
        });

        // Modal add verification reset on hide
        $('#modal-add-bukti-str').on('hidden.bs.modal', function() {
            STRUtils.resetForm('#modal-add-bukti-str');
        });

        // Add verification form submission
        $('#form-tambah-bukti-str').on('submit', function(e) {
            e.preventDefault();
            STRUtils.setupAjax();

            var form = $('#form-tambah-bukti-str')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($config['verifStoreRoute']) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_bukti_str').html("")
                            .addClass("alert alert-danger")
                            .removeClass("d-none");

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_bukti_str').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        STRUtils.showMessage(response.message, 'success');
                        $('#modal-add-bukti-str').modal('hide');
                        STRUtils.resetForm('#modal-add-bukti-str');
                        STRUtils.reloadTable();
                    }
                }
            });
        });

        // Delete verification proof
        $(document).on('click', '#hapus-bukti-str', function() {
            STRUtils.setupAjax();
            if (confirm('Yakin Ingin Menghapus Bukti Verifikasi STR ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($config['verifDestroyRoute']) }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        STRUtils.showMessage(response.message, 'warning');
                        STRUtils.reloadTable();
                    }
                });
            }
        });
    });
</script>
