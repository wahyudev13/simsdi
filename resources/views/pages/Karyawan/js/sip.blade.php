<script>
    $(document).ready(function() {
        $('.select-str').select2({
            //minimumInputLength: 3,
            minimumResultsForSearch: -1,
            ajax: {
                type: "GET",
                url: '{{ route('file.str.get') }}',
                data: {
                    'id': idpegawai,
                },
                dataType: 'json',
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
            },
            theme: "bootstrap-5",
            dropdownParent: "#modaladdSIP",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            //placeholder: $(this).data('placeholder'),

        });

        // var id_pegawai2 = $('.id-pegawai').val();
        // var idsip = $('.id-sip-edit').val();




    });
</script>
<script>
    $(document).ready(function() {
        var tabelSTR = $('#tbSIP').DataTable({
            // ordering: false,
            paging: false,
            // scrollX: true,
            bInfo: false,
            searching: false,
            // processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('berkas.getSIP') }}',
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
                    data: 'no_sip',
                    name: 'no_sip'
                },
                {
                    data: 'no_reg_str',
                    name: 'no_reg_str'
                },
                {
                    data: 'kompetensi',
                    name: 'kompetensi'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    // {{ asset('/Pegawai/Dokumen/STR/${data.file}') }}
                    data: null,
                    render: function(data, row, type) {
                        return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="${data.file}"   title="Lihat Dokumen" id="view-sip"  data-toggle="modal" data-target="#modalSIP">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSIP" id="edit_sip">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_sip"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>

                                `;
                    }
                },

            ]
        });

        //VIEW Berkas SIP
        $(document).on('click', '#view-sip', function(e) {
            e.preventDefault();
            var fileSIP = $(this).data('id');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/SIP/' + fileSIP, "#view-sip-modal");
        });

        $('#form-tambah-sip').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-sip')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.sip.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_sip').html("")
                        $('#error_list_sip').addClass("alert alert-danger")
                        $('#error_list_sip').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_sip').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaladdSIP').modal('hide')
                        $('#modaladdSIP').find('.form-control').val("");

                        var tbSIP = $('#tbSIP').DataTable();
                        tbSIP.ajax.reload();
                    }
                }
            });
        });
    });

    $('#modaladdSIP').on('hidden.bs.modal', function() {
        $('#modaladdSIP').find('.form-control').val("");
        $('#modaladdSIP').find('.custom-file-input').val("");
        $('.select-str').val(null).trigger('change');
        $('.alert-danger').addClass('d-none');
    });

    //EDIT Berkas SIp
    $(document).on('click', '#edit_sip', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "{{ route('berkas.sip.edit') }}",
            data: {
                'id': $(this).data('id'),
            },
            dataType: "json",
            success: function(response) {

                $('#id-sip-edit').val(response.data.id);
                $('#nama_file_sip_id_edit').val(response.data.nama_file_sip_id);
                $('#no_sip_edit').val(response.data.no_sip);
                $('#no_reg_sip_edit').val(response.data.no_reg);

                // $('.select-str-edit').select2({
                //     //minimumInputLength: 3,
                //     tags: true,
                //     minimumResultsForSearch: -1,
                //     ajax: {
                //         type: "GET",
                //         url: '/karyawan/str/selected/get/' + response.data.id,
                //         dataType: 'json',
                //         processResults: function(response) {
                //             return {
                //                 results: response
                //             };
                //         },
                //     },
                //     theme: "bootstrap-5",
                //     dropdownParent: "#modaleditSIP",
                //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                //         'w-100') ? '100%' : 'style',
                //     //placeholder: $(this).data('placeholder'),

                // });

                $('.select-str-edit').select2({
                    //minimumInputLength: 3,
                    tags: true,
                    minimumResultsForSearch: -1,
                    ajax: {
                        type: "GET",
                        url: "{{route('selected.str.get')}}",
                        data: function (params) {
                            return {
                                id: response.data.id
                            };
                        },
                        dataType: 'json',
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                    },
                    theme: "bootstrap-5",
                    dropdownParent: "#modaleditSIP",
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                        'w-100') ? '100%' : 'style',
                    //placeholder: $(this).data('placeholder'),

                });
            }
        });
    });

    //UPDATE Berkas SIP
    $('#form-edit-sip').on('submit', function(e) {
        e.preventDefault();

        var data = {
            'id': $('#id-sip-edit').val(),
        }

        var file = $('.file').val();
        var rename = file.replace("C:\\fakepath\\", "");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#form-edit-sip')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ route('berkas.sip.update') }}",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.status == 400) {
                    $('#error_list_sip_edit').html("")
                    $('#error_list_sip_edit').addClass("alert alert-danger")
                    $('#error_list_sip_edit').removeClass("d-none")

                    $.each(response.error, function(key, error_value) {
                        $('#error_list_sip_edit').append('<li>' + error_value + '</li>');
                    });
                } else {
                    $('#success_message').html("")
                    $('#success_message').removeClass("alert-success")
                    $('#success_message').removeClass("alert-warning")
                    $('#success_message').addClass("alert alert-primary")
                    // $('#success_message').removeClass("d-none")
                    $('#success_message').text(response.message)
                    $('#modaleditSIP').modal('hide')
                    $('#modaleditSIP').find('.form-control').val("");
                    var tbSIP = $('#tbSIP').DataTable();
                    tbSIP.ajax.reload();


                }
            }
        });
    });

    $('#modaleditSIP').on('hidden.bs.modal', function() {
        // $('#modalJenjang').find('.form-control').val("");
        $('.alert-danger').addClass('d-none');
        $('.select-str-edit').val(null).trigger('change');
    });

    //HAPUS SIP
    $(document).on('click', '#hapus_sip', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm('Yakin Ingin Menghapus Berkas SIP ?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.sip.destroy') }}",
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
                    var tbSIP = $('#tbSIP').DataTable();
                    tbSIP.ajax.reload();

                }
            });
        }
    });
</script>
