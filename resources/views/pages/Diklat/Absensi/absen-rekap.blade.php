@extends('layouts.app')
@section('title', 'Rekab Absensi Kegiatan')
@section('diklat-main1', 'active')
@section('diklat-main2', 'show')
@section('diklat-kegiatan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rekab Absensi Kegiatan {{ $kegiatan2->nama }}</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div id="error_list"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <input type="hidden" class="id-kegiatan" id="id-kegiatan" value="{{ $kegiatan2->id }}">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-absen-rekab" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Unit</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Total Waktu (jam)</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
@push('custom-scripts')
    <!--Button Dattable-->
    <script src="{{ asset('/vendor/datatables/button/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/vendor/datatables/button/js/buttons.print.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tb-absen-rekab').DataTable({

                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('absensi.diklat.masuk.get') }}',
                    data: {
                        'kegiatan_id': $('#id-kegiatan').val(),
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
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

            $(document).on('click', '#hapus-absen', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus data ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('absensi.diklat.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                            'id_kegiatan': $('#id-kegiatan').val(),
                            'id_pegawai': $(this).data('idpegawai'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            $('#tb-absen-manual').DataTable().ajax.reload();

                        }
                    });
                }
            });

        });
    </script>
@endpush

@push('custom-css')
    <link href="{{ asset('/vendor/datatables/button/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush
