<!-- Modal Tambah Verifikasi Ijazah -->
<div class="modal fade" id="modal-add-bukti" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti Verifikasi Ijazah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Error container untuk semua error -->
                <div id="error_list_bukti" class="alert alert-danger d-none">
                    <ul class="mb-0"></ul>
                </div>

                <form method="POST" id="form-tambah-bukti" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id-ijazah-bukti" name="ijazah_id">
                    <div class="form-group">
                        <label for="file-bukti" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-bukti" name="file">
                        <small>Ukuran maksimal 2MB</small>
                        <!-- Error untuk file bukti -->
                        <div id="error_file-bukti" class="invalid-feedback d-none"></div>
                    </div>
                    <div class="form-group">
                        <label for="ket-bukti" class="col-form-label">Keterangan</label>
                        <input type="text" class="form-control" id="ket-bukti" name="ket_bukti">
                        <!-- Error untuk keterangan -->
                        <div id="error_ket-bukti" class="invalid-feedback d-none"></div>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-login" id="add_verif_ijazah">Simpan</button>
                        <button class="btn btn-success d-none" id="add_verif_ijazah_disabled" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Verifikasi STR -->
<div class="modal fade" id="modal-add-bukti-str" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti Verifikasi STR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_bukti_str"></div>
                <form method="POST" id="form-tambah-bukti-str" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id-str-bukti" name="str_id">
                    <div class="form-group">
                        <label for="file-bukti-str" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-bukti-str" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="ket-bukti-str" class="col-form-label">Keterangan</label>
                        <input type="text" class="form-control" id="ket-bukti-str" name="ket_bukti">
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add_bukti_str">Simpan</button>
                        <button class="btn btn-success d-none" id="add_bukti_str_disabled" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah Masa Berlaku SIP -->
<div class="modal fade" id="modal-add-masa-berlaku" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Masa Berlaku SIP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Error container untuk semua error -->
                <div id="error_list_berlaku_sip" class="alert alert-danger d-none">
                    <ul class="mb-0"></ul>
                </div>

                <form method="POST" id="form-masa-berlaku-sip" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="sip_id_masa_berlaku" name="sip_id_masa_berlaku">
                    <div class="form-group">
                        <label for="tgl_ed_sip" class="col-form-label">Berlaku Sampai <label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control tgl_ed_sip" id="tgl_ed_sip" name="tgl_ed_sip">
                        <!-- Error untuk tanggal berlaku -->
                        <div id="error_tgl_ed_sip" class="invalid-feedback d-none"></div>
                    </div>

                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-login"
                            id="add_masa_berlaku">Simpan</button>
                        <button class="btn btn-success btn-login-disabled d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
