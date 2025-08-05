<script>
    var idpegawai = $('.id-pegawai').val();
    $(document).ready(function() {
        $('#tb-penilaian').DataTable({
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
                url: '{{ route('penilaian.berkas.get') }}',
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
                    data: 'tgl_penilaian',
                    name: 'tgl_penilaian'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'jml_total',
                    name: 'jml_total'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
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
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modal-view-nilai" id="view-penilaian">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-penilaian" id="edit-penilaian">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus-penilaian"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Berkas Penilaian
        $(document).on('click', '#view-penilaian', function(e) {
            e.preventDefault();
            var penilaian = $(this).data('file');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Penilaian/' + penilaian, "#view-nilai");
        });

        //Store Berkas Penilaian
        $('#form-tambah-penilaian').on('submit', function(e) {
            e.preventDefault();
            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-penilaian')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('penilaian.berkas.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_penilaian').html("")
                        $('#error_list_penilaian').addClass("alert alert-danger")
                        $('#error_list_penilaian').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_penilaian').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modal-add-penilaian').modal('hide')
                        $('#modal-add-penilaian').find('.form-control').val("");

                        $('#tb-penilaian').DataTable().ajax.reload();
                    }
                }
            });
        });

        $('#modal-add-penilaian').on('hidden.bs.modal', function() {
            $('#modal-add-penilaian').find('.form-control').val("");
            $('#modal-add-penilaian').find('.custom-file-input').val("");
            $('.select-departemen').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
        });

        //EDIT  Berkas Penilaian
        $(document).on('click', '#edit-penilaian', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('penilaian.berkas.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id-penilaian').val(response.data.id);
                    $('#id_pegawai_penilaian_edit').val(response.data.id_pegawai);
                    $('#tgl-penilaian-edit').val(response.data.tgl_penilaian);
                    $('.select-departemen-edit').val(response.data.departemen_id).trigger(
                        'change');
                    $('#jabatan-edit').val(response.data.jabatan);
                    $('#nilai-edit').val(response.data.jml_total);
                }
            });
        });

        //UPDATE Berkas Penilaian
        $('#form-update-penilaian').on('submit', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-update-penilaian')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('penilaian.berkas.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_penilaian_edit').html("")
                        $('#error_list_penilaian_edit').addClass("alert alert-danger")
                        $('#error_list_penilaian_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_penilaian_edit').append('<li>' +
                                error_value + '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        $('#success_message').text(response.message)
                        $('#modal-edit-penilaian').modal('hide')
                        $('#modal-edit-penilaian').find('.form-control').val("");
                        $('#tb-penilaian').DataTable().ajax.reload();
                    }
                }
            });

        });

        $('#modal-edit-penilaian').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS  Berkas Penilaian
        $(document).on('click', '#hapus-penilaian', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Penilaian ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('penilaian.berkas.destroy') }}",
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
                        $('#tb-penilaian').DataTable().ajax.reload();

                    }
                });
            }
        });

        $('.select-departemen').select2({
            //minimumInputLength: 3,
            // minimumResultsForSearch: -1,
            theme: "bootstrap-5",
            dropdownParent: "#modal-add-penilaian",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),

        });

        $('.select-departemen-edit').select2({
            //minimumInputLength: 3,
            // minimumResultsForSearch: -1,
            theme: "bootstrap-5",
            dropdownParent: "#modal-edit-penilaian",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),

        });

    });
    //END DOCUMENT READY FUNCTION
</script>
