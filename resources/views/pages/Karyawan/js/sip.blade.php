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
                    data: function(data, row, type) {
                        if (data.id_masa_berlaku === null) {
                            return `
                            <a class="badge badge-danger" href="#" data-id="${data.id}" title="Tambah Masa Berlaku SIP" data-toggle="modal" data-target="#modal-add-masa-berlaku" id="add-masa-berlaku">
                               <i class="fas fa-times"></i> Belum ada masa berlaku
                            </a>
                            `
                        } else {
                            if (data.status_sip === 'nonactive') {
                                return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-danger"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed_sip}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>

                                <br>
                                <br>
                                <a class="badge badge-danger" href="#" data-id="${data.id_masa_berlaku}" title="Hapus" id="hapus-masa-berlaku">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                `;
                            } else if (data.status_sip === 'proses') {
                                return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed_sip}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Akan Berakhir (Ingatkan)</small>
                                <br>
                                <br>
                                <a class="badge badge-danger" href="#" data-id="${data.id_masa_berlaku}" title="Hapus" id="hapus-masa-berlaku">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                `;
                            } else if (data.status_sip === 'changed') {
                                return `
                                <span class="badge badge-secondary"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-secondary"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed_sip}</span><br>
                                <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                <br>
                                <br>
                                <a class="badge badge-danger" href="#" data-id="${data.id_masa_berlaku}" title="Hapus" id="hapus-masa-berlaku">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                
                                `;
                            } else if (data.status_sip === 'lifetime') {
                                return `
                            <span class="badge badge-success">SIP Seumur Hidup</span>
                                `;
                            } else {
                                return `
                                <span class="badge badge-success"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed_sip}</span>
                                <br>
                                <br>
                                <a class="badge badge-danger" href="#" data-id="${data.id_masa_berlaku}" title="Hapus" id="hapus-masa-berlaku">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                `;
                            }
                        }
                    }
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    // {{ asset('/Pegawai/Dokumen/STR/${data.file}') }}
                    data: null,
                    render: function(data, row, type) {

                        if (data.id_masa_berlaku == null) {
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
                        } else {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm dropdown-toggle" title="Set Status Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item set-status-sip" href="#"  data-id="${data.id_masa_berlaku}" data-status="active" data-nosip="${data.no_sip}" id="activesip"  title="Aktif">Aktif</a>
                                        <a class="dropdown-item set-status-sip" href="#"  data-id="${data.id_masa_berlaku}" data-status="proses" data-nosip="${data.no_sip}" id="prosessip"  title="Ingatkan">Ingatkan</a>
                                        <a class="dropdown-item set-status-sip" href="#"  data-id="${data.id_masa_berlaku}" data-status="nonactive" data-nosip="${data.no_sip}" id="nonactivesip"  title="Berakhir">Berakhir</a>
                                        <a class="dropdown-item set-status-sip" href="#"  data-id="${data.id_masa_berlaku}" data-status="changed" data-nosip="${data.no_sip}" id="changedsip"  title="Diperbaharui">Diperbaharui</a>
                                    </div>
                                </div>
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

                    }
                },

            ]
        });

        $('table').on('click', '#add-masa-berlaku', function(e) {
            e.preventDefault();
            var sip = $(this).data('id');
            $('#sip_id_masa_berlaku').val(sip);

        });

        $('#form-masa-berlaku-sip').on('submit', function(e) {
            e.preventDefault();
            // var file = $('.file').val();
            // var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-masa-berlaku-sip')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.sip.exp') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_berlaku_sip').html("")
                        $('#error_list_berlaku_sip').addClass("alert alert-danger")
                        $('#error_list_berlaku_sip').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_berlaku_sip').append('<li>' +
                                error_value +
                                '</li>');
                        });
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modal-add-masa-berlaku').modal('hide')
                        $('#modal-add-masa-berlaku').find('.form-control').val("");

                        var tbSIP = $('#tbSIP').DataTable();
                        tbSIP.ajax.reload();
                    }
                }
            });
        });

        $('#modal-add-masa-berlaku').on('hidden.bs.modal', function() {
            $('#modal-add-masa-berlaku').find('.form-control').val("");
            $('#modal-add-masa-berlaku').find('.custom-file-input').val("");
            $('.alert-danger').addClass('d-none');
        });

        //VIEW Berkas SIP
        $(document).on('click', '#view-sip', function(e) {
            e.preventDefault();
            var fileSIP = $(this).data('id');
            var url = '{{ route('login.index') }}';
            PDFObject.embed(url + '/File/Pegawai/Dokumen/SIP/' + fileSIP, "#view-sip-modal");
        });

        //SIMPAN SIP
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
                beforeSend:function(){
                       $('#add_sip').addClass("d-none");
                       $('#add_sip_disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_sip').html("")
                        $('#error_list_sip').addClass("alert alert-danger")
                        $('#error_list_sip').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_sip').append('<li>' + error_value +
                                '</li>');
                        });

                        $('#add_sip').removeClass("d-none");
                        $('#add_sip_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaladdSIP').modal('hide')
                        $('#modaladdSIP').find('.form-control').val("");
                        
                        $('#add_sip').removeClass("d-none");
                        $('#add_sip_disabled').addClass("d-none");
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
                        url: "{{ route('selected.str.get') }}",
                        data: function(params) {
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

    //HAPUS MASA BERLAKU SIP
    $(document).on('click', '#hapus-masa-berlaku', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm('Yakin Ingin Menghapus Bukti Verifikasi STR ?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.sip.desexp') }}",
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

    //UPDATE STATUS SIP
    $(document).on('click', '.set-status-sip', function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('berkas.sip.status') }}",
            data: {
                'id': $(this).data('id'),
                'status': $(this).data('status'),
                'nosip': $(this).data('nosip'),
            },
            dataType: "json",
            success: function(response) {
                $('#success_message').html("")
                $('#success_message').removeClass("alert-warning")
                $('#success_message').removeClass("alert-success")
                $('#success_message').addClass("alert alert-primary")
                $('#success_message').text(response.message)

                var tbSIP = $('#tbSIP').DataTable();
                tbSIP.ajax.reload();
            }
        });

    });
</script>
