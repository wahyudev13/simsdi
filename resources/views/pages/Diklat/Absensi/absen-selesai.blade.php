@extends('layouts.app')
@section('title', 'Absensi Selesai Kegiatan Diklat')
@section('diklat-main1', 'active')
@section('diklat-main2', 'show')
@section('diklat-kegiatan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Absensi Selesai Kegiatan {{ $kegiatan2->nama }}</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            <div style="width: 600px" id="reader"></div>
            <input type="hidden" class="id-kegiatan" id="id-kegiatan" value="{{ $kegiatan2->id }}">
            {{-- <input type="hidden" class="form-control nik-pegawai" id="nik-pegawai"> --}}

            {{-- <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modaladdKegiatan">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Kegiatan</span>
            </a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-absen-selesai" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Unit</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Total Waktu</th>
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
    <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/vendor/html5-qrcode/html5-qrcode.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <script>
        $(document).ready(function() {

            function onScanSuccess(decodedText, decodedResult) {
                // Handle on success condition with the decoded text or result.
                // console.log(`Scan result: ${decodedText}`, decodedResult);
                //$('#nik-pegawai').val(decodedText);

                var data = {
                    'kegiatan_id': $('#id-kegiatan').val(),
                    'nik': decodedText
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('absensi.diklat.selesai.update') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-danger")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            $('#success_message').text(response.message)

                            $('#tb-absen-selesai').DataTable().ajax.reload();
                        } else if (response.status == 401) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-danger")
                            $('#success_message').text(response.message)
                        } else if (response.status == 402) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-danger")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                        }
                    }
                });
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 5,
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tb-absen-selesai').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('absensi.diklat.masuk.get') }}',
                    data: {
                        'kegiatan_id': $('#id-kegiatan').val(),
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
                        data: 'nama_pegawai',
                        name: 'nama_pegawai'
                    },
                    {
                        data: 'nama_dep',
                        name: 'nama_dep'
                    },
                    {
                        data: 'masuk_at',
                        name: 'masuk_at'
                    },
                    {
                        data: 'selesai_at',
                        name: 'selesai_at'
                    },
                    {
                        data: 'total_waktu',
                        name: 'total_waktu'
                    },

                ]
            });
        });
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
