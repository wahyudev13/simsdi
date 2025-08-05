@props([
    'tableId' => 'tb-spk',
    'spkGetRoute' => 'berkas.spk.get',
    'spkStoreRoute' => 'berkas.spk.store',
    'spkEditRoute' => 'berkas.spk.edit',
    'spkUpdateRoute' => 'berkas.spk.update',
    'spkDestroyRoute' => 'berkas.spk.destroy',
    'modalAdd' => 'modal-add-spk',
    'modalEdit' => 'modal-edit-spk',
    'viewRoutePDF' => '/karyawan/berkas/spk/view/',
])
<script>
    $(document).ready(function() {
        let spkTable = null;
        var baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();
        // Inisialisasi DataTable SPK
        function initSPKTable() {
            if (spkTable) return;
            $('.select-unit-kerja').select2({
                theme: "bootstrap-5",
                dropdownParent: `#{{ $modalAdd }}`,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
                placeholder: $(this).data('placeholder'),
            });
            $('.select-unit-kerja-edit').select2({
                theme: "bootstrap-5",
                dropdownParent: `#{{ $modalEdit }}`,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                    '100%' : 'style',
                placeholder: $(this).data('placeholder'),
            });
            spkTable = $(`#{{ $tableId }}`).DataTable({
                paging: false,
                bInfo: false,
                searching: false,
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($spkGetRoute) }}',
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
                        data: 'nomor_spk',
                        name: 'nomor_spk'
                    },
                    {
                        data: 'nama_departemen',
                        name: 'nama_departemen'
                    },
                    {
                        data: 'kualifikasi',
                        name: 'kualifikasi'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modal-view-spk" id="view-spk">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#{{ $modalEdit }}" id="edit-spk">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus-spk"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                            `;
                        }
                    },
                ]
            });
        }
        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#spk') {
                initSPKTable();
            }
        });
        $(document).on('click', '#view-spk', function(e) {
            e.preventDefault();
            var filename = $(this).data('file');
            var url = baseUrl + '{{ $viewRoutePDF }}' + encodeURIComponent(filename);
            PDFObject.embed(url, "#view-spk-modal");
        });
        $('#form-tambah-spk').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = $('#form-tambah-spk')[0];
            var formData = new FormData(form);
            $('#add-spk').addClass("d-none");
            $('#add-spk-disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($spkStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_spk').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_spk').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add-spk').removeClass("d-none");
                        $('#add-spk-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#{{ $modalAdd }}').modal('hide');
                        $('#{{ $modalAdd }}').find('.form-control').val("");
                        $('#add-spk').removeClass("d-none");
                        $('#add-spk-disabled').addClass("d-none");
                        $(`#{{ $tableId }}`).DataTable().ajax.reload();
                    }
                }
            });
        });
        $(`#{{ $modalAdd }}`).on('hidden.bs.modal', function() {
            $(this).find('.form-control').val("");
            $(this).find('#dep-spk').val("");
            $(this).find('.custom-file-input').val("");
            $('.select-unit-kerja').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
        });
        $(document).on('click', '#edit-spk', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($spkEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_spk_edit').val(response.data.id);
                    $('#id_pegawai_spk_edit').val(response.data.id_pegawai);
                    $('#no-spk-edit').val(response.data.nomor_spk);
                    $('.select-unit-kerja-edit').val(response.data.departemen_id).trigger(
                        'change');
                    $('#kualifikasi-edit').val(response.data.kualifikasi);
                }
            });
        });
        $('#form-edit-spk').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = $('#form-edit-spk')[0];
            var formData = new FormData(form);
            $('#update-spk-edit').addClass('d-none');
            $('#update-spk-edit-disabled').removeClass('d-none');
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($spkUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_spk_edit').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_spk_edit').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#update-spk-edit').removeClass('d-none');
                        $('#update-spk-edit-disabled').addClass('d-none');
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#{{ $modalEdit }}').modal('hide');
                        $('#{{ $modalEdit }}').find('.form-control').val("");
                        $(`#{{ $tableId }}`).DataTable().ajax.reload();
                        $('#update-spk-edit').removeClass('d-none');
                        $('#update-spk-edit-disabled').addClass('d-none');
                    }
                },
                error: function() {
                    $('#update-spk-edit').removeClass('d-none');
                    $('#update-spk-edit-disabled').addClass('d-none');
                }
            });
        });
        $(`#{{ $modalEdit }}`).on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
            $(this).find('#dep-spk-edit').val("");
            $('.select-unit-kerja-edit').val(null).trigger('change');
        });
        $(document).on('click', '#hapus-spk', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Surat Penugsan Klinik  ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($spkDestroyRoute) }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        $(`#{{ $tableId }}`).DataTable().ajax.reload();
                    }
                });
            }
        });
    });
</script>
