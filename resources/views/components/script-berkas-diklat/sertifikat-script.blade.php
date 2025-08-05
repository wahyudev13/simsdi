@props([
    'tableId' => 'tb-sertifikat',
    'getRoute' => 'karywan.diklat.sertif.get',
    'storeRoute' => 'karywan.diklat.sertif.store',
    'editRoute' => 'karywan.diklat.sertif.edit',
    'updateRoute' => 'karywan.diklat.sertif.update',
    'destroyRoute' => 'karywan.diklat.sertif.destroy',
    'viewRoutePDF' => '/karyawan/berkas/diklat/sertif/viewFile/',
    'enablePaging' => true,
    'enableSearch' => true,
    'enableInfo' => true,
    'showActions' => true,
    'modalParent' => 'modaladd_sertif',
    'editModalParent' => 'editmodal_sertif',
])

<script>
    $(document).ready(function() {
        let tbSertifikat = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        function initSertifikatTable() {
            if (tbSertifikat) return;
            tbSertifikat = $('#{{ $tableId }}').DataTable({
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
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalviewSer" id="btn-view-sertif">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}" title="Edit Dokumen" data-toggle="modal" data-target="#{{ $editModalParent }}" id="edit_sertif">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#" data-id="${data.id}" data-berkas="${data.berkas_id}" data-pegawai="${data.id_pegawai}" id="hapus_sertif" title="Hapus Dokumen">Hapus</a>
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
            if (e.detail.tabId === '#sertif') {
                initSertifikatTable();
            }
        });

        // Reset form/modal saat modal ditutup
        $('#{{ $modalParent }}, #{{ $editModalParent }}').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        // VIEW dokumen
        $(document).on('click', '#btn-view-sertif', function(e) {
            e.preventDefault();
            var filename = $(this).data('file');
            var url = baseUrl + '{{ $viewRoutePDF }}' + encodeURIComponent(filename);
            // console.log(url);
            PDFObject.embed(url, "#view-sertif-modal");
        });

        // Tambah Sertifikat
        $('#form-add-sertif').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-add-sertif')[0];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(form);
            $('.btn-login').addClass("d-none");
            $('.btn-login-disabled').removeClass("d-none");
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
                        $('#error_list').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list').append('<li>' + error_value + '</li>');
                        });
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#{{ $modalParent }}').modal('hide');
                        $('#{{ $modalParent }}').find('.form-control').val("");
                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                        tbSertifikat.ajax.reload();
                    }
                },
                error: function() {
                    $('.btn-login').removeClass("d-none");
                    $('.btn-login-disabled').addClass("d-none");
                }
            });
        });

        // Edit Sertifikat
        $(document).on('click', '#edit_sertif', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($editRoute) }}",
                data: {
                    'id': $(this).data('id')
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

        // Update Sertifikat
        $('#form-edit-sertif').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-sertif')[0];
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData(form);
            $('.btn-update').addClass('d-none');
            $('.btn-update-disabled').removeClass('d-none');
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
                        $('#error_list_edit').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_edit').append('<li>' + error_value +
                                '</li>');
                        });
                        $('.btn-update').removeClass('d-none');
                        $('.btn-update-disabled').addClass('d-none');
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#{{ $editModalParent }}').modal('hide');
                        $('#{{ $editModalParent }}').find('.form-control').val("");
                        $('.btn-update').removeClass('d-none');
                        $('.btn-update-disabled').addClass('d-none');
                        tbSertifikat.ajax.reload();
                    }
                }
            });
        });

        // Hapus Sertifikat
        $(document).on('click', '#hapus_sertif', function() {
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
                        'id': $(this).data('id'),
                        'berkas_id': $(this).data('berkas'),
                        'id_pegawai': $(this).data('pegawai'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        tbSertifikat.ajax.reload();
                    }
                });
            }
        });
    });
</script>
