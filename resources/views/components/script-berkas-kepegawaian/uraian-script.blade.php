@props([
    'tableId' => 'tb-uraian',
    'uraianRoute' => 'berkas.uraian.get',
    'uraianStoreRoute' => 'berkas.uraian.store',
    'uraianEditRoute' => 'berkas.uraian.edit',
    'uraianUpdateRoute' => 'berkas.uraian.update',
    'uraianDestroyRoute' => 'berkas.uraian.destroy',
    'modalAdd' => 'modal-add-uraian',
    'modalEdit' => 'modal-edit-uraian',
    'viewRoutePDF' => '/File/Pegawai/Dokumen/Uraian-Tugas/',
])

<script>
    $(document).ready(function() {
        let uraianTable = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        function initUraianTable() {
            if (uraianTable) return;
            $('.select-departemen').select2({
                theme: "bootstrap-5",
                dropdownParent: `#{{ $modalAdd }}`,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
                placeholder: $(this).data('placeholder'),
            });
            $('.select-departemen-edit').select2({
                theme: "bootstrap-5",
                dropdownParent: `#{{ $modalEdit }}`,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
                placeholder: $(this).data('placeholder'),
            });
            uraianTable = $('#{{ $tableId }}').DataTable({
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
                    url: '{{ route($uraianRoute) }}',
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
                        data: 'nama_departemen',
                        name: 'nama_departemen'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
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
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" id="view-uraian" data-toggle="modal" data-target="#modal-view-uraian">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-uraian" id="edit-uraian">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus-uraian" title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                            `;
                        }
                    },
                ]
            });
        }

        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#uraian') {
                initUraianTable();
            }
        });

        // VIEW Uraian
        $(document).on('click', '#view-uraian', function(e) {
            e.preventDefault();
            var filename = $(this).data('file');
            var url = baseUrl + '{{ $viewRoutePDF }}' + encodeURIComponent(filename);
            PDFObject.embed(url, "#view-uraian-modal");
        });

        // Tambah Uraian
        $('#form-tambah-uraian').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-uraian')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#add-uraian').addClass("d-none");
            $('#add-uraian-disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($uraianStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_uraian').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_uraian').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add-uraian').removeClass("d-none");
                        $('#add-uraian-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#modal-add-uraian').modal('hide');
                        $('#modal-add-uraian').find('.form-control').val("");
                        $('#add-uraian').removeClass("d-none");
                        $('#add-uraian-disabled').addClass("d-none");
                        uraianTable.ajax.reload();
                    }
                },
                error: function() {
                    $('#add-uraian').removeClass("d-none");
                    $('#add-uraian-disabled').addClass("d-none");
                }
            });
        });

        // Reset form/modal saat modal ditutup
        $('#modal-add-uraian, #modal-edit-uraian').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        // EDIT Uraian
        $(document).on('click', '#edit-uraian', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($uraianEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_uraian').val(response.data.id);
                    $('#id_pegawai_uraian_edit').val(response.data.id_pegawai);
                    $('.select-departemen-edit').val(response.data.departemen_id).trigger(
                        'change');
                    $('#jabatan-edit').val(response.data.jabatan);
                }
            });
        });

        // UPDATE Uraian
        $('#form-edit-uraian').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-uraian')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#update-uraian').addClass("d-none");
            $('#update-uraian-disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($uraianUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_uraian_edit').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_uraian_edit').append('<li>' +
                                error_value + '</li>');
                        });
                        $('#update-uraian').removeClass("d-none");
                        $('#update-uraian-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#modal-edit-uraian').modal('hide');
                        $('#modal-edit-uraian').find('.form-control').val("");
                        $('#update-uraian').removeClass("d-none");
                        $('#update-uraian-disabled').addClass("d-none");
                        uraianTable.ajax.reload();
                    }
                }
            });
        });

        // HAPUS Uraian
        $(document).on('click', '#hapus-uraian', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Uraian Tugas  ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($uraianDestroyRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        uraianTable.ajax.reload();
                    }
                });
            }
        });
    });
</script>
