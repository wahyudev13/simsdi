<!-- Modal Tambah Verifikasi STR -->
<div class="modal fade" id="modal-add-bukti-str" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal -->
