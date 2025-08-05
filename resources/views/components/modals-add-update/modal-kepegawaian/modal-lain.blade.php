<!-- Modal Tambah Berkas Lain-lain -->
<div class="modal fade" id="modal-add-lain" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Lain-Lain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_lainlain"></div>
                <form method="POST" id="form-tambah-lainlain" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_pegawai_lain" value="{{ $pegawai->id }}" name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_id_lainlain" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select" id="nama_file_id_lainlain" name="nama_file_id_lainlain">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_lain as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file-lainlain" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-lainlain" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-lainlain">Simpan</button>
                        <button type="submit" class="btn btn-success d-none" id="add-lainlain-disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Berkas Lain-lain -->
<div class="modal fade" id="modal-edit-lain" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Lain-Lain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_lainlain_edit"></div>
                <form method="POST" id="form-edit-lainlain" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_lain_lain" name="id_lain">
                    <div class="form-group">
                        <label for="nama_file_id_lainlain_edit" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select" id="nama_file_id_lainlain_edit" name="nama_file_id_lainlain">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_lain as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file-lainlain-edit" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-lainlain-edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="update-lainlain">Update</button>
                        <button type="submit" class="btn btn-success d-none" id="update-lainlain-disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
