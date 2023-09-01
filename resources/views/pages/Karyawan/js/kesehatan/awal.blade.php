<script>
    var idpegawai = $('.id-pegawai').val();
    $(document).ready(function() {
        $('#tbkesAwal').DataTable({
            paging: false,
            scrollX: false,
            bInfo: false,
            searching: false,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{ route('kesehatan.awal.index') }}',
                data: {
                    'id_pegawai': idpegawai,
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
                    data: 'nama_pemeriksaan',
                    name: 'nama_pemeriksaan'
                },
                {
                    data: 'tgl_pemeriksaan',
                    name: 'tgl_pemeriksaan'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    'data': null,
                    render: function(data, row, type) {
                        return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalKesehatanAwal" id="view-kesehatan-awal">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditAwal" id="edit-kes-awal">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        }); //End Datatable


        //VIEW Berkas Kesehatan Awal
        $(document).on('click', '#view-kesehatan-awal', function(e) {
            e.preventDefault();
            var namafile = $(this).data('id');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Kesehatan/Kesehatan/' + namafile, "#view-kesehatan-awal-modal");
        });
        //ADD KESEHATAN AWAL
        $('#form-add-kesehatan-awal').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-add-kesehatan-awal')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('kesehatan.awal.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list').html("")
                        $('#error_list').addClass("alert alert-danger")
                        $('#error_list').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modaladdAwal').modal('hide')
                        $('#modaladdAwal').find('.form-control').val("");

                        var tbkesAwal = $('#tbkesAwal').DataTable();
                        tbkesAwal.ajax.reload();
                    }
                }
            });
        });

        $('#modaladdAwal').on('hidden.bs.modal', function() {
            $('#modaladdAwal').find('.form-control').val("");
            $('#modaladdAwal').find('.custom-select').val("");
            $('.alert-danger').addClass('d-none');
        });

        //EDIT KESEHATAN AWAL
        $(document).on('click', '#edit-kes-awal', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('kesehatan.awal.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                    $('#id_kesehatan_awal').val(response.data.id);
                    $('#nama_file_edit').val(response.data.nama_file_kesehatan_id);
                    $('#nama_pemeriksaan_edit').val(response.data.nama_pemeriksaan);
                    $('#tgl_pemeriksaan_edit').val(response.data.tgl_pemeriksaan);
                    // $('#file_edit').val(response.data.file);
                }
            });
        });

        //UPDATE KESEHATAN AWAL
        $('#form-edit-kesehatan-awal').on('submit', function(e) {
            e.preventDefault();

            var data = {
                'id': $('#id_kesehatan_awal').val(),
            }

            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-edit-kesehatan-awal')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('kesehatan.awal.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_edit').html("")
                        $('#error_list_edit').addClass("alert alert-danger")
                        $('#error_list_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_edit').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)

                        $('#modaleditAwal').modal('hide')
                        $('#modaleditAwal').find('.form-control').val("");
                        $('#modaladdAwal').find('.custom-select').val("");

                        var tbkesAwal = $('#tbkesAwal').DataTable();
                        tbkesAwal.ajax.reload();


                    }
                }
            });

        });

        $('#modaleditAwal').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS KESEHATAN AWAL
        $(document).on('click', '#hapus', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus data ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('kesehatan.awal.destroy') }}",
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
                        var tbkesAwal = $('#tbkesAwal').DataTable();
                        tbkesAwal.ajax.reload();

                    }
                });
            }
        });

    }); //End Jquery Document Ready
</script>
