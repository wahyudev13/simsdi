<script>
    var idpegawai = $('.id-pegawai').val();
    $(document).ready(function() {
        $('#tbVaksin').DataTable({
            paging: false,
            scrollX: false,
            bInfo: false,
            searching: false,
            serverSide: true,
            processing: true,
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
            },
            ajax: {
                url: '{{ route('kesehatan.vaksin.index') }}',
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
                    data: 'dosis',
                    name: 'dosis'
                },
                {
                    data: 'jenis_vaksin',
                    name: 'jenis_vaksin'
                },
                {
                    data: 'tgl_vaksin',
                    name: 'tgl_vaksin'
                },
                {
                    data: 'tempat_vaksin',
                    name: 'tempat_vaksin'
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
                                        <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalviewVaksin" id="view-vaksin">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditVaksin" id="edit-vaksin">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}"  data-jenis="${data.jenis_vaksin}" id="hapus-vaksin"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        }); //End Datatable


        //VIEW Vaksin
        $(document).on('click', '#view-vaksin', function(e) {
            e.preventDefault();
            var namafile = $(this).data('id');
            var url = '{{ url('/') }}';
            PDFObject.embed(url + '/File/Pegawai/Kesehatan/Vaksin/' + namafile, "#view-vaksin-modal");
        });
        //ADD VAKSIN
        $('#form-add-vaksin').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-add-vaksin')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('kesehatan.vaksin.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_vaksin').html("")
                        $('#error_list_vaksin').addClass("alert alert-danger")
                        $('#error_list_vaksin').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_vaksin').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modaladdVaksin').modal('hide')
                        $('#modaladdVaksin').find('.form-control').val("");

                        var vaksin = $('#tbVaksin').DataTable().ajax.reload();

                    }
                }
            });
        });

        $('#modaladdVaksin').on('hidden.bs.modal', function() {
            $('#modaladdVaksin').find('.form-control').val("");
            $('#modaladdVaksin').find('.custom-select').val("");
            $('.alert-danger').addClass('d-none');
        });

        //EDIT VAKSIN
        $(document).on('click', '#edit-vaksin', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('kesehatan.vaksin.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                    $('#id_vaksin_edit').val(response.data.id);
                    // $('#nama_file_vaksin_edit').val(response.data.nama_file_kesehatan_id);
                    $('#dosis_edit').val(response.data.dosis);
                    $('#jenis_vaksin_edit').val(response.data.jenis_vaksin);
                    $('#tgl_vaksin_edit').val(response.data.tgl_vaksin);
                    $('#tempat_vaksin_edit').val(response.data.tempat_vaksin);
                    // $('#file_edit').val(response.data.file);
                }
            });
        });

        //UPDATE VAKSIN
        $('#form-edit-vaksin').on('submit', function(e) {
            e.preventDefault();

            var data = {
                'id': $('#id_vaksin_edit').val(),
            }

            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-edit-vaksin')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('kesehatan.vaksin.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_vaksin_edit').html("")
                        $('#error_list_vaksin_edit').addClass("alert alert-danger")
                        $('#error_list_vaksin_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_vaksin_edit').append('<li>' +
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

                        $('#modaleditVaksin').modal('hide')
                        $('#modaleditVaksin').find('.form-control').val("");
                        $('#modaleditVaksin').find('.custom-select').val("");

                        var vaksin = $('#tbVaksin').DataTable().ajax.reload();

                    }
                }
            });

        });

        $('#modaleditVaksin').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS VAKSIN
        $(document).on('click', '#hapus-vaksin', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus data ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('kesehatan.vaksin.destroy') }}",
                    data: {
                        'id': $(this).data('id'),
                        'jenis': $(this).data('jenis'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').addClass("alert alert-warning")
                        $('#success_message').text(response.message)
                        var vaksin = $('#tbVaksin').DataTable().ajax.reload();

                    }
                });
            }
        });

    }); //End Jquery Document Ready
</script>
