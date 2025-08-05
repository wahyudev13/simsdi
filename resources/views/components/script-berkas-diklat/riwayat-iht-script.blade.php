@props([
    'tableId' => 'tb-riwayat-iht',
    'getRoute' => 'karywan.diklat.iht.get',
])

<script>
    $(document).ready(function() {
        let tbIht = null;
        const baseUrl = '{{ url('/') }}';
        const idpegawai = $('.id-pegawai').val();

        function initIhtTable(from_date = '', to_date = '') {
            if (tbIht) return;
            console.log('tes');

            tbIht = $('#{{ $tableId }}').DataTable({
                paging: false,
                scrollX: false,
                bInfo: false,
                processing: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Memuat data...'
                },
                serverSide: true,
                ajax: {
                    url: '{{ route($getRoute) }}',
                    data: {
                        'id': idpegawai,
                        'from_date': from_date,
                        'to_date': to_date,
                    },
                },
                dom: 'Blfrtip',
                lengthMenu: [
                    [4, 25, 50, -1],
                    ['4 Filas', '25 Filas', '50 Filas', 'Mostrar todo']
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        customize: (xlsx, config, dataTable) => {
                            let sheet = xlsx.xl.worksheets['sheet1.xml'];
                            let footerIndex = $('sheetData row', sheet).length;
                            let $footerRows = $('tr', dataTable.footer());

                            // If there are more than one footer rows
                            if ($footerRows.length > 1) {
                                // First header row is already present, so we start from the second row (i = 1)
                                for (let i = 1; i < $footerRows.length; i++) {
                                    // Get the current footer row
                                    let $footerRow = $footerRows[i];

                                    // Get footer row columns
                                    let $footerRowCols = $('th', $footerRow);

                                    // Increment the last row index
                                    footerIndex++;

                                    // Create the new header row XML using footerIndex and append it at sheetData
                                    $('sheetData', sheet).append(`
                                        <row r="${footerIndex}">
                                        ${$footerRowCols.map((index, el) => `
                                                                                                                            <c t="inlineStr" r="${String.fromCharCode(65 + index)}${footerIndex}" s="2">
                                                                                                                            <is>
                                                                                                                                <t xml:space="preserve">${$(el).text()}</t>
                                                                                                                            </is>
                                                                                                                            </c>
                                                                                                                        `).get().join('')}
                                        </row>
                                    `);
                                }
                            }
                        }
                    },
                    'pageLength',

                ],
                "drawCallback": function() {
                    var api = this.api();
                    var poin = api.column(7, {
                        page: 'current'
                    }).data().sum();
                    $('.poin').text(poin);

                    // var poin = total / 4;
                    // $('.poin').text(poin);

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_pegawai',
                        name: 'nama_pegawai'
                    },
                    {
                        data: 'nama_dep',
                        name: 'nama_dep'
                    },
                    {
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'tempat',
                        name: 'tempat'
                    },
                    {
                        data: 'masuk_at',
                        name: 'masuk_at'
                    },
                    {
                        data: 'selesai_at',
                        name: 'selesai_at'
                    },
                    // {
                    //     data: 'total_waktu',
                    //     name: 'total_waktu'
                    // },
                    {
                        data: 'poin',
                        name: 'poin'
                    },
                    // {
                    //     'data': null,
                    //     render: function(data, row, type) {
                    //         return `<a href="#" data-id="${data.id}"  data-idpegawai="${data.id_pegawai}"class="btn btn-danger btn-icon-split btn-sm"
                    //                 id="hapus-absen" title="Hapus Absen">
                    //                     <span class="icon text-white">
                    //                         <i class="fas fa-trash fa-xs"></i>
                    //                     </span>
                    //                 </a>

                    //                 `;
                    //     }
                    // },

                ]
            });

        }

        document.addEventListener('loadTabData', function(e) {
            if (e.detail.tabId === '#inhouse') {
                initIhtTable(from_date = '', to_date = '');
            }
        });

        $('#filter').click(function(e) {
            e.preventDefault();

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {

                $('#tb-pelatihan').DataTable().destroy();
                initIhtTable(from_date, to_date);
            } else {
                alert('Isi Tanggal Terlebih Dahulu')
            }


        });

        $('#refresh').click(function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#tb-pelatihan').DataTable().destroy();
            initIhtTable();
        });
    });
</script>
