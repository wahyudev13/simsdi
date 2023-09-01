<script>
    $(document).ready(function() {
        $('#tb-lainlain').DataTable({
            ordering: false,
            paging: false,
            scrollX: false,
            bInfo: false,
            searching: false,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{ route('berkas.lainlain.get') }}',
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
                                        <a class="dropdown-item" href="#" data-file="${data.file}"  title="Lihat Dokumen" id="view-lainlain"  data-toggle="modal" data-target="#modal-lainlain">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-lain" id="edit_lainlain">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" data-namaberkas="${data.nama_berkas}" id="hapus_lainlain"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Berkas Lain
        $(document).on('click', '#view-lainlain', function(e) {
            e.preventDefault();
            var namafile = $(this).data('file');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/Lain/' + namafile, "#view-lainlain-modal");
        });

        $('#form-tambah-lainlain').on('submit', function(e) {
            e.preventDefault();
            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-lainlain')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.lainlain.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_lainlain').html("")
                        $('#error_list_lainlain').addClass("alert alert-danger")
                        $('#error_list_lainlain').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_lainlain').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modal-add-lain').modal('hide')
                        $('#modal-add-lain').find('.form-control').val("");
                        $('#tb-lainlain').DataTable().ajax.reload();

                    }
                }
            });
        });

        $('#modal-add-lain').on('hidden.bs.modal', function() {
            $('#modal-add-lain').find('.form-control').val("");
            $('#modal-add-lain').find('.custom-file-input').val("");

            $('.alert-danger').addClass('d-none');
        });

        //EDIT Berkas Lain
        $(document).on('click', '#edit_lainlain', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('berkas.lainlain.edit') }}",
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

        //UPDATE Berkas LAin
        $('#form-edit-lainlain').on('submit', function(e) {
            e.preventDefault();

            // var data = {
            //     'id': $('#id_lain_lain').val(),
            // }

            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-edit-lainlain')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.lainlain.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_lainlain_edit').html("")
                        $('#error_list_lainlain_edit').addClass("alert alert-danger")
                        $('#error_list_lainlain_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_lainlain_edit').append('<li>' +
                                error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modal-edit-lain').modal('hide')
                        $('#modal-edit-lain').find('.form-control').val("");
                        $('#tb-lainlain').DataTable().ajax.reload();


                    }
                }
            });
        });

        $('#modal-edit-lain').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS Lain
        $(document).on('click', '#hapus_lainlain', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('berkas.lainlain.destroy') }}",
                    data: {
                        'id': $(this).data('id'),
                        'nama': $(this).data('namaberkas')
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').addClass("alert alert-warning")
                        $('#success_message').text(response.message)
                        $('#tb-lainlain').DataTable().ajax.reload();

                    }
                });
            }
        });
    });
</script>
