<script>
    $(document).ready(function() {
        var tbRiwayat = $('#tbRiwayat').DataTable({
            // ordering: false,
            paging: false,
            // scrollX: true,
            bInfo: false,
            searching: false,
            // processing: true,
            serverSide: true,
            ajax: {
                url: '{{route('berkas.riwayat.getRiwayat')}}',
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
                    data: function(data, row, type) {
                        if (data.tgl_ed === null && data.pengingat === null) {
                            return `
                                <center><span class="badge badge-danger"  title="Tidak Ada Masa Berlaku"><i class="fas fa-bell-slash"></i> Tidak Ada</span></center>
                                `;
                        }else{
                            if (data.status === 'nonactive') {
                                return `
                                <span class="badge badge-danger" title="Tgl Pengingat"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-danger"  title="Tgl Masa Berlaku"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                `;
                            }else if(data.status === 'proses'){
                                return `
                                <span class="badge badge-danger"  title="Tgl Pengingat"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info" title="Tgl Masa Berlaku"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Akan Berakhir (Ingatkan)</small>
                                `;
                            }else if(data.status === 'changed'){
                                return `
                                <span class="badge badge-secondary"  title="Tgl Pengingat"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-secondary" title="Tgl Masa Berlaku"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                `;
                            }else{
                                return `
                                <span class="badge badge-success"  title="Tgl Pengingat"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info" title="Tgl Masa Berlaku"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span>
                                
                                `;
                            }
                        }
                            
                    },
                   
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
                                    <button class="btn btn-info btn-sm dropdown-toggle" title="Set Status Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-exclamation-circle"></i>
                                     
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item set-status-riwayat" href="#"  data-id="${data.id}" data-status="active" data-naber="${data.nama_berkas}" id="active"  title="Aktif">Aktif</a>
                                        <a class="dropdown-item set-status-riwayat" href="#"  data-id="${data.id}" data-status="proses" data-naber="${data.nama_berkas}" id="proses"  title="Ingatkan">Ingatkan</a>
                                        <a class="dropdown-item set-status-riwayat" href="#"  data-id="${data.id}" data-status="nonactive" data-naber="${data.nama_berkas}" id="nonactive"  title="Berakhir">Berakhir</a>
                                        <a class="dropdown-item set-status-riwayat" href="#"  data-id="${data.id}" data-status="changed" data-naber="${data.nama_berkas}" id="changed"  title="Diperbaharui">Diperbaharui</a>
                                       
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-rw"  data-toggle="modal" data-target="#modalRiwayat">Lihat Dokumen</a>
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditRiwayat" id="edit_riwayat">Edit Dokumen</a>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_riwayat"  title="Hapus Dokumen">Hapus</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        });

        //UPDATE STATUS
        $(document).on('click', '.set-status-riwayat', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.riwayat.update.status') }}",
                data: {
                    'id': $(this).data('id'),
                    'status' : $(this).data('status'),
                    'naber' : $(this).data('naber'),
                },
                dataType: "json",
                success: function(response) {
                    $('#success_message').html("")
                    $('#success_message').removeClass("alert-warning")
                    $('#success_message').removeClass("alert-success")
                    $('#success_message').addClass("alert alert-primary")
                    $('#success_message').text(response.message)

                    var tbRiwayat = $('#tbRiwayat').DataTable();
                    tbRiwayat.ajax.reload();

                }
                });

        });

        //VIEW Berkas Riwayat Pekerjaan
        $(document).on('click', '#view-rw', function(e) {
            e.preventDefault();
            var namafile = $(this).data('id');
            var url = '{{route('login.index')}}';
            PDFObject.embed(url+'/File/Pegawai/Dokumen/RiwayatKerja/' + namafile, "#view-riwayat-modal");
        });

        $('#form-tambah-rw').on('submit', function(e) {
            e.preventDefault();
            var file = $('.file').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-tambah-rw')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('berkas.riwayat.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend:function(){
                       $('#add_lain').addClass("d-none");
                       $('#add_lain_disabled').removeClass("d-none");
                },
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list_rw').html("")
                        $('#error_list_rw').addClass("alert alert-danger")
                        $('#error_list_rw').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list_rw').append('<li>' + error_value +
                                '</li>');
                        });
                        $('#add_lain').removeClass("d-none");
                        $('#add_lain_disabled').addClass("d-none");
                    } else {
                        $('#success_message').html("")
                        $('#success_message').removeClass("alert-primary")
                        $('#success_message').removeClass("alert-warning")
                        $('#success_message').addClass("alert alert-success")
                        // $('#success_message').removeClass("d-none")
                        $('#success_message').text(response.message)
                        $('#modaladdRiwayat').modal('hide')
                        $('#modaladdRiwayat').find('.form-control').val("");
                        $('#add_lain').removeClass("d-none");
                        $('#add_lain_disabled').addClass("d-none");
                        var tbRiwayat = $('#tbRiwayat').DataTable();
                        tbRiwayat.ajax.reload();
                    }
                }
            });
        });
    });

    $('#modaladdRiwayat').on('hidden.bs.modal', function() {
        $('#modaladdRiwayat').find('.form-control').val("");
        $('#modaladdRiwayat').find('.custom-file-input').val("");

        $('.alert-danger').addClass('d-none');
    });

    //EDIT Berkas Riwayat Kerja
    $(document).on('click', '#edit_riwayat', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "{{ route('berkas.riwayat.edit') }}",
            data: {
                'id': $(this).data('id'),
            },
            dataType: "json",
            success: function(response) {
                $('#id-riwayat-edit').val(response.data.id);
                $('#id_pegawai_rw_edit').val(response.data.id_pegawai);
                //$('#nik_rw_edit').val(response.data.nik_pegawai);
                $('#nama_file_riwayat_id_edit').val(response.data.nama_file_riwayat_id);
                $('#nomor_rw_edit').val(response.data.nomor);
                $('#tgl_ed_rw_edit').val(response.data.tgl_ed);
                $('#pengingat_rw_edit').val(response.data.pengingat);
            }
        });
    });

    //UPDATE Berkas Riwayat Kerja
    $('#form-edit-riwayat').on('submit', function(e) {
        e.preventDefault();

        var data = {
            'id': $('#id-riwayat-edit').val(),
        }

        var file = $('.file').val();
        var rename = file.replace("C:\\fakepath\\", "");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#form-edit-riwayat')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ route('berkas.riwayat.update') }}",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.status == 400) {
                    $('#error_list_rw_edit').html("")
                    $('#error_list_rw_edit').addClass("alert alert-danger")
                    $('#error_list_rw_edit').removeClass("d-none")

                    $.each(response.error, function(key, error_value) {
                        $('#error_list_rw_edit').append('<li>' + error_value + '</li>');
                    });
                } else {
                    $('#success_message').html("")
                    $('#success_message').removeClass("alert-success")
                    $('#success_message').removeClass("alert-warning")
                    $('#success_message').addClass("alert alert-primary")
                    // $('#success_message').removeClass("d-none")
                    $('#success_message').text(response.message)
                    $('#modaleditRiwayat').modal('hide')
                    $('#modaleditRiwayat').find('.form-control').val("");
                    var tbRiwayat = $('#tbRiwayat').DataTable();
                    tbRiwayat.ajax.reload();


                }
            }
        });
    });

    $('#modaleditRiwayat').on('hidden.bs.modal', function() {
        // $('#modalJenjang').find('.form-control').val("");
        $('.alert-danger').addClass('d-none');
    });

    //HAPUS STR
    $(document).on('click', '#hapus_riwayat', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (confirm('Yakin Ingin Menghapus Berkas Riwayat Kerja ?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('berkas.riwayat.destroy') }}",
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
                    var tbRiwayat = $('#tbRiwayat').DataTable();
                    tbRiwayat.ajax.reload();

                }
            });
        }
    });
</script>
