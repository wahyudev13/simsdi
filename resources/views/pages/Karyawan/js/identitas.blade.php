<script>
    $(document).ready(function() {
        var tbLain = $('#tbLain').DataTable({
            // ordering: false,
            paging: false,
            // scrollX: true,
            bInfo: false,
            searching: false,
            // processing: true,
            serverSide: true,
            ajax: {
                url: '{{route('berkas.lain.getFile')}}',
                data: {
                    'id': idpegawai,
                },
            },
            // ajax: route('berkas.lain.getFile', +idpegawai),
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
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-lain"  data-toggle="modal" data-target="#modalLain">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaledit_Identitas" id="edit_lain">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_lain"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Identitas
        $(document).on('click', '#view-lain', function(e) {
            e.preventDefault();
            var namafile = $(this).data('id');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/Identitas/' + namafile, "#view-lain-modal");
        });

        $('#form-tambah-lain').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-lain')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.lain.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_lain').html("")
                        $('#error_list_lain').addClass("alert alert-danger")
                        $('#error_list_lain').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_lain').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modaladd_Identitas').modal('hide')
                        $('#modaladd_Identitas').find('.form-control').val("");

                        var tbLain = $('#tbLain').DataTable();
                        tbLain.ajax.reload();
                    }
                }
            });
        });
    });

    $('#modaladd_Identitas').on('hidden.bs.modal', function() {
        $('#modaladd_Identitas').find('.form-control').val("");
        $('#modaladd_Identitas').find('.custom-file-input').val("");

        $('.alert-danger').addClass('d-none');
    });

    //EDIT Identitas
    $(document).on('click', '#edit_lain', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "{{ route('berkas.lain.edit') }}",
            data: {
                'id': $(this).data('id'),
            },
            dataType: "json",
            success: function(response) {
                $('#id-lain-edit').val(response.data.id);
                $('#nama_file_lain_id_edit').val(response.data.nama_file_lain_id);
            }
        });
    });

    //UPDATE Identitas
    $('#form-edit-lain').on('submit', function(e) {
        e.preventDefault();

        var data = {
            'id': $('#id-lain-edit').val(),
        }

        var file = $('.file').val();
        var rename = file.replace("C:\\fakepath\\", "");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#form-edit-lain')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ route('berkas.lain.update') }}",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.status == 400) {
                    $('#error_list_lain_edit').html("")
                    $('#error_list_lain_edit').addClass("alert alert-danger")
                    $('#error_list_lain_edit').removeClass("d-none")

                    $.each(response.error, function(key, error_value) {
                        $('#error_list_lain_edit').append('<li>' + error_value + '</li>');
                    });
                } else {
                    $('#success_message').html("")
                    $('#success_message').removeClass("alert-success")
                    $('#success_message').removeClass("alert-warning")
                    $('#success_message').addClass("alert alert-primary")
                    // $('#success_message').removeClass("d-none")
                    $('#success_message').text(response.message)
                    $('#modaledit_Identitas').modal('hide')
                    $('#modaledit_Identitas').find('.form-control').val("");
                    var tbLain = $('#tbLain').DataTable();
                    tbLain.ajax.reload();


                }
            }
        });
    });

    $('#modaledit_Identitas').on('hidden.bs.modal', function() {
        // $('#modalJenjang').find('.form-control').val("");
        $('.alert-danger').addClass('d-none');
    });

    //HAPUS Lain
    $(document).on('click', '#hapus_lain', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm('Yakin Ingin Menghapus Berkas ?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.lain.destroy') }}",
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
                    var tbLain = $('#tbLain').DataTable();
                    tbLain.ajax.reload();

                }
            });
        }
    });
</script>
