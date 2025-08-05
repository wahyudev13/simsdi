@props([
    'tableId' => 'tbIdentitas',
    'getRoute' => 'berkas.identitas.getFile',
    'storeRoute' => 'berkas.identitas.store',
    'editRoute' => 'berkas.identitas.edit',
    'updateRoute' => 'berkas.identitas.update',
    'destroyRoute' => 'berkas.identitas.destroy',
    'viewRoutePDF' => '/karyawan/berkas/identitas/view/',
    'enablePaging' => false,
    'enableSearch' => false,
    'enableInfo' => false,
    'showActions' => true,
    'modalParent' => 'modaladd_Identitas',
    'editModalParent' => 'modaledit_Identitas',
])

<script>
    $(document).ready(function() {
        let tbIdentitas = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        function initIdentitasTable() {
            if (tbIdentitas) return;
            tbIdentitas = $('#{{ $tableId }}').DataTable({
                paging: {{ $enablePaging ? 'true' : 'false' }},
                bInfo: {{ $enableInfo ? 'true' : 'false' }},
                searching: {{ $enableSearch ? 'true' : 'false' }},
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($getRoute) }}',
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
                    @if ($showActions)
                        {
                            data: null,
                            render: function(data) {
                                return `
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-solid fa-bars"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" id="view-identitas" data-toggle="modal" data-target="#modalIdentitas">Lihat Dokumen</a>
                                <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#{{ $editModalParent }}" id="edit_identitas">Edit Dokumen</a>
                                <a class="dropdown-item text-danger" href="#" data-id="${data.id}" id="hapus_identitas" title="Hapus Dokumen">Hapus</a>
                            </div>
                        </div>
                        `;
                            }
                        }
                    @endif
                ]
            });
        }

        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#identitas') {
                initIdentitasTable();
            }
        });

        // Reset form/modal saat modal ditutup
        $('#{{ $modalParent }}, #{{ $editModalParent }}').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        // VIEW dokumen
        $(document).on('click', '#view-identitas', function(e) {
            e.preventDefault();
            const filename = $(this).data('id');
            var url = baseUrl + '{{ $viewRoutePDF }}' + encodeURIComponent(filename);
            console.log(url);
            PDFObject.embed(url, "#view-identitas-modal");
        });

        // Tambah Identitas
        $('#form-tambah-identitas').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-identitas')[0];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(form);
            $('#add_identitas').addClass("d-none");
            $('#add_identitas_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($storeRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_identitas').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_identitas').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add_identitas').removeClass("d-none");
                        $('#add_identitas_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#{{ $modalParent }}').modal('hide');
                        $('#{{ $modalParent }}').find('.form-control').val("");
                        $('#add_identitas').removeClass("d-none");
                        $('#add_identitas_disabled').addClass("d-none");
                        tbIdentitas.ajax.reload();
                    }
                },
                error: function() {
                    $('#add_identitas').removeClass("d-none");
                    $('#add_identitas_disabled').addClass("d-none");
                }
            });
        });

        // Edit Identitas
        $(document).on('click', '#edit_identitas', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($editRoute) }}",
                data: {
                    'id': $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $('#id-identitas-edit').val(response.data.id);
                    $('#nama_file_lain_id_edit').val(response.data.nama_file_lain_id);
                }
            });
        });

        // Update Identitas
        $('#form-edit-identitas').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-identitas')[0];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(form);
            $('#update_identitas').addClass('d-none');
            $('#update_identitas_disabled').removeClass('d-none');
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($updateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_identitas_edit').html("").addClass(
                            "alert alert-danger").removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_identitas_edit').append('<li>' +
                                error_value + '</li>');
                        });
                        $('#update_identitas').removeClass('d-none');
                        $('#update_identitas_disabled').addClass('d-none');
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#{{ $editModalParent }}').modal('hide');
                        $('#{{ $editModalParent }}').find('.form-control').val("");
                        $('#update_identitas').removeClass('d-none');
                        $('#update_identitas_disabled').addClass('d-none');
                        tbIdentitas.ajax.reload();
                    }
                }
            });
        });

        // Hapus Identitas
        $(document).on('click', '#hapus_identitas', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($destroyRoute) }}",
                    data: {
                        'id': $(this).data('id')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        tbIdentitas.ajax.reload();
                    }
                });
            }
        });


    });
</script>
