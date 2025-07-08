@extends('layouts.app')
@section('title', 'Pengingat Kontrak Kerja')
@section('pengingat1', 'active')
@section('pengingat2', 'show')
@section('pengingat-kontrak', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Pengingat Kontrak Kerja</h1>
    <p class="mb-4">Kontrak Kerja Karyawan yang Sudah Mendekati Berakhir</p>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modalBerkas">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Master Berkas</span>
            </a>
        </div> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="pengingat-kontrak" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Nomor</th>
                            <th>Tgl Berakhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection
@push('custom-scripts')
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#pengingat-kontrak').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengingat.kontrak.get') }}',
                "createdRow": function(row, data, dataIndex) {
                    if (data.status == `nonactive`) {
                        $(row).addClass('bg-danger text-white font-weight-bold');
                    } else if (data.status == "proses") {
                        $(row).addClass('table-warning');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jbtn',
                        name: 'jbtn'
                    },
                    {
                        data: 'nomor',
                        name: 'nomor'
                    },
                    {
                        data: 'tgl_ed',
                        name: 'tgl_ed'
                    },
                    {
                        data: function(data, row, type) {
                            if (data.status === 'nonactive') {
                                return "Masa Berlaku Sudah Berakhir";
                            } else {
                                return "Masa Berlaku Akan Berakhir";
                            }
                        }
                    },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                    @if (auth()->user()->can('Dokumen Karyawan') || auth()->user()->can('Pegawai Admin'))
                                        <a href="{{ url('karyawan/berkas/kepeg/${data.id_pegawai}') }}" target="_blank" class="btn btn-primary btn-icon-split btn-sm detail-kontrak" id="detail-kontrak">
                                            <span class="icon text-white">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </span>
                                        </a>
                                    @endif
                                    `;
                        }
                    },

                ]
            });


        });
    </script>
@endpush
