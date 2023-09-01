@extends('layouts.app')
@section('title', 'Medical Check Up')
@section('user-main3', 'active')
@section('user-main4', 'show')
@section('user-mcu', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Medical Check Up</h1>

    <!-- DataTales Example -->
    {{-- <div id="success_message"></div>
    <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">

        </div> --}}
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tb-mcu-user" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Rawat</th>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>JK</th>
                                <th>Tgl Lahir</th>
                                <th>Dokter PJ</th>
                                <th>Tgl Asuhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>

    <!-- Modal Lab -->
    <div class="modal fade bd-example-modal-xl" id="modalLab" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Pemeriksaan Laboratorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tb-lab" width="100%" cellspacing="0"
                            style="font-size: 10px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width: 12%">No Rawat</th>
                                    {{-- <th>No RM</th> --}}
                                    <th>Nama Pasien</th>
                                    <th>Tgl Periksa</th>
                                    <th>Jam Periksa</th>
                                    <th>Pemeriksaan</th>
                                    <th>Dokter Perujuk</th>
                                    <th>Dokter PJ</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var idpegawai = $('#id-pegawai').val();
            $('#tb-mcu-user').DataTable({
                paging: true,
                scrollX: false,
                bInfo: true,
                searching: true,
                processing: false,
                serverSide: true,
                ajax: '{{route('pengguna.getMCU')}}',
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
                                        <a class="dropdown-item" href="{{url('/penilaian/kesehatan/mcu/${data.tgl_registrasi}/${data.no_rkm_medis}/${data.kd_poli}/${data.no_reg}')}}"  target="_blank" data-norw="${data.no_rawat}" title="Lihat Hasil" id="lihat-hasil">Lihat Hasil</a>
                                    </div>
                                </div>
                                `;
                        }
                    },

                ]
            }); //End Datatable

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
                                <a href="{{url('/penilaian/kesehatan/mcu/laborat/${data.no_rkm_medis}/${data.kd_poli}/${data.tgl_registrasi}/${data.no_reg}/${data.kd_jenis_prw}')}}" target="_blank" class="btn btn-primary btn-icon-split btn-sm" title="Hasil Lab">
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
            
        });
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
