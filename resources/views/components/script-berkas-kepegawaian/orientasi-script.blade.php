@props([
    'tableId' => 'tb-orientasi',
    'orientasiRoute' => 'berkas.orientasi.get',
    'orientasiStoreRoute' => 'berkas.orientasi.store',
    'orientasiEditRoute' => 'berkas.orientasi.edit',
    'orientasiUpdateRoute' => 'berkas.orientasi.update',
    'orientasiDestroyRoute' => 'berkas.orientasi.destroy',
    'enablePaging' => false,
    'enableSearch' => false,
    'enableInfo' => false,
    'viewRoutePDF' => '/karyawan/berkas/orientasi/view/',
    'aksesPage' => 'admin',
])

<script>
    $(document).ready(function() {
        // Variabel untuk menyimpan instance DataTable
        let orientasiTable = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        //============================AKSES PAGE PENGGUNA============================//
        if ('{{ $aksesPage }}' == 'user') {
            @if ($permissions['view'] ?? true)
                initOrientasiTable();
            @endif
        }
        // Fungsi untuk inisialisasi DataTable Orientasi
        function initOrientasiTable() {
            if (orientasiTable) return; // Sudah diinisialisasi

            orientasiTable = $('#{{ $tableId }}').DataTable({
                paging: {{ $enablePaging ? 'true' : 'false' }},
                bInfo: {{ $enableInfo ? 'true' : 'false' }},
                searching: {{ $enableSearch ? 'true' : 'false' }},
                serverSide: true,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                ajax: {
                    url: '{{ route($orientasiRoute) }}',
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
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: null,
                        render: function(data, row, type) {
                            return `
                                <span class="badge badge-primary"> <i class="fas fa-calendar-alt"></i> Tanggal Mulai   : ${data.tgl_mulai}</span><br>
                                <span class="badge badge-primary"> <i class="fas fa-calendar-alt"></i> Tanggal Selesai : ${data.tgl_selesai}</span>
                            `;
                        }
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
                                        @if ($permissions['view'] ?? true)
                                            <a class="dropdown-item" href="#" data-file="${data.file}"  title="Lihat Dokumen" id="view-orientasi"  data-toggle="modal" data-target="#modal-orientasi">Lihat Dokumen</a>
                                        @endif
                                        @if ($permissions['edit'] ?? true)
                                            <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-orientasi" id="edit-orientasi">Edit Dokumen</a>
                                        @endif
                                        @if ($permissions['delete'] ?? true)
                                            <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" data-nomor="${data.nomor}" id="hapus-orientasi"  title="Hapus Dokumen">Hapus</a>
                                        @endif
                                    </div>
                                </div>
                            `;
                        }
                    },
                ]
            });
        }

        // Event listener untuk load data tab orientasi
        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#orientasi') {
                initOrientasiTable();
            }
        });

        //VIEW Orientasi
        $(document).on('click', '#view-orientasi', function(e) {
            e.preventDefault();
            var filename = $(this).data('file');
            var url = baseUrl + '{{ $viewRoutePDF }}' + encodeURIComponent(filename);
            PDFObject.embed(url, "#view-ori-modal");
        });

        // Tambah Orientasi
        $('#form-tambah-orientasi').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-tambah-orientasi')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#add_ori').addClass("d-none");
            $('#add_ori_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($orientasiStoreRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_ori').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_ori').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add_ori').removeClass("d-none");
                        $('#add_ori_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-warning").addClass(
                            "alert alert-success").text(response.message);
                        $('#modal-add-orientasi').modal('hide');
                        $('#modal-add-orientasi').find('.form-control').val("");
                        $('#add_ori').removeClass("d-none");
                        $('#add_ori_disabled').addClass("d-none");
                        orientasiTable.ajax.reload();
                    }
                },
                error: function() {
                    $('#add_ori').removeClass("d-none");
                    $('#add_ori_disabled').addClass("d-none");
                }
            });
        });

        // Reset form/modal saat modal ditutup
        $('#modal-add-orientasi, #modal-edit-orientasi').on('hidden.bs.modal', function() {
            $(this).find('.form-control, .custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        //EDIT Orientasi
        $(document).on('click', '#edit-orientasi', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route($orientasiEditRoute) }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_orientasi').val(response.data.id);
                    $('#id_pegawai_orientasi_edit').val(response.data.id_pegawai);
                    $('#nama_file_ori_edit').val(response.data.nama_file_id);
                    $('#nomor_orientasi_edit').val(response.data.nomor);
                    $('#tgl_mulai_edit').val(response.data.tgl_mulai);
                    $('#tgl_selesai_edit').val(response.data.tgl_selesai);
                }
            });
        });

        //UPDATE Orientasi
        $('#form-edit-orientasi').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-edit-orientasi')[0];
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#update_ori').addClass("d-none");
            $('#update_ori_disabled').removeClass("d-none");
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route($orientasiUpdateRoute) }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_ori_edit').html("").addClass("alert alert-danger")
                            .removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#error_list_ori_edit').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#update_ori').removeClass("d-none");
                        $('#update_ori_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("").removeClass(
                            "alert-success alert-warning").addClass(
                            "alert alert-primary").text(response.message);
                        $('#modal-edit-orientasi').modal('hide');
                        $('#modal-edit-orientasi').find('.form-control').val("");
                        $('#update_ori').removeClass("d-none");
                        $('#update_ori_disabled').addClass("d-none");
                        orientasiTable.ajax.reload();
                    }
                }
            });
        });

        //HAPUS Orientasi
        $(document).on('click', '#hapus-orientasi', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route($orientasiDestroyRoute) }}",
                    data: {
                        'id_orientasi': $(this).data('id'),
                        'nomor': $(this).data('nomor'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("").removeClass(
                            "alert-primary alert-success").addClass(
                            "alert alert-warning").text(response.message);
                        orientasiTable.ajax.reload();
                    }
                });
            }
        });
    });
</script>
