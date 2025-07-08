<script>
    var idpegawai = $('.id-pegawai').val();
    $(document).ready(function() {
        $('#tbJenjang').DataTable({
            paging: false,
            // scrollX: false,
            bInfo: false,
            searching: false,
            // processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('berkas.getIjazah') }}',
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
                    data: 'asal',
                    name: 'asal'
                },
                {
                    data: 'thn_lulus',
                    name: 'thn_lulus'
                },
                {
                    data: function(data, row, type) {
                        if (data.id_verif === null) {
                            return `
                            <a class="badge badge-danger" href="#" data-id="${data.id_ijazah}" title="Upload Bukti" data-toggle="modal" data-target="#modal-add-bukti" id="add-bukti">
                               <i class="fas fa-times"></i> Belum Ada Bukti Verifikasi
                            </a>
                            `
                        } else {
                            return ` 
                            <a class="badge badge-success" href="#" data-verifijazah="${data.file_verif}" data-ket="${data.keterangan}" title="Lihat Bukti" data-toggle="modal" data-target="#modal-verijazah" id="view-bukti">
                               <i class="fas fa-check"></i> Sudah Ada Bukti Verifikasi
                            </a>
                            
                            <a class="badge badge-danger" href="#" data-id="${data.id_verif}" title="Hapus Bukti" id="hapus-bukti">
                               <i class="fas fa-trash"></i> Hapus
                            </a>
                            `
                        }
                    }
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
                                        <a class="dropdown-item" href="#" data-id="${data.file}" title="Lihat Dokumen" data-toggle="modal" data-target="#modalIjazah" id="view-ijazah">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id_ijazah}"  title="Edit Dokumen" data-toggle="modal" data-target="#editmodalUpload" id="editberkas">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id_ijazah}" id="hapus"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //VIEW Berkas Ijazah
        $(document).on('click', '#view-ijazah', function(e) {
            e.preventDefault();
            var ijazah = $(this).data('id');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/Ijazah/' + ijazah, "#view-ijazah-modal");
        });

        //Store Berkas Ijazah
        $('#form-tambah-berkas').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-berkas')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $('.btn-login').addClass("d-none");
                    $('.btn-login-disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list').html("")
                        $('#error_list').addClass("alert alert-danger")
                        $('#error_list').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list').append('<li>' + error_value + '</li>');
                        });

                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modalUpload').modal('hide')
                        $('#modalUpload').find('.form-control').val("");

                        $('.btn-login').removeClass("d-none");
                        $('.btn-login-disabled').addClass("d-none");

                        var oTable = $('#tbJenjang').DataTable();
                        oTable.ajax.reload();
                        //fetchData();
                    }
                }
            });
        });

        $('#modalUpload').on('hidden.bs.modal', function() {
            $('#modalUpload').find('.form-control').val("");
            $('#modalUpload').find('.custom-file-input').val("");

            $('.alert-danger').addClass('d-none');
        });

        //EDIT  Berkas Ijazah
        $(document).on('click', '#editberkas', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('berkas.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {

                    // $('input[name="kd-devisi"]').val(response.data.kd_devisi);
                    $('#id-ijazah-edit').val(response.data.id);
                    $('#id-pegawai-edit').val(response.data.id_pegawai);
                    // $('#nik-edit').val(response.data.nik_pegawai);
                    $('#nama-file-edit').val(response.data.nama_file_id);
                    $('#nomor-edit').val(response.data.nomor);
                    $('#asal_edit').val(response.data.asal);
                    $('#lulus-edit').val(response.data.thn_lulus);
                    $('#file-edit').val(response.data.file);

                }
            });
        });

        //UPDATE Berkas Ijazah
        $('#form-update-berkas').on('submit', function(e) {
            e.preventDefault();

            var data = {
                'id': $('#id-ijazah-edit').val(),
            }

            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-update-berkas')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.update') }}",
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
                        $('#editmodalUpload').modal('hide')
                        $('#editmodalUpload').find('.form-control').val("");
                        var oTable = $('#tbJenjang').DataTable();
                        oTable.ajax.reload();
                        //fetchData();


                    }
                }
            });

        });

        $('#editmodalUpload').on('hidden.bs.modal', function() {
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS  Berkas Ijazah
        $(document).on('click', '#hapus', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus data ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('berkas.destroy') }}",
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
                        var oTable = $('#tbJenjang').DataTable();
                        oTable.ajax.reload();

                    }
                });
            }
        });

    });
    //END DOCUMENT READY FUNCTION
</script>

<script>
    $(document).ready(function() {
        //VIEW Bukti Verifikasi Ijazah
        $(document).on('click', '#view-bukti', function(e) {
            e.preventDefault();
            var bukti = $(this).data('verifijazah');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/Ijazah/Verifikasi/' + bukti,
                "#view-verijazah-modal");

            var keterangan = $(this).data('ket');
            $('#ket-verif-ijazah').text(keterangan);
        });

        //View Modal ADD Bukti Verifikasi Ijazah
        $('table').on('click', '#add-bukti', function(e) {
            e.preventDefault();
            var ijazah = $(this).data('id');
            $('#id-ijazah-bukti').val(ijazah);

        });

        $('#modal-add-bukti').on('hidden.bs.modal', function() {
            $('#modal-add-bukti').find('.form-control').val("");
            $('#modal-add-bukti').find('.custom-file-input').val("");

            $('.alert-danger').addClass('d-none');
        });

        //Store Bukti Verifikasi Ijazah
        $('#form-tambah-bukti').on('submit', function(e) {
            e.preventDefault();
            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-bukti')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('verif.ijazah.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_bukti').html("")
                        $('#error_list_bukti').addClass("alert alert-danger")
                        $('#error_list_bukti').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_bukti').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modal-add-bukti').modal('hide')
                        $('#modal-add-bukti').find('.form-control').val("");
                        var oTable = $('#tbJenjang').DataTable();
                        oTable.ajax.reload();

                    }
                }
            });
        });

        //HAPUS Bukti Verifikasi Ijazah
        $(document).on('click', '#hapus-bukti', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Bukti Verifikasi ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('verif.ijazah.destroy') }}",
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
                        var oTable = $('#tbJenjang').DataTable();
                        oTable.ajax.reload();

                    }
                });
            }
        });
    });
</script>
