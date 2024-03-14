<script>
    $(document).ready(function() {
        $('.select-departemen').select2({
            //minimumInputLength: 3,
            // minimumResultsForSearch: -1,
            theme: "bootstrap-5",
            dropdownParent: "#modal-add-uraian",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),

        });

        $('.select-departemen-edit').select2({
            //minimumInputLength: 3,
            // minimumResultsForSearch: -1,
            theme: "bootstrap-5",
            dropdownParent: "#modal-edit-uraian",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#tb-uraian').DataTable({
            paging: false,
            // scrollX: false,
            bInfo: false,
            searching: false,
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{route('berkas.uraian.get')}}',
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
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
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
                                        <a class="dropdown-item" href="#" data-file="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modal-view-uraian" id="view-uraian">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modal-edit-uraian" id="edit-uraian">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus-uraian"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Berkas Uraian
        $(document).on('click', '#view-uraian', function(e) {
            e.preventDefault();
            var uraian = $(this).data('file');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/Uraian-Tugas/'+uraian, "#view-uraian-modal");
        }); 

        //Store Berkas Uraian
        $('#form-tambah-uraian').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-uraian')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.uraian.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend:function(){
                       $('#add-uraian').addClass("d-none");
                       $('#add-uraian-disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_uraian').html("")
                        $('#error_list_uraian').addClass("alert alert-danger")
                        $('#error_list_uraian').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_uraian').append('<li>' + error_value + '</li>');
                        });
                        $('#add-uraian').removeClass("d-none");
                        $('#add-uraian-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#modal-add-uraian').modal('hide')
                        $('#modal-add-uraian').find('.form-control').val("");
                        $('#add-uraian').removeClass("d-none");
                        $('#add-uraian-disabled').addClass("d-none");
                        $('#tb-uraian').DataTable().ajax.reload();
                    }
                }
            });
        });
        
        $('#modal-add-uraian').on('hidden.bs.modal', function() {
            $('#modal-add-uraian').find('.form-control').val("");
            $('#modal-add-uraian').find('#dep-spk').val("");
            $('#modal-add-uraian').find('.custom-file-input').val("");
            $('.select-departemen').val(null).trigger('change');
            $('.alert-danger').addClass('d-none');
        });

        //EDIT  Berkas Uraian
        $(document).on('click', '#edit-uraian', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('berkas.uraian.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id_uraian').val(response.data.id);
                    $('#id_pegawai_uraian_edit').val(response.data.id_pegawai);
                    $('.select-departemen-edit').val(response.data.departemen_id).trigger('change');
                    $('#jabatan-edit').val(response.data.jabatan);
                }
            });
        });

        //UPDATE Berkas Uraian
        $('#form-edit-uraian').on('submit', function(e) {
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

            var form = $('#form-edit-uraian')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.uraian.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_uraian_edit').html("")
                        $('#error_list_uraian_edit').addClass("alert alert-danger")
                        $('#error_list_uraian_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_uraian_edit').append('<li>' + error_value + '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        $('#success_message').text(response.message)
                        $('#modal-edit-uraian').modal('hide')
                        $('#modal-edit-uraian').find('.form-control').val("");
                        $('#tb-uraian').DataTable().ajax.reload();

                    }
                }
            });

        });

        $('#modal-edit-uraian').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
            $('.select-departemen-edit').val(null).trigger('change');
        });

        //HAPUS  Berkas Uraian
        $(document).on('click', '#hapus-uraian', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Uraian Tugas  ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('berkas.uraian.destroy') }}",
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
                        $('#tb-uraian').DataTable().ajax.reload();

                    }
                });
            }
        });

    });
  
</script>
