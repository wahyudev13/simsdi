@extends('layouts.app')
@section('title', 'Berkas Kesehatan')
@section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Berkas Kesehatan</h1>


    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <div class="card border-left-primary mb-4 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $pegawai->jbtn }} / {{ $pegawai->nama_dep }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pegawai->nama }} ({{ $pegawai->nik }})
                            </div>
                            <input type="hidden" class="id-pegawai" value="{{ $pegawai->id }}">
                            <input type="hidden" class="nik-pegawai" value="{{ $pegawai->nik }}">
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-solid fa-upload fa-2x text-gray-300"></i> --}}
                            <i class="fas fa-user-shield fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="awal-tab" data-toggle="tab" data-target="#awal" type="button"
                        role="tab" aria-controls="awal" aria-selected="true">Test Kesehatan</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="berkala-tab" data-toggle="tab" data-target="#berkala" type="button"
                        role="tab" aria-controls="berkala" aria-selected="false">Test Kesehatan Berkala</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="riwayat-tab" data-toggle="tab" data-target="#riwayat" type="button"
                        role="tab" aria-controls="riwayat" aria-selected="false">Test Kesehatan Khusus</button>
                </li> --}}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vaksin-tab" data-toggle="tab" data-target="#vaksin" type="button"
                        role="tab" aria-controls="vaksin" aria-selected="false">Vaksinasi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mcu-tab" data-toggle="tab" data-target="#mcu" type="button"
                        role="tab" aria-controls="mcu" aria-selected="false">Tes Kesehatan Berkala</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="awal" role="tabpanel" aria-labelledby="awal-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdAwal">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Tes Kesehatan</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-lain" id="tbkesAwal" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                {{-- <div class="tab-pane fade" id="berkala" role="tabpanel" aria-labelledby="berkala-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdAwal">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Tes Kesehatan Awal</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-lain" id="tbkesAwal" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Nama Pemeriksaan</th>
                                 
                                    <th>Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                    
                </div> --}}
                <div class="tab-pane fade" id="vaksin" role="tabpanel" aria-labelledby="vaksin-tab">
                    <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdVaksin">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Vaksin</span>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered berkas-lain" id="tbVaksin" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>Nama File</th> --}}
                                    <th>Dosis Vaksin</th>
                                    <th>Jenis Vaksin</th>
                                    <th>Tanggal Vaksin</th>
                                    <th>Tempat Vaksin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="mcu" role="tabpanel" aria-labelledby="mcu-tab">
                    {{-- <div class="button-add mb-4 mt-4">
                        <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                            data-target="#modaladdVaksin">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Tambah Vaksin</span>
                        </a>
                    </div> --}}

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered" id="tb-mcu" width="100%" cellspacing="0"
                            style="font-size: 12px">
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
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal ADD Kesehatan Awal -->
    <div class="modal fade" id="modaladdAwal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Kesehatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list"></div>
                    <form method="POST" id="form-add-kesehatan-awal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        <div class="form-group">
                            <label for="nama_file" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file" id="nama_file" name="nama_file">
                                <option value="" selected>Choose...</option>
                                @foreach ($berkas_kesehatan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemeriksaan" class="col-form-label">Nama Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nama_pemeriksaan" id="nama_pemeriksaan"
                                name="nama_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_pemeriksaan" class="col-form-label">Tanggal Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_pemeriksaan" id="tgl_pemeriksaan"
                                name="tgl_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_awal">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal Edit Kesehatan -->
    <div class="modal fade" id="modaleditAwal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Kesehatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_edit"></div>
                    <form method="POST" id="form-edit-kesehatan-awal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai_edit" id="id_pegawai_edit" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        <input type="hidden" class="id_kesehatan_awal" id="id_kesehatan_awal" name="id">
                        <div class="form-group">
                            <label for="nama_file_edit" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_edit" id="nama_file_edit" name="nama_file">
                                <option value="">Choose...</option>
                                @foreach ($berkas_kesehatan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemeriksaan_edit" class="col-form-label">Nama Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control nama_pemeriksaan_edit" id="nama_pemeriksaan_edit"
                                name="nama_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_pemeriksaan_edit" class="col-form-label">Tanggal Pemeriksaan <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_pemeriksaan_edit" id="tgl_pemeriksaan_edit"
                                name="tgl_pemeriksaan">
                        </div>
                        <div class="form-group">
                            <label for="file_edit" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="edit_awal">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal ADD Vaksin -->
    <div class="modal fade" id="modaladdVaksin" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Vaksin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_vaksin"></div>
                    <form method="POST" id="form-add-vaksin" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_vaksin" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <div class="form-group">
                         <label for="nama_file_vaksin" class="col-form-label">Nama Dokumen <label class="text-danger">*</label></label>
                         <select class="custom-select nama_file_vaksin" id="nama_file_vaksin" name="nama_file">
                             <option value="" selected>Choose...</option>
                             @foreach ($berkas_kesehatan as $item)
                                 <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                             @endforeach
                         </select>
                     </div> --}}
                        <div class="form-group">
                            <label for="dosis" class="col-form-label">Dosis <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control dosis" id="dosis" name="dosis">
                        </div>
                        <div class="form-group">
                            <label for="jenis_vaksin" class="col-form-label">Jenis Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control jenis_vaksin" id="jenis_vaksin"
                                name="jenis_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tgl_vaksin" class="col-form-label">Tanggal Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_vaksin" id="tgl_vaksin" name="tgl_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tempat_vaksin" class="col-form-label">Tempat Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control tempat_vaksin" id="tempat_vaksin"
                                name="tempat_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="file_vaksin" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_vaksin" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_vaksin">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal EDIT Vaksin -->
    <div class="modal fade" id="modaleditVaksin" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Vaksin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_vaksin_edit"></div>
                    <form method="POST" id="form-edit-vaksin" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai" id="id_pegawai_vaksin_edit"
                            value="{{ $pegawai->id }}" name="id_pegawai">
                        <input type="hidden" class="id_vaksin_edit" id="id_vaksin_edit" name="id">
                        {{-- <div class="form-group">
                         <label for="nama_file_vaksin_edit" class="col-form-label">Nama Dokumen <label class="text-danger">*</label></label>
                         <select class="custom-select nama_file_vaksin_edit" id="nama_file_vaksin_edit" name="nama_file">
                             <option value="" selected>Choose...</option>
                             @foreach ($berkas_kesehatan as $item)
                                 <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                             @endforeach
                         </select>
                     </div> --}}
                        <div class="form-group">
                            <label for="dosis_edit" class="col-form-label">Dosis <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control dosis_edit" id="dosis_edit" name="dosis">
                        </div>
                        <div class="form-group">
                            <label for="jenis_vaksin_edit" class="col-form-label">Jenis Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control jenis_vaksin_edit" id="jenis_vaksin_edit"
                                name="jenis_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tgl_vaksin_edit" class="col-form-label">Tanggal Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_vaksin" id="tgl_vaksin_edit"
                                name="tgl_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="tempat_vaksin_edit" class="col-form-label">Tempat Vaksin <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control tempat_vaksin_edit" id="tempat_vaksin_edit"
                                name="tempat_vaksin">
                        </div>
                        <div class="form-group">
                            <label for="file_vaksin_edit" class="col-form-label">File
                                <span class="badge badge-secondary">.pdf</span> <label
                                    class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_vaksin_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add_vaksin">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View PDF -->
    <div class="modal fade " id="modalKesehatanAwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kesehatan Awal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-kesehatan-awal-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View PDF -->
    <div class="modal fade " id="modalviewVaksin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dokumen Vaksin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-vaksin-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View PDF -->
    <div class="modal fade bd-example-modal-xl" id="modalDetailMCU" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Medical Check Up</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-detail-mcu"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

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
    <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <!--Kesehatan ------------------->
    @include('pages.Karyawan.js.kesehatan.awal')

    <!--Vaksin ------------------->
    @include('pages.Karyawan.js.kesehatan.vaksin')

    <!--MCU ------------------->
    @include('pages.Karyawan.js.kesehatan.mcu')
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
