@extends('layouts.app')
@section('title', 'Data Karyawan')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Karyawan</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">

                <div class="col-lg-6">
                    <select class="form-select select2 selectdep" id="single-select-field" data-placeholder="Pilih Departemen">
                        @foreach ($deparetemen as $item)
                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6">
                    <button type="button" class="btn btn-outline-primary reset-dep" id="reset-dep"><i
                            class="fas fa-window-close"></i></button>
                </div>
            </div>



        </div>
        <div class="card-body">
            @if (auth()->user()->can('Peringatan') || auth()->user()->can('Pegawai Admin'))
                @if ($alert_pengingat || $alert_exp || $peringatan_sip || $peringatan_nonaktif_sip > 0)
                    <div class="alert alert-danger" role="alert">
                        @if ($alert_exp > 0)
                            <li style="list-style-type:none;">
                                <i class="fa fa-spin fa-cog"></i>
                                <a href="{{ route('pengingat.str.index') }}" class="alert-link">{{ $alert_exp }} Karyawan
                                    yang Dokumen STR Berakhir.</a>
                            </li>
                        @endif
                        @if ($alert_pengingat > 0)
                            <li style="list-style-type:none;">
                                <i class="fa fa-spin fa-cog"></i>
                                <a href="{{ route('pengingat.str.index') }}" class="alert-link">{{ $alert_pengingat }}
                                    Karyawan
                                    yang Dokumen STR Dalam Masa Ingatkan.</a>
                            </li>
                        @endif
                        @if ($peringatan_sip > 0)
                            <li style="list-style-type:none;">
                                <i class="fa fa-spin fa-cog"></i>
                                <a href="{{ route('pengingat.sip.pengingatSip') }}" class="alert-link">{{ $peringatan_sip }}
                                    Karyawan
                                    yang Dokumen SIP Dalam Masa Ingatkan.</a>
                            </li>
                        @endif
                        @if ($peringatan_nonaktif_sip > 0)
                            <li style="list-style-type:none;">
                                <i class="fa fa-spin fa-cog"></i>
                                <a href="{{ route('pengingat.sip.pengingatSip') }}"
                                    class="alert-link">{{ $peringatan_nonaktif_sip }} Karyawan
                                    yang Dokumen SIP Berakhir.</a>
                            </li>
                        @endif
                    </div>
                @endif

                @if ($peringatan_kontrak_kerja || $peringatan_nonaktif_kontrak_kerja > 0)
                    <div class="alert alert-warning" role="alert">
                        @if ($peringatan_nonaktif_kontrak_kerja > 0)
                            <li style="list-style-type:none;">
                                <i class="fa fa-spin fa-cog"></i>
                                <a href="{{ route('pengingat.kontrak.pengingatKontrak') }}"
                                    class="alert-link">{{ $peringatan_nonaktif_kontrak_kerja }} Kontrak Kerja Karyawan
                                    Berakhir.</a>
                            </li>
                        @endif
                        @if ($peringatan_kontrak_kerja > 0)
                            <li style="list-style-type:none;">
                                <i class="fa fa-spin fa-cog"></i>
                                <a href="{{ route('pengingat.kontrak.pengingatKontrak') }}"
                                    class="alert-link">{{ $peringatan_kontrak_kerja }} Kontrak Kerja Karyawan Akan Berakhir
                                    (Ingatkan).</a>
                            </li>
                        @endif
                    </div>
                @endif
            @endif
            <div class="table-responsive">
                <table class="table table-bordered " id="tbJenjang" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            {{-- <th>Dokumen</th> --}}
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
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/popper.js') }}"></script>
    <!-- Page level custom scripts -->
    <script>
        $('#single-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),

        });
    </script>
    <script>
        $(document).ready(function() {
            var tbpegawai = $('#tbJenjang').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('karyawan.getPegawai') }}',
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
                        data: 'jk',
                        name: 'jk'
                    },
                    {
                        data: 'nama_dep',
                        name: 'nama_dep'
                    },
                    {
                        data: 'jbtn',
                        name: 'jbtn'
                    },
                    // {
                    //     data: function(data, row, type) {
                    //         if (data.nama_berkas === null || data.nama_berkas_kontrak === null) {
                    //             return `<span class="badge badge-info">Tidak ada Dokumen</span>`;
                    //         } else {

                    //             // if (data.status === 'active' && data.status_kontrak === 'active') {
                    //             //     return `
                //             //         <a href="/karyawan/berkas/${data.id}" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas}</a>
                //             //         <a href="/karyawan/berkas/${data.id}" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas_kontrak}</a>
                //             //     `;
                    //             // }else if (data.status === 'active' && data.status_kontrak === 'proses' || data.status_kontrak === 'nonactive') {
                    //             //     return `
                //             //         <a href="/karyawan/berkas/${data.id}" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas}</a>
                //             //         <a href="/karyawan/berkas/${data.id}" class="btn btn-outline-danger btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas_kontrak}</a>
                //             //     `;
                    //             // }

                    //             // else if(data.status === 'proses' || data.status === 'nonactive') {
                    //             //     return `<a  href="/karyawan/berkas/${data.id}" class="btn btn-outline-danger btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas}</a>`;
                    //             // }else if(data.status_kontrak === 'active'){
                    //             //     return `<a href="/karyawan/berkas/${data.id}" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas_kontrak}</a>`;
                    //             // }else if(data.status_kontrak === 'proses' || data.status_kontrak === 'nonactive') {
                    //             //     return `<a  href="/karyawan/berkas/${data.id}" class="btn btn-outline-danger btn-sm"> <i class="fas fa-solid fa-file-word"></i> ${data.nama_berkas_kontrak}</a>`;
                    //             // }
                    //         }

                    //     }
                    // },
                    {
                        'data': null,
                        render: function(data, row, type) {
                            return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (auth()->user()->can('Detail Karyawan') || auth()->user()->can('Pegawai Admin'))
                                            <a class="dropdown-item" href="karyawan/detail/get/${data.id}">Detail</a>
                                        @endif
                                        @if (auth()->user()->can('Dokumen Karyawan') || auth()->user()->can('Pegawai Admin'))
                                            <a class="dropdown-item" href="karyawan/berkas/kepeg/${data.id}">Dokumen Kepegawaian</a>
                                        @endif
                                        @if (auth()->user()->can('Penilaian Kerja') || auth()->user()->can('Pegawai Admin'))
                                            <a class="dropdown-item" href="karyawan/berkas/penilaian/${data.id}">Penilaian Kerja</a>
                                        @endif
                                        @if (auth()->user()->can('Dokumen K3') || auth()->user()->can('Pegawai Admin'))
                                            <a class="dropdown-item" href="karyawan/berkas/kesehatan/${data.id}">Dokumen K3</a>
                                        @endif
                                        @if (auth()->user()->can('Dokumen Diklat') || auth()->user()->can('Pegawai Admin'))
                                            <a class="dropdown-item" href="karyawan/berkas/diklat/${data.id}">Dokumen Diklat</a>
                                        @endif
                                      
                                    </div>
                                </div>

                            `;
                        }
                    },

                ]
            });

            $('.selectdep').change(function(e) {
                e.preventDefault();
                tbpegawai
                    .columns(4)
                    .search(this.value)
                    .draw();
            });

            $('.reset-dep').click(function(e) {
                e.preventDefault();
                $('#tbJenjang').DataTable().search('').columns().search('').draw();
                $('.selectdep').val(null).trigger('change');
            });
        });
    </script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush

@push('custom-css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">
@endpush
