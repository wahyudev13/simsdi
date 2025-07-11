<!-- Modal Tambah Transkrip Akademik -->
<div class="modal fade" id="modaladdTrans" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transkrip Akademik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_trans"></div>
                <form method="POST" id="form-tambah-trans" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-primary" id="add_transkrip">Simpan</button>
                        <button type="submit" class="btn btn-primary d-none" id="add_transkrip_disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Transkrip Akademik -->
<div class="modal fade" id="modaleditTrans" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Transkrip Akademik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_trans_edit"></div>
                <form method="POST" id="form-edit-trans" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-primary" id="update_trans">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
