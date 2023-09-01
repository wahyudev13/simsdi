@extends('layouts.app')
@section('title', 'Riwayat Pelatihan IHT')
@section('user-main5', 'active')
@section('user-main6', 'show')
@section('user-pelatihan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Riwayat Pelatihan IHT</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow">
        {{-- <div class="card-header py-3">
        </div> --}}
        <div class="card-body">
            <div class="container-fluid">
                {{-- <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}"> --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="tb-pelatihan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Karyawan</th>
                                <th>Unit</th>
                                <th>Kegiatan</th>
                                <th>Tempat</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Total Waktu (jam)</th>
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
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!--Button Dattable-->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>
    <script>
        $(document).ready(function() {
            var idpegawai = $('.id-pegawai').val();
            $('#tb-pelatihan').DataTable({
               processing: false,
               serverSide: true,
               ajax: '{{route('pengguna.pelatihan.absen')}}',
               dom: 'Bfrtip',
               buttons: [
                   'copy','excel', 'pdf', 'print'
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
        });
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endpush
