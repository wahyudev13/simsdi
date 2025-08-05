@props([
    'tableId' => 'tb-lainlain',
    'lainLainRoute' => 'berkas.lainlain.get',
    'lainLainStoreRoute' => 'berkas.lainlain.store',
    'lainLainEditRoute' => 'berkas.lainlain.edit',
    'lainLainUpdateRoute' => 'berkas.lainlain.update',
    'lainLainDestroyRoute' => 'berkas.lainlain.destroy',
    'modalAdd' => 'modal-add-lain',
    'modalEdit' => 'modal-edit-lain',
    'viewRoutePDF' => '/karyawan/berkas/lain-lain/view/',
])

<script>
    $(document).ready(function() {
        let lainLainTable = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        function initLainLainTable() {
            if (lainLainTable) return;
            lainLainTable = $('#{{ $tableId }}').DataTable({
                ordering: false,
                paging: false,
                bInfo: false,
                searching: false,
                processing: true,
                serverSide: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($lainLainRoute) }}',
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
                        data: null,
                        render: function(data, row, type) {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" id="view-lainlain" data-toggle="modal" data-target="#modal-view-lainlain">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#{{ $modalEdit }}" id="edit-lainlain">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#" data-id="${data.id}" data-namaberkas="${data.nama_berkas}" id="hapus-lainlain" title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                            `;
                        }
                    },
                ]
            });
        }

        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#lain') {
                initLainLainTable();
            }
        });

        // VIEW Berkas Lain
        $(document).on('click', '#view-lainlain', function(e) {
            e.preventDefault();
            var filename = $(this).data('file');
            var url = baseUrl + '{{ $viewRoutePDF }}' + encodeURIComponent(filename);
            PDFObject.embed(url, "#view-lainlain-modal");
        });

        // Tambah Lain-Lain
        $('#form-tambah-lainlain').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-lainlain')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#add-lainlain').addClass("d-none");
            $('#add-lainlain-disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($lainLainStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_lainlain').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_lainlain').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add-lainlain').removeClass("d-none");
                        $('#add-lainlain-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#{{ $modalAdd }}').modal('hide');
                        $('#{{ $modalAdd }}').find('.form-control').val("");
                        $('#add-lainlain').removeClass("d-none");
                        $('#add-lainlain-disabled').addClass("d-none");
                        lainLainTable.ajax.reload();
                    }
                },
                error: function() {
                    $('#add-lainlain').removeClass("d-none");
                    $('#add-lainlain-disabled').addClass("d-none");
                }
            });
        });

        // Reset form/modal saat modal ditutup
        $('#{{ $modalAdd }}, #{{ $modalEdit }}').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        // EDIT Lain-Lain
        $(document).on('click', '#edit-lainlain', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($lainLainEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_lain_lain').val(response.data.id);
                    $('#nama_file_id_lainlain_edit').val(response.data.nama_file_id);
                }
            });
        });

        // UPDATE Lain-Lain
        $('#form-edit-lainlain').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-lainlain')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#update-lainlain').addClass("d-none");
            $('#update-lainlain-disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($lainLainUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_lainlain_edit').html("").addClass(
                            "alert alert-danger").removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_lainlain_edit').append('<li>' +
                                error_value + '</li>');
                        });
                        $('#update-lainlain').removeClass("d-none");
                        $('#update-lainlain-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#{{ $modalEdit }}').modal('hide');
                        $('#{{ $modalEdit }}').find('.form-control').val("");
                        $('#update-lainlain').removeClass("d-none");
                        $('#update-lainlain-disabled').addClass("d-none");
                        lainLainTable.ajax.reload();
                    }
                }
            });
        });

        // HAPUS Lain-Lain
        $(document).on('click', '#hapus-lainlain', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($lainLainDestroyRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                        'nama': $(this).data('namaberkas')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        lainLainTable.ajax.reload();
                    }
                });
            }
        });
    });
</script>
