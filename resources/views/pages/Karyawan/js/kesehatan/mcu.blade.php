<script>
    var idpegawai = $('.id-pegawai').val();

    $(document).ready(function() {
        $('#tb-mcu').DataTable({
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
                url: '{{ route('penilaian.mcu.get') }}',
                data: {
                    'id_pegawai': idpegawai,
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'no_rawat',
                    name: 'no_rawat'
                },
                {
                    data: 'no_rkm_medis',
                    name: 'no_rkm_medis'
                },
                {
                    data: 'nm_pasien',
                    name: 'nm_pasien'
                },
                {
                    data: function(data, row, type) {
                        if (data.jk === 'L') {
                            return "Laki-Laki";
                        } else {
                            return "Perempuan";
                        }
                    }
                },
                {
                    data: 'tgl_lahir',
                    name: 'tgl_lahir'
                },
                {
                    data: 'nm_dokter',
                    name: 'nm_dokter'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
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
                                        <a class="dropdown-item" href="#" data-norw="${data.no_rawat}" title="Laboratorium" data-toggle="modal" data-target="#modalLab" id="lab-mcu">Laboratorium</a>
                                        <a class="dropdown-item" href="{{ url('/penilaian/kesehatan/mcu/${data.tgl_registrasi}/${data.no_rkm_medis}/${data.kd_poli}/${data.no_reg}') }}"  target="_blank" data-norw="${data.no_rawat}" title="Lihat Hasil" id="lihat-hasil">Lihat Hasil</a>
                                    </div>
                                </div>
                                `;
                    }
                },

            ]
        }); //End Datatable

        // $('table').on('click', '#lab-mcu', function(e) {
        //     e.preventDefault();
        //     $('#tb-lab').DataTable({
        //         destroy: true,
        //         paging: false,
        //         scrollX: false,
        //         bInfo: false,
        //         searching: false,
        //         processing: false,
        //         serverSide: true,
        //         ajax: {
        //             url: '{{ route('penilaian.mcu.periksalab') }}',
        //             data: {
        //                 'no_rawat': $(this).data('norw'),
        //             },
        //         },
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //                 orderable: false,
        //                 searchable: false
        //             },
        //             {
        //                 data: 'no_rawat',
        //                 name: 'no_rawat'
        //             },
        //             {
        //                 data: null,
        //                 render: function(data, type, row) {
        //                     return data.no_rkm_medis + ' ' + data.nm_pasien + '( ' +
        //                         data.nm_poli + ' )';
        //                 },
        //             },
        //             {
        //                 data: 'tgl_periksa',
        //                 name: 'tgl_periksa'
        //             },
        //             {
        //                 data: 'jam',
        //                 name: 'jam'
        //             },
        //             {
        //                 data: 'nm_perawatan',
        //                 name: 'nm_perawatan'
        //             },
        //             {
        //                 data: 'nm_dokter',
        //                 name: 'nm_dokter'
        //             },
        //             {
        //                 data: 'dokter_pj',
        //                 name: 'dokter_pj'
        //             },
        //             {
        //                 'data': null,
        //                 render: function(data, row, type) {
        //                     return `
        //                         <a href="#" class="btn btn-primary btn-icon-split btn-sm" id="hasil-lab" title="Hasil Lab" 
        //                         data-no_rawat="${data.no_rawat}" data-tglperiksa="${data.tgl_periksa}"  data-jam="${data.jam}"
        //                         data-kdprw="${data.kd_jenis_prw}">
        //                                 <span class="icon text-white">
        //                                     <i class="fas fa-print fa-xs"></i>
        //                                 </span>
        //                         </a>
        //                         `;
        //                 }
        //             },

        //         ]
        //     }); //End Datatable

        // });

        $('table').on('click', '#lab-mcu', function(e) {
            e.preventDefault();
            $('#tb-lab').DataTable({
                destroy: true,
                paging: false,
                scrollX: false,
                bInfo: false,
                searching: false,
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('penilaian.mcu.periksalab') }}',
                    data: {
                        'no_rawat': $(this).data('norw'),
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_rawat',
                        name: 'no_rawat'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return data.no_rkm_medis + ' ' + data.nm_pasien + '( ' +
                                data.nm_poli + ' )';
                        },
                    },
                    {
                        data: 'tgl_periksa',
                        name: 'tgl_periksa'
                    },
                    {
                        data: 'jam',
                        name: 'jam'
                    },
                    {
                        data: 'nm_perawatan',
                        name: 'nm_perawatan'
                    },
                    {
                        data: 'nm_dokter',
                        name: 'nm_dokter'
                    },
                    {
                        data: 'dokter_pj',
                        name: 'dokter_pj'
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                <a href="{{ url('/penilaian/kesehatan/mcu/laborat/${data.no_rkm_medis}/${data.kd_poli}/${data.tgl_registrasi}/${data.no_reg}/${data.kd_jenis_prw}') }}" target="_blank" class="btn btn-primary btn-icon-split btn-sm" title="Hasil Lab">
                                        <span class="icon text-white">
                                            <i class="fas fa-print fa-xs"></i>
                                        </span>
                                </a>
                                `;
                        }
                    },

                ]
            }); //End Datatable

        });

    }); //End Jquery Document Ready
</script>
