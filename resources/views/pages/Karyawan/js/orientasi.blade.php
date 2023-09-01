<script>
    $(document).ready(function() {
        $('#tb-orientasi').DataTable({
            ordering: false,
            paging: false,
            bInfo: false,
            searching: false,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{ route('berkas.orientasi.get') }}',
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
                                        <a class="dropdown-item" href="#" data-file="${data.file}"  title="Lihat Dokumen" id="view-orientasi"  data-toggle="modal" data-target="#modal-orientasi">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-orientasi" id="edit-orientasi">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" data-nomor="${data.nomor}" id="hapus-orientasi"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Orientasi
        $(document).on('click', '#view-orientasi', function(e) {
            e.preventDefault();
            var namafile = $(this).data('file');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/Orientasi/' + namafile, "#view-ori-modal");
        });

        $('#form-tambah-orientasi').on('submit', function(e) {
            e.preventDefault();
            // var file = $('#file_orientasi').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-orientasi')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.orientasi.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_ori').html("")
                        $('#error_list_ori').addClass("alert alert-danger")
                        $('#error_list_ori').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_ori').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modal-add-orientasi').modal('hide')
                        $('#modal-add-orientasi').find('.form-control').val("");

                        $('#tb-orientasi').DataTable().ajax.reload();

                    }
                }
            });
        });

        $('#modal-add-orientasi').on('hidden.bs.modal', function() {
            $('#modal-add-orientasi').find('.form-control').val("");
            $('#modal-add-orientasi').find('.custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        //EDIT Orientasi
        $(document).on('click', '#edit-orientasi', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('berkas.orientasi.edit') }}",
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

        //UPDATE Berkas Lain
        $('#form-edit-orientasi').on('submit', function(e) {
            e.preventDefault();

            // var data = {
            //     'id': $('#id-lain-edit').val(),
            // }

            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-edit-orientasi')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.orientasi.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_ori_edit').html("")
                        $('#error_list_ori_edit').addClass("alert alert-danger")
                        $('#error_list_ori_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_ori_edit').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modal-edit-orientasi').modal('hide')
                        $('#modal-edit-orientasi').find('.form-control').val("");
                        $('#tb-orientasi').DataTable().ajax.reload();


                    }
                }
            });
        });

        $('#modal-edit-orientasi').on('hidden.bs.modal', function() {
            // $('#modalJenjang').find('.form-control').val("");
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS Lain
        $(document).on('click', '#hapus-orientasi', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('berkas.orientasi.destroy') }}",
                    data: {
                        'id_orientasi': $(this).data('id'),
                        'nomor': $(this).data('nomor'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').addClass("alert alert-warning")
                        $('#success_message').text(response.message)
                        $('#tb-orientasi').DataTable().ajax.reload();

                    }
                });
            }
        });
    });
</script>
