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
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="enable_exp_str"
                                name="enable_exp_str">
                            <label class="custom-control-label" for="enable_exp_str"><strong>Aktifkan Masa Berlaku
                                    STR</strong></label>
                        </div>
                    </div>
                    <div id="masa-berlaku"></div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control file" id="file" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning btn-login" id="add_str">Simpan</button>
                        <button class="btn btn-warning btn-login-disabled d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit STR -->
<div class="modal fade" id="modaleditSTR" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="enable_exp_str_edit"
                                name="enable_exp_str_edit">
                            <label class="custom-control-label" for="enable_exp_str_edit"><strong>Aktifkan Masa
                                    Berlaku STR</strong></label>
                        </div>
                    </div>
                    <div id="masa-berlaku-edit"></div>
                    <div class="form-group">
                        <label for="file_edit" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control file" id="file_edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning btn-login" id="add_str">Update</button>
                        <button class="btn btn-warning btn-login-disabled d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
