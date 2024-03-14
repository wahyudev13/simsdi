<script>
    $(document).ready(function() {
        $('#tableTrans').DataTable({
            paging: false,
            scrollX: false,
            bInfo: false,
            searching: false,
            // processing: true,
            serverSide: true,
            ajax: {
                url: '{{route('berkas.getTranskrip')}}',
                data:{
                    'id' : idpegawai,
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
                    data: 'nomor_transkrip',
                    name: 'nomor_transkrip'
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
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" data-toggle="modal" data-target="#modalTranskrip" id="view-trasnkrip">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditTrans" id="edit_trans">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_trans"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                        
                        `;
                    }
                },

            ]
        });

        //VIEW Berkas Ijazah
        $(document).on('click', '#view-trasnkrip', function(e) {
            e.preventDefault();
            var transkripfile = $(this).data('id');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/Transkrip/' + transkripfile, "#view-transkrip-modal");
        });

        //TAMBAH TRANSKRIP
        $('#form-tambah-trans').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-trans')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.transkrip.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend:function(){
                       $('#add_transkrip').addClass("d-none");
                       $('#add_transkrip_disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_trans').html("")
                        $('#error_list_trans').addClass("alert alert-danger")
                        $('#error_list_trans').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_trans').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add_transkrip').removeClass("d-none");
                        $('#add_transkrip_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaladdTrans').modal('hide')
                        $('#modaladdTrans').find('.form-control').val("");
                        $('#add_transkrip').removeClass("d-none");
                        $('#add_transkrip_disabled').addClass("d-none");
                        var tableTrans = $('#tableTrans').DataTable();
                        tableTrans.ajax.reload();
                        //fetchData();
                    }
                }
            });
        });
    });

    $('#modaladdTrans').on('hidden.bs.modal', function() {
        $('#modaladdTrans').find('.form-control').val("");
        $('#modaladdTrans').find('.custom-file-input').val("");

        $('.alert-danger').addClass('d-none');
    });

    //EDIT Berkas Transkrip
    $(document).on('click', '#edit_trans', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "{{ route('berkas.transkrip.edit') }}",
            data: {
                'id': $(this).data('id'),
            },
            dataType: "json",
            success: function(response) {
                $('#id-trans-edit').val(response.data.id);
                $('#id-trans-pegawai-edit').val(response.data.id_pegawai);
                //$('#nik-trans-edit').val(response.data.nik_pegawai);
                $('#nama_file_trans_id_edit').val(response.data.nama_file_trans_id);
                $('#nomor_transkrip_edit').val(response.data.nomor_transkrip);
            }
        });
    });

    //UPDATE Berkas Transkrip
    $('#form-edit-trans').on('submit', function(e) {
        e.preventDefault();

        var data = {
            'id': $('#id-trans-edit').val(),
        }

        var file = $('.file').val();
        var rename = file.replace("C:\\fakepath\\", "");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#form-edit-trans')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ route('berkas.transkrip.update') }}",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.status == 400) {
                    $('#error_list_trans_edit').html("")
                    $('#error_list_trans_edit').addClass("alert alert-danger")
                    $('#error_list_trans_edit').removeClass("d-none")

                    $.each(response.error, function(key, error_value) {
                        $('#error_list_trans_edit').append('<li>' + error_value + '</li>');
                    });
                } else {
                    $('#success_message').html("")
                    $('#success_message').removeClass("alert-success")
                    $('#success_message').removeClass("alert-warning")
                    $('#success_message').addClass("alert alert-primary")
                    // $('#success_message').removeClass("d-none")
                    $('#success_message').text(response.message)
                    $('#modaleditTrans').modal('hide')
                    $('#modaleditTrans').find('.form-control').val("");
                    var tableTrans = $('#tableTrans').DataTable();
                    tableTrans.ajax.reload();
                    //fetchData();


                }
            }
        });
    });

    $('#modaleditTrans').on('hidden.bs.modal', function() {
        $('.alert-danger').addClass('d-none');
    });

    //HAPUS transkrip
    $(document).on('click', '#hapus_trans', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm('Yakin Ingin Menghapus data Transkrip ?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.transkrip.destroy') }}",
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
                    var tableTrans = $('#tableTrans').DataTable();
                    tableTrans.ajax.reload();

                }
            });
        }
    });
</script>