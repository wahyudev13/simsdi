<!-- Modal Tambah Ijzah -->
<div class="modal fade" id="modal-add-ijazah" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_ijazah"></div>
                <form method="POST" id="form-tambah-ijazah" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                        name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_id" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_id" id="nama_file_id" name="nama_file_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_pendidikan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor" class="col-form-label">Nomor<label class="text-danger">*</label></label>
                        <input type="text" class="form-control nomor" id="nomor" name="nomor">
                    </div>
                    <div class="form-group">
                        <label for="asal" class="col-form-label">Asal<label class="text-danger">*</label></label>
                        <input type="text" class="form-control asal" id="asal" name="asal">
                    </div>
                    <div class="form-group">
                        <label for="thn_lulus" class="col-form-label">Tahun Lulus<label
                                class="text-danger">*</label></label>
                        <input type="number" class="form-control thn_lulus" id="thn_lulus" name="thn_lulus">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File <span class="badge badge-secondary">.pdf
                            </span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control file" id="file" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-login" id="add_ijazah">Simpan</button>
                        <button class="btn btn-primary btn-login-disabled d-none" id="add_ijazah_disabled"
                            type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal Tambah Ijzah -->

<!-- Modal Edit Ijzah -->
<div class="modal fade" id="modal-edit-ijazah" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Ijazah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_ijazah_edit"></div>
                <form method="POST" id="form-edit-ijazah" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" id="id_ijazah" name="id_ijazah">
                    <input type="hidden" class="form-control" id="id_pegawai_ijazah_edit" name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_ijazah_edit" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_ijazah_edit" id="nama_file_ijazah_edit"
                            name="nama_file_ijazah_edit">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_pendidikan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_ijazah_edit" class="col-form-label">Nomor<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control nomor_ijazah_edit" id="nomor_ijazah_edit"
                            name="nomor_ijazah_edit">
                    </div>
                    <div class="form-group">
                        <label for="asal_ijazah_edit" class="col-form-label">Asal<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control asal_ijazah_edit" id="asal_ijazah_edit"
                            name="asal_ijazah_edit">
                    </div>
                    <div class="form-group">
                        <label for="thn_lulus_ijazah_edit" class="col-form-label">Tahun Lulus<label
                                class="text-danger">*</label></label>
                        <input type="number" class="form-control thn_lulus_ijazah_edit" id="thn_lulus_ijazah_edit"
                            name="thn_lulus_ijazah_edit">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control file" id="file-edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-login" id="update_ijazah">Update</button>
                        <button class="btn btn-primary d-none" id="update_ijazah_disabled" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal Edit Ijzah -->

<!-- Modal View Ijzah PDF -->
<div class="modal fade" id="modalIjazah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ijazah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="view-ijazah-modal"></div>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal View Ijzah -->

<!-- Modal Tambah Transkrip Akademik -->
<div class="modal fade" id="modal-add-transkrip" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transkrip Akademik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_transkrip"></div>
                <form method="POST" id="form-tambah-transkrip" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai" id="id_pegawai" value="{{ $pegawai->id }}"
                        name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_trans_id" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_trans_id" id="nama_file_trans_id"
                            name="nama_file_trans_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_pendidikan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_transkrip" class="col-form-label">Nomor Transkrip<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control nomor_transkrip" id="nomor_transkrip"
                            name="nomor_transkrip">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control file" id="file" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-login" id="add_transkrip">Simpan</button>
                        <button class="btn btn-primary btn-login-disabled d-none" id="add_transkrip_disabled"
                            type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal Tambah Transkrip Akademik -->

<!-- Modal Edit Transkrip Akademik -->
<div class="modal fade" id="modal-edit-transkrip" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Transkrip Akademik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_transkrip_edit"></div>
                <form method="POST" id="form-edit-transkrip" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" id="id-trans-edit" name="id">
                    <input type="hidden" class="form-control" id="id-trans-pegawai-edit" name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_trans_id_edit" class="col-form-label">Nama Dokumen</label>
                        <select class="custom-select nama_file_trans_id_edit" id="nama_file_trans_id_edit"
                            name="nama_file_trans_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_pendidikan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_transkrip_edit" class="col-form-label">Nomor Transkrip</label>
                        <input type="text" class="form-control nomor_transkrip_edit" id="nomor_transkrip_edit"
                            name="nomor_transkrip">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span></label>
                        <input type="file" class="form-control file" id="file" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-login"
                            id="update_transkrip">Update</button>
                        <button class="btn btn-primary btn-login-disabled d-none" id="update_transkrip_disabled"
                            type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal Edit Transkrip Akademik -->

<!-- Modal View Transkrip PDF -->
<div class="modal fade" id="modalTranskrip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transkrip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="view-transkrip-modal"></div>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal View Transkrip -->
