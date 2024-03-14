<script>
    $(document).ready(function() {
        $('.select-unit-kerja').select2({
            //minimumInputLength: 3,
            // minimumResultsForSearch: -1,
            theme: "bootstrap-5",
            dropdownParent: "#modal-add-spk",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),

        });
        $('.select-unit-kerja-edit').select2({
            //minimumInputLength: 3,
            // minimumResultsForSearch: -1,
            theme: "bootstrap-5",
            dropdownParent: "#modal-edit-spk",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#tb-spk').DataTable({
            paging: false,
            // scrollX: false,
            bInfo: false,
            searching: false,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{route('berkas.spk.get')}}',
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
                    data: 'nama',
                    name: 'nama'
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
                    'data': null,
                    render: function(data, row, type) {
                        return `
                                
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modal-view-spk" id="view-spk">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-spk" id="edit-spk">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus-spk"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Berkas Ijazah
        $(document).on('click', '#view-spk', function(e) {
            e.preventDefault();
            var spk = $(this).data('file');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'+spk, "#view-spk-modal");
        }); 

        //Store Berkas SPK
        $('#form-tambah-spk').on('submit', function(e) {
            e.preventDefault();
            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-spk')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.spk.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend:function(){
                       $('#add-spk').addClass("d-none");
                       $('#add-spk-disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_spk').html("")
                        $('#error_list_spk').addClass("alert alert-danger")
                        $('#error_list_spk').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_spk').append('<li>' + error_value + '</li>');
                        });
                        $('#add-spk').removeClass("d-none");
                        $('#add-spk-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modal-add-spk').modal('hide')
                        $('#modal-add-spk').find('.form-control').val("");
                        $('#add-spk').removeClass("d-none");
                        $('#add-spk-disabled').addClass("d-none");
                        $('#tb-spk').DataTable().ajax.reload();
                    }
                }
            });
        });
        
        $('#modal-add-spk').on('hidden.bs.modal', function() {
            $('#modal-add-spk').find('.form-control').val("");
            $('#modal-add-spk').find('#dep-spk').val("");
            $('#modal-add-spk').find('.custom-file-input').val("");
            $('.select-unit-kerja').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
        });

        //EDIT  Berkas SPK
        $(document).on('click', '#edit-spk', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('berkas.spk.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_spk_edit').val(response.data.id);
                    $('#id_pegawai_spk_edit').val(response.data.id_pegawai);
                    $('#no-spk-edit').val(response.data.nomor_spk);
                    $('.select-unit-kerja-edit').val(response.data.departemen_id).trigger('change');
                    // $('#dep-spk-edit').val(response.data.departemen_id);
                    $('#kualifikasi-edit').val(response.data.kualifikasi);
                }
            });
        });

        //UPDATE Berkas SPK
        $('#form-edit-spk').on('submit', function(e) {
            e.preventDefault();

            // var data = {
            //     'id': $('#id-ijazah-edit').val(),
            // }

            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-edit-spk')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.spk.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_spk_edit').html("")
                        $('#error_list_spk_edit').addClass("alert alert-danger")
                        $('#error_list_spk_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_spk_edit').append('<li>' + error_value + '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modal-edit-spk').modal('hide')
                        $('#modal-edit-spk').find('.form-control').val("");
                        $('#tb-spk').DataTable().ajax.reload();


                    }
                }
            });

        });

        $('#modal-edit-spk').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
            $('#modal-edit-spk').find('#dep-spk-edit').val("");
            $('.select-unit-kerja-edit').val(null).trigger('change');
        });

        //HAPUS  Berkas SPK
        $(document).on('click', '#hapus-spk', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Surat Penugsan Klinik  ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('berkas.spk.destroy') }}",
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
                        $('#tb-spk').DataTable().ajax.reload();

                    }
                });
            }
        });

    });
  
</script>
