@extends('layouts.app')
@section('title', 'Data Perizinan')
@section('user-main1', 'active')
@section('user-main2', 'show')
@section('user-izin', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Perizinan</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    {{-- <div id="error_list"></div> --}}
    <div class="card shadow mb-4">
        <input type="hidden" id="id-pegawai" value="{{ $pengguna->id_pegawai }}">
        <div class="card-header py-3">
            @can('user-str-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdSTR">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas STR</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-perizinan" id="tbSTR" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor REG</th>
                                <th>Bidang Kesehatan</th>
                                <th>Berlaku Sampai</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-str-view') ||
                                        auth()->user()->can('user-str-edit') ||
                                        auth()->user()->can('user-str-delete'))
                                    <th>Aksi</th>
                                @endif
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

    {{-- Transkrip --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @can('user-sip-create')
                <div class="button-add">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"
                        data-target="#modaladdSIP">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Berkas SIP</span>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered berkas-perizinan" id="tbSIP" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Nomor SIP</th>
                                <th>Nomor Reg STR</th>
                                <th>Bidang Kesehatan</th>
                                <th>Update</th>
                                @if (auth()->user()->can('user-sip-view') ||
                                        auth()->user()->can('user-sip-edit') ||
                                        auth()->user()->can('user-sip-delete'))
                                    <th>Aksi</th>
                                @endif
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

    <!-- Modal Tambah STR -->
    <div class="modal fade" id="modaladdSTR" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Surat Tanda Registrasi (STR)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_str"></div>
                    <form method="POST" id="form-tambah-str" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="id_pegawai_str" id="id_pegawai_str" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_str" id="nik_str" value="{{ $pegawai->nik }}"
                            name="nik_pegawai"> --}}
                        <div class="form-group">
                            <label for="nama_file_str_id" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_str_id" id="nama_file_str_id" name="nama_file_str_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_reg_str" class="col-form-label">Nomor Reg STR <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_reg_str" id="no_reg_str" name="no_reg_str">
                        </div>
                        <div class="form-group">
                            <label for="kompetensi" class="col-form-label">Kompetensi <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control kompetensi" id="kompetensi" name="kompetensi">
                        </div>
                        <div class="form-group">
                            <label for="tgl_ed" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat" class="col-form-label">Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat" id="pengingat" name="pengingat">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="add_str">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Tambah STR -->

    <!-- Modal Edit STR -->
    <div class="modal fade" id="modaleditSTR" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Surat Tanda Registrasi (STR)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_str_edit"></div>
                    <form method="POST" id="form-edit-str" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="id-str-edit" name="id">
                        <input type="hidden" class="form-control" id="id-str-pegawai-edit" name="id_pegawai">
                        {{-- <input type="hidden" class="form-control" id="nik-str-edit" name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_str_id_edit" class="col-form-label">Nama Dokumen <label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_str_id_edit" id="nama_file_str_id_edit"
                                name="nama_file_str_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_reg_str_edit" class="col-form-label">Nomor Reg STR <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_reg_str_edit" id="no_reg_str_edit"
                                name="no_reg_str">
                        </div>
                        <div class="form-group">
                            <label for="kompetensi_edit" class="col-form-label">Kompetensi <label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control kompetensi" id="kompetensi_edit"
                                name="kompetensi">
                        </div>
                        <div class="form-group">
                            <label for="tgl_ed_edit" class="col-form-label">Berkalu Sampai <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control tgl_ed_edit" id="tgl_ed_edit" name="tgl_ed">
                        </div>
                        <div class="form-group">
                            <label for="pengingat_edit" class="col-form-label">Pengingat <label
                                    class="text-danger">*</label></label>
                            <input type="date" class="form-control pengingat_edit" id="pengingat_edit"
                                name="pengingat">
                        </div>
                        <div class="form-group">
                            <label for="file_edit" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                            <input type="file" class="form-control file" id="file_edit" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="add_str">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal STR -->

    <!-- Modal Tambah SIP -->
    <div class="modal fade" id="modaladdSIP" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Surat Izin Praktik (SIP)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_sip"></div>
                    <form method="POST" id="form-tambah-sip" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" class="id_pegawai_sip" id="id_pegawai_sip" value="{{ $pegawai->id }}"
                            name="id_pegawai">
                        {{-- <input type="hidden" class="nik_sip" id="nik_sip" value="{{ $pegawai->nik }}"
                         name="nik_pegawai"> --}}

                        <div class="form-group">
                            <label for="nama_file_sip_id" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_sip_id" id="nama_file_sip_id" name="nama_file_sip_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_sip" class="col-form-label">Nomor SIP<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_sip" id="no_sip" name="no_sip">
                        </div>
                        <div class="form-group">
                            <label for="no_reg" class="col-form-label">Nomor Reg STR<label
                                    class="text-danger">*</label></label>
                            {{-- <select class="custom-select no_reg" id="no_reg" name="no_reg"> --}}
                            {{-- <option value="" selected>Choose...</option> --}}
                            <select class="form-select select-str" id="no_reg_sip" name="no_reg"></select>
                            {{-- @foreach ($file_str as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_reg_str }}</option>
                                @endforeach --}}
                            {{-- </select> --}}
                        </div>
                        <div class="form-group">
                            <label for="filesip" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control filesip" id="filesip" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="add_sip">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Tambah STR -->

    <!-- Modal Edit SIP -->
    <div class="modal fade" id="modaleditSIP" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Surat Izin Praktik (SIP)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error_list_sip_edit"></div>
                    <form method="POST" id="form-edit-sip" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" class="id_pegawai_sip" id="id_pegawai_sip_edit" value="{{ $pegawai->id }}"
                      name="id_pegawai">
                  <input type="hidden" class="nik_sip" id="nik_sip_edit" value="{{ $pegawai->nik }}"
                      name="nik_pegawai"> --}}
                        <input type="hidden" id="id-sip-edit" name="id">

                        <div class="form-group">
                            <label for="nama_file_sip_id_edit" class="col-form-label">Nama Dokumen<label
                                    class="text-danger">*</label></label>
                            <select class="custom-select nama_file_sip_id_edit" id="nama_file_sip_id_edit"
                                name="nama_file_sip_id">
                                <option value="" selected>Choose...</option>
                                @foreach ($master_berkas_izin as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_sip_edit" class="col-form-label">Nomor SIP<label
                                    class="text-danger">*</label></label>
                            <input type="text" class="form-control no_sip_edit" id="no_sip_edit" name="no_sip">
                        </div>
                        <div class="form-group">
                            <label for="no_reg_sip_edit" class="col-form-label">Nomor Reg STR<label
                                    class="text-danger">*</label></label>
                            {{-- <select class="custom-select no_reg_sip_edit" id="no_reg_sip_edit" name="no_reg">
                                <option value="" selected>Choose...</option>
                                @foreach ($file_str as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_reg_str }}</option>
                                @endforeach
                            </select> --}}
                            <select class="form-select select-str-edit" id="no_reg_sip_edit" name="no_reg"></select>
                        </div>
                        <div class="form-group">
                            <label for="filesip" class="col-form-label">File <span
                                    class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                            <input type="file" class="form-control filesip" id="filesip" name="file">
                            <small>Ukuran maksimal 2MB</small>
                        </div>
                        <p class="text-danger">*Wajib Diisi</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning" id="submit_edit_sip">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ./ end Modal Tambah SIP -->

    <!-- Modal View STR PDF -->
    <div class="modal fade " id="modalSTR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Surat Tanda Registrasi (STR)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-str-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->

    <!-- Modal View SIP PDF -->
    <div class="modal fade " id="modalSIP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Surat Izin Praktik (SIP)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view-sip-modal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ end Modal -->
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/vendor/PDFObject-master/pdfobject.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select-str').select2({
                minimumResultsForSearch: -1,
                //minimumInputLength: 3,
                ajax: {
                    type: "GET",
                    url: '{{ route('str.get') }}',
                    dataType: 'json',
                    // data: function(params) {
                    //     var query = {
                    //         search: params.term,
                    //     }

                    //     // Query parameters will be ?search=[term]&type=public
                    //     return query;
                    // },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaladdSIP",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                //placeholder: $(this).data('placeholder'),

            });

            $('.select-str-edit').select2({
                //minimumInputLength: 3,
                minimumResultsForSearch: -1,
                ajax: {
                    type: "GET",
                    url: '{{ route('str.get') }}',
                    dataType: 'json',
                    // data: function(params) {
                    //     var query = {
                    //         search: params.term,
                    //     }

                    //     // Query parameters will be ?search=[term]&type=public
                    //     return query;
                    // },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                },
                theme: "bootstrap-5",
                dropdownParent: "#modaleditSIP",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                //placeholder: $(this).data('placeholder'),

            });
        });
    </script>
    <script>
        var idpegawai = $('#id-pegawai').val();
        $(document).ready(function() {

            var tabelSTR = $('#tbSTR').DataTable({
                // ordering: false,
                paging: true,
                // scrollX: true,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengguna.getSTR') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_berkas',
                        name: 'nama_berkas'
                    },
                    {
                        data: 'no_reg_str',
                        name: 'no_reg_str'
                    },
                    {
                        data: 'kompetensi',
                        name: 'kompetensi'
                    },
                    {
                        data: function(data, row, type) {
                            if (data.status === 'nonactive') {
                                return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-danger"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Berakhir</small>
                                `;
                            } else if (data.status === 'proses') {
                                return `
                                <span class="badge badge-danger"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Masa Dokumen Akan Berakhir (Ingatkan)</small>
                                `;
                            } else if (data.status === 'changed') {
                                return `
                                <span class="badge badge-secondary"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-secondary"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span><br>
                                <small><i class="fas fa-info-circle"></i> Dokumen Sudah ada Yang Baru (Diperbaharui)</small>
                                `;
                            } else {
                                return `
                                <span class="badge badge-success"><i class="fas fa-bell"></i> ${data.pengingat}</span>
                                <span class="badge badge-info"><i class="fas fa-calendar-alt"></i> ${data.tgl_ed}</span>
                                
                                `;
                            }
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-str-view') ||
                            auth()->user()->can('user-str-edit') ||
                            auth()->user()->can('user-str-delete'))
                        {
                            // {{ asset('/File/Pegawai/Dokumen/STR/${data.file}') }}
                            data: null,
                            render: function(data, row, type) {
                                return `
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" title="Aksi Dokumen" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('user-str-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}"  title="Lihat Dokumen" id="view-str"  data-toggle="modal" data-target="#modalSTR">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-str-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSTR" id="edit_str">Edit Dokumen</a>
                                        @endcan
                                        @can('user-str-delete')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_str"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                        `;
                            }
                        },
                    @endif
                ]
            });


            //VIEW Berkas STR
            $(document).on('click', '#view-str', function(e) {
                e.preventDefault();
                var namafile = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/STR/' + namafile, "#view-str-modal");
            });

            $('#form-tambah-str').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-str')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.str.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_str').html("")
                            $('#error_list_str').addClass("alert alert-danger")
                            $('#error_list_str').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_str').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladdSTR').modal('hide')
                            $('#modaladdSTR').find('.form-control').val("");
                            $('#tbSTR').DataTable().ajax.reload();

                            // location.reload();
                        }
                    }
                });
            });

            $('#modaladdSTR').on('hidden.bs.modal', function() {
                $('#modaladdSTR').find('.form-control').val("");
                $('#modaladdSTR').find('.custom-file-input').val("");

                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas STR
            $(document).on('click', '#edit_str', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.str.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#id-str-edit').val(response.data.id);
                        $('#id-str-pegawai-edit').val(response.data.id_pegawai);
                        // $('#nik-str-edit').val(response.data.nik_pegawai);
                        $('#nama_file_str_id_edit').val(response.data.nama_file_str_id);
                        $('#no_reg_str_edit').val(response.data.no_reg_str);
                        $('#kompetensi_edit').val(response.data.kompetensi);
                        $('#tgl_ed_edit').val(response.data.tgl_ed);
                        $('#pengingat_edit').val(response.data.pengingat);
                    }
                });
            });

            //UPDATE Berkas STR
            $('#form-edit-str').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-str-edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-str')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.str.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_str_edit').html("")
                            $('#error_list_str_edit').addClass("alert alert-danger")
                            $('#error_list_str_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_str_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditSTR').modal('hide')
                            $('#modaleditSTR').find('.form-control').val("");
                            var tbSTR = $('#tbSTR').DataTable();
                            tbSTR.ajax.reload();

                            // location.reload();


                        }
                    }
                });
            });

            $('#modaleditSTR').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
            });

            //HAPUS STR
            $(document).on('click', '#hapus_str', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas STR ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.str.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            var tbSTR = $('#tbSTR').DataTable();
                            tbSTR.ajax.reload();

                            // location.reload();

                        }
                    });
                }
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            var tabelSTR = $('#tbSIP').DataTable({
                // ordering: false,
                paging: true,
                // scrollX: true,
                bInfo: true,
                searching: true,
                // processing: true,
                serverSide: true,
                ajax: '{{ route('pengguna.getSIP') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_berkas',
                        name: 'nama_berkas'
                    },
                    {
                        data: 'no_sip',
                        name: 'no_sip'
                    },
                    {
                        data: 'no_reg_str',
                        name: 'no_reg_str'
                    },
                    {
                        data: 'kompetensi',
                        name: 'kompetensi'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    @if (auth()->user()->can('user-sip-view') ||
                            auth()->user()->can('user-sip-edit') ||
                            auth()->user()->can('user-sip-delete'))
                        {
                            // {{ asset('/Pegawai/Dokumen/STR/${data.file}') }}
                            data: null,
                            render: function(data, row, type) {
                                return `
                           
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-solid fa-bars"></i>
                                       
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('user-sip-view')
                                        <a class="dropdown-item" href="#" data-id="${data.file}"   title="Lihat Dokumen" id="view-sip"  data-toggle="modal" data-target="#modalSIP">Lihat Dokumen</a>
                                        @endcan
                                        @can('user-sip-edit')
                                        <a class="dropdown-item" href="#" data-id="${data.id}"  title="Edit Dokumen" data-toggle="modal" data-target="#modaleditSIP" id="edit_sip">Edit Dokumen</a>
                                        @endcan
                                        @can('user-sip-delete')
                                        <a class="dropdown-item text-danger" href="#"  data-id="${data.id}" id="hapus_sip"  title="Hapus Dokumen">Hapus</a>
                                        @endcan
                                    </div>
                                </div>
                           
                                `;
                            }
                        },
                    @endif
                ]
            });

            //VIEW Berkas SIP
            $(document).on('click', '#view-sip', function(e) {
                e.preventDefault();
                var fileSIP = $(this).data('id');
                var url = '{{ route('login.index') }}';
                PDFObject.embed(url + '/File/Pegawai/Dokumen/SIP/' + fileSIP, "#view-sip-modal");
            });

            $('#form-tambah-sip').on('submit', function(e) {
                e.preventDefault();
                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-tambah-sip')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.sip.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_sip').html("")
                            $('#error_list_sip').addClass("alert alert-danger")
                            $('#error_list_sip').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_sip').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-success")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaladdSIP').modal('hide')
                            $('#modaladdSIP').find('.form-control').val("");

                            var tbSIP = $('#tbSIP').DataTable();
                            tbSIP.ajax.reload();
                        }
                    }
                });
            });

            $('#modaladdSIP').on('hidden.bs.modal', function() {
                $('#modaladdSIP').find('.form-control').val("");
                $('#modaladdSIP').find('.custom-file-input').val("");
                $('.select-str').val(null).trigger('change');
                $('.alert-danger').addClass('d-none');
            });

            //EDIT Berkas SIp
            $(document).on('click', '#edit_sip', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ route('pengguna.sip.edit') }}",
                    data: {
                        'id': $(this).data('id'),
                    },
                    dataType: "json",
                    success: function(response) {

                        $('#id-sip-edit').val(response.data.id);
                        $('#nama_file_sip_id_edit').val(response.data.nama_file_sip_id);
                        $('#no_sip_edit').val(response.data.no_sip);
                        $('#no_reg_sip_edit').val(response.data.no_reg);
                    }
                });
            });

            //UPDATE Berkas SIP
            $('#form-edit-sip').on('submit', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-sip-edit').val(),
                }

                var file = $('.file').val();
                var rename = file.replace("C:\\fakepath\\", "");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var form = $('#form-edit-sip')[0];
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    enctype: "multipart/form-data",
                    url: "{{ route('pengguna.sip.update') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list_sip_edit').html("")
                            $('#error_list_sip_edit').addClass("alert alert-danger")
                            $('#error_list_sip_edit').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list_sip_edit').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                            $('#modaleditSIP').modal('hide')
                            $('#modaleditSIP').find('.form-control').val("");
                            var tbSIP = $('#tbSIP').DataTable();
                            tbSIP.ajax.reload();
                        }
                    }
                });
            });

            $('#modaleditSIP').on('hidden.bs.modal', function() {
                // $('#modalJenjang').find('.form-control').val("");
                $('.alert-danger').addClass('d-none');
                $('.select-str-edit').val(null).trigger('change');
            });

            //HAPUS SIP
            $(document).on('click', '#hapus_sip', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm('Yakin Ingin Menghapus Berkas SIP ?')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengguna.sip.destroy') }}",
                        data: {
                            'id': $(this).data('id'),
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#success_message').html("")
                            $('#success_message').removeClass("alert-primary")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').addClass("alert alert-warning")
                            $('#success_message').text(response.message)
                            var tbSIP = $('#tbSIP').DataTable();
                            tbSIP.ajax.reload();

                        }
                    });
                }
            });
        });
    </script>
@endpush
@push('custom-css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/vendor/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css') }}">

    <style>
        .pdfobject-container {
            height: 35rem;
            border: 1rem solid rgba(0, 0, 0, .1);
        }
    </style>
@endpush
