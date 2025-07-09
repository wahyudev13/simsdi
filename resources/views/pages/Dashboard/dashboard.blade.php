@extends('layouts.app')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('body')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">
        @if (auth()->user()->can('Dokumen Karyawan') || auth()->user()->can('Pegawai Admin'))
            <!-- Karyawan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Karyawan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_pegawai }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->can('Dokumen Diklat') || auth()->user()->can('Pegawai Admin'))
            <!-- Kegiatan Diklat -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kegiatan Diklat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_kegiatan }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->can('Pegawai Admin'))
            <!-- Maping RM -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Maping Rekam Medis</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_maping }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-people-arrows fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->can('Peringatan') || auth()->user()->can('Pegawai Admin'))
            <!-- Peringatan STR -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Peringatan STR</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_str_admin }}</div>
                            </div>
                            <div class="col-auto">

                                <i class="fas fa-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Peringatan Kontrak -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Peringatan Kontrak Kerja</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_kontrak }}</div>
                            </div>
                            <div class="col-auto">

                                <i class="fas fa-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (auth()->user()->can('Pengguna'))
            <!-- Ijazah -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Ijazah</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_ijazah }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ijazah -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Transkrip</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_trans }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STR -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    STR</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_str }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SIP -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    SIP</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_sip }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-medical-alt fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Riwayat Kerja -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Riwayat Kerja</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_riwayat }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-contract fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tes Kesehatan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Tes Kesehatan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_kes }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-medical-alt fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vaksinasi Kesehatan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Vaksinasi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_vaksin }}</div>
                            </div>
                            <div class="col-auto">

                                <i class="fas fa-syringe fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kesehatan Berkala -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Kesehatan Berkala</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_mcu }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-x-ray fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sertifikat Pelatihan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Sertifikat Pelatihan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_sertif }}</div>
                            </div>
                            <div class="col-auto">

                                <i class="fas fa-file-archive fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kegiatan Diklat IHT -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Kegiatan Diklat IHT</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_absensi_iht }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    @if (auth()->user()->can('Dokumen Karyawan') || auth()->user()->can('Pegawai Admin'))
        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">

                <!-- Bar Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Chart Departemen Karyawan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <input type="hidden" id="value-max" value="{{ $chart_value_max }}">
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Bar Chart Example
        const value_max = $('#value-max').val();
        const max_value = Number(value_max);

        console.log(value_max);
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($chart_pegawai as $item)
                        '{{ $item->nama }}',
                    @endforeach
                ],
                datasets: [{
                    label: "Karyawan",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    borderWidth: 1,
                    data: [
                        @foreach ($chart_pegawai as $item)
                            '{{ $item->dep_count }}',
                        @endforeach
                    ],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: max_value,
                            // maxTicksLimit: 5,
                            // padding: 10,
                        },
                    }]
                },
                // scales: {
                //     xAxes: [{
                //         time: {
                //             unit: 'month'
                //         },
                //         gridLines: {
                //             display: false,
                //             drawBorder: false
                //         },
                //         ticks: {
                //             maxTicksLimit: 6
                //         },
                //         maxBarThickness: 25,
                //     }],
                //     yAxes: [{
                //         ticks: {
                //             min: 0,
                //             max: 20,
                //             maxTicksLimit: 5,
                //             padding: 10,
                //             // Include a dollar sign in the ticks
                //             // callback: function(value, index, values) {
                //             //     return '$' + number_format(value);
                //             // }
                //         },
                //         gridLines: {
                //             color: "rgb(234, 236, 244)",
                //             zeroLineColor: "rgb(234, 236, 244)",
                //             drawBorder: false,
                //             borderDash: [2],
                //             zeroLineBorderDash: [2]
                //         }
                //     }],
                // },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
            }
        });
    </script>
@endpush
