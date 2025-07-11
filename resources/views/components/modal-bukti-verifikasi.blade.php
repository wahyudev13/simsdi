<!-- Modal Tambah Bukti Verifikasi -->
<div class="modal fade" id="modal-add-bukti-{{ $type ?? 'verifikasi' }}" data-backdrop="static" data-keyboard="false"
    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti Verifikasi {{ $title ?? 'Dokumen' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_bukti_{{ $type ?? 'verifikasi' }}"></div>
                <form method="POST" id="form-tambah-bukti-{{ $type ?? 'verifikasi' }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id-{{ $type ?? 'dokumen' }}-bukti" name="{{ $id_field ?? 'dokumen_id' }}">
                    <div class="form-group">
                        <label for="file-bukti-{{ $type ?? 'verifikasi' }}" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-bukti-{{ $type ?? 'verifikasi' }}"
                            name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <div class="form-group">
                        <label for="ket-bukti-{{ $type ?? 'verifikasi' }}" class="col-form-label">Keterangan</label>
                        <input type="text" class="form-control" id="ket-bukti-{{ $type ?? 'verifikasi' }}"
                            name="ket_bukti">
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"
                            id="add_bukti_{{ $type ?? 'verifikasi' }}">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./ end Modal -->
