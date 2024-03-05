<script>
    $(document).ready(function() {
        var tabelSTR = $('#tbSTR').DataTable({
            // ordering: false,
            paging: false,
            // scrollX: true,
            bInfo: false,
            searching: false,
            // processing: true,
            serverSide: true,
            ajax:  {
                url: '{{route('berkas.getSTR')}}',
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
                    data: 'no_reg_str',
                    name: 'no_reg_str'
                },
                {
                    data: 'kompetensi',
                    name: 'kompetensi'
                },
                {
                    data: function(data, row, type) {
                        if (data.status === 'nonactive') {
                            return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-danger"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                `;
                        } else if (data.status === 'proses') {
                            return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Akan Berakhir (Ingatkan)</small>
                                `;
                        } else if (data.status === 'changed'){
                            return `
                                <span class="badge badge-secondary"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-secondary"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                `;
                        } else if (data.status === 'lifetime'){
                            return `
                            <span class="badge badge-success">STR Seumur Hidup</span>
                                `;
                        }else {
                            return `
                                <span class="badge badge-success"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span>
                                
                                `;
                        }
                    }
                },
                {
                    data: function(data, row, type) {
                        if (data.id_verif_str === null) {
                            return `
                            <a class="badge badge-danger" href="#" data-id="${data.id}" title="Upload Bukti" data-toggle="modal" data-target="#modal-add-bukti-str" id="add-bukti-str">
                               <i class="fas fa-times"></i> Belum Ada Bukti Verifikasi
                            </a>
                            `
                        }else{
                            return ` 
                            <a class="badge badge-success" href="#" data-verifstr="${data.file_verif}" data-ket="${data.keterangan}" title="Lihat Bukti" data-toggle="modal" data-target="#modal-verstr" id="view-bukti-str">
                               <i class="fas fa-check"></i> Sudah Ada Bukti Verifikasi
                            </a><br>
                            
                            <a class="badge badge-danger" href="#" data-id="${data.id_verif_str}" title="Hapus Bukti" id="hapus-bukti-str">
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
                    // {{ asset('/File/Pegawai/Dokumen/STR/${data.file}') }}
                    data: null,
                    render: function(data, row, type) {
                        if (data.status !== 'lifetime') {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm dropdown-toggle" title="Set Status Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-exclamation-circle"></i>
                                     
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item set-status" href="#"  data-id="${data.id}" data-status="active" data-noreg="${data.no_reg_str}" id="active"  title="Aktif">Aktif</a>
                                        <a class="dropdown-item set-status" href="#"  data-id="${data.id}" data-status="proses" data-noreg="${data.no_reg_str}" id="proses"  title="Ingatkan">Ingatkan</a>
                                        <a class="dropdown-item set-status" href="#"  data-id="${data.id}" data-status="nonactive" data-noreg="${data.no_reg_str}" id="nonactive"  title="Berakhir">Berakhir</a>
                                        <a class="dropdown-item set-status" href="#"  data-id="${data.id}" data-status="changed" data-noreg="${data.no_reg_str}" id="changed"  title="Diperbaharui">Diperbaharui</a>
                                       
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" title="Aksi Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-str"  data-toggle="modal" data-target="#modalSTR">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSTR" id="edit_str">Edit Dokumen</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_str"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                        }else{
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" title="Aksi Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-str"  data-toggle="modal" data-target="#modalSTR">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSTR" id="edit_str">Edit Dokumen</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_str"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                        }
                       
                    }
                },

            ]
        });


        //UPDATE STATUS STR
        $(document).on('click', '.set-status', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.str.status') }}",
                data: {
                    'id': $(this).data('id'),
                    'status' : $(this).data('status'),
                    'noreg' : $(this).data('noreg'),
                },
                dataType: "json",
                success: function(response) {
                    $('#success_message').html("")
                    $('#success_message').removeClass("alert-warning")
                    $('#success_message').removeClass("alert-success")
                    $('#success_message').addClass("alert alert-primary")
                    $('#success_message').text(response.message)

                    var tbSTR = $('#tbSTR').DataTable();
                    tbSTR.ajax.reload();

                  

                }
                });

        });

        //VIEW Berkas STR
        $(document).on('click', '#view-str', function(e) {
            e.preventDefault();
            var namafile = $(this).data('id');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/STR/' + namafile, "#view-str-modal");
        });

        $('#form-tambah-str').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-str')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.str.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_str').html("")
                        $('#error_list_str').addClass("alert alert-danger")
                        $('#error_list_str').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_str').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaladdSTR').modal('hide')
                        $('#modaladdSTR').find('.form-control').val("");

                        var tbSTR = $('#tbSTR').DataTable();
                        tbSTR.ajax.reload();
                        
                        // location.reload();
                    }
                }
            });
        });

        $('#modaladdSTR').on('hidden.bs.modal', function() {
            $('#modaladdSTR').find('.form-control').val("");
            $('#modaladdSTR').find('.custom-file-input').val("");
            $('#enable_exp_str').prop('checked', false);
            document.getElementById('masa-berlaku').innerHTML=``;
            $('.alert-danger').addClass('d-none');
        });

        //EDIT Berkas STR
        $(document).on('click', '#edit_str', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ route('berkas.str.edit') }}",
                data: {
                    'id': $(this).data('id'),
                },
                dataType: "json",
                success: function(response) {
                    $('#id-str-edit').val(response.data.id);
                    $('#id-str-pegawai-edit').val(response.data.id_pegawai);
                    $('#nama_file_str_id_edit').val(response.data.nama_file_str_id);
                    $('#no_reg_str_edit').val(response.data.no_reg_str);
                    $('#kompetensi_edit').val(response.data.kompetensi);
                    if (response.data.tgl_ed == null || response.data.pengingat == null) {
                        $('#enable_exp_str_edit').prop('checked', false);
                        document.getElementById('masa-berlaku-edit').innerHTML=``;
                    }else{
                        $('#enable_exp_str_edit').prop('checked', true);
                        document.getElementById('masa-berlaku-edit').innerHTML=`
                            <div class="form-group">
                                <label for="tgl_ed_edit" class="col-form-label">Berkalu Sampai <label
                                        class="text-danger">*</label></label>
                                <input type="date" class="form-control tgl_ed_edit" id="tgl_ed_edit" name="tgl_ed">
                            </div>
                            <div class="form-group">
                                <label for="pengingat_edit" class="col-form-label">Pengingat <label
                                        class="text-danger">*</label></label>
                                <input type="date" class="form-control pengingat_edit" id="pengingat_edit"
                                    name="pengingat">
                            </div>
                        `;
                        $('#tgl_ed_edit').val(response.data.tgl_ed);
                        $('#pengingat_edit').val(response.data.pengingat);
                    }
                    
                    // console.log(response.data.tgl_ed);
                }
            });
        });

        //UPDATE Berkas STR
        $('#form-edit-str').on('submit', function(e) {
            e.preventDefault();

            var data = {
                'id': $('#id-str-edit').val(),
            }

            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-edit-str')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.str.update') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_str_edit').html("")
                        $('#error_list_str_edit').addClass("alert alert-danger")
                        $('#error_list_str_edit').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_str_edit').append('<li>' + error_value + '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-success")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-primary")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaleditSTR').modal('hide')
                        $('#modaleditSTR').find('.form-control').val("");
                        var tbSTR = $('#tbSTR').DataTable();
                        tbSTR.ajax.reload();

                        // location.reload();


                    }
                }
            });
        });

        $('#modaleditSTR').on('hidden.bs.modal', function() {
            // $('#modalJenjang').find('.form-control').val("");
            $('.alert-danger').addClass('d-none');
        });

        //HAPUS STR
        $(document).on('click', '#hapus_str', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Berkas STR ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('berkas.str.destroy') }}",
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
                        var tbSTR = $('#tbSTR').DataTable();
                        tbSTR.ajax.reload();

                        // location.reload();

                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        //VIEW Bukti Verifikasi Ijazah
        $(document).on('click', '#view-bukti-str', function(e) {
            e.preventDefault();
            var bukti = $(this).data('verifstr');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/STR/Verifikasi/'+bukti, "#view-verstr-modal");

            var keterangan = $(this).data('ket');
            $('#ket-verif-str').text(keterangan);
        });

        //View Modal ADD Bukti Verifikasi Ijazah
        $('table').on('click','#add-bukti-str', function(e){
            e.preventDefault();
            var str = $(this).data('id');
            $('#id-str-bukti').val(str);
            
        });

        $('#modal-add-bukti-str').on('hidden.bs.modal', function() {
            $('#modal-add-bukti-str').find('.form-control').val("");
            $('#modal-add-bukti-str').find('.custom-file-input').val("");

            $('.alert-danger').addClass('d-none');
        });

        $('#form-tambah-bukti-str').on('submit', function(e) {
            e.preventDefault();
            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-bukti-str')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('verif.str.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_bukti_str').html("")
                        $('#error_list_bukti_str').addClass("alert alert-danger")
                        $('#error_list_bukti_str').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_bukti_str').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modal-add-bukti-str').modal('hide')
                        $('#modal-add-bukti-str').find('.form-control').val("");

                        var tbSTR = $('#tbSTR').DataTable();
                        tbSTR.ajax.reload();
                    }
                }
            });
        });

        //HAPUS Bukti Verifikasi STR
        $(document).on('click', '#hapus-bukti-str', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (confirm('Yakin Ingin Menghapus Bukti Verifikasi STR ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('verif.str.destroy') }}",
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
                        var tbSTR = $('#tbSTR').DataTable();
                        tbSTR.ajax.reload();

                    }
                });
            }
        });
    });
</script>
