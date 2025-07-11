<!-- Modal Tambah Berkas Data Diri -->
<div class="modal fade" id="modaladd_Identitas" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Data Diri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_lain"></div>
                <form method="POST" id="form-tambah-lain" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai_lain" id="id_pegawai_lain" value="{{ $pegawai->id }}"
                        name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_lain_id" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_lain_id" id="nama_file_lain_id" name="nama_file_lain_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_identitas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filelain" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                class="text-danger">*</label></label>
                        <input type="file" class="form-control filelain" id="filelain" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add_lain">Simpan</button>
                        <button type="submit" class="btn btn-success d-none" id="add_lain_disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Berkas Data Diri -->
<div class="modal fade" id="modaledit_Identitas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Lain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_lain_edit"></div>
                <form method="POST" id="form-edit-lain" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id-lain-edit" name="id">
                    <div class="form-group">
                        <label for="nama_file_lain_id_edit" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_lain_id_edit" id="nama_file_lain_id_edit"
                            name="nama_file_lain_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_identitas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filelain_edit" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf,jpg,jpeg,png</span><label
                                class="text-danger">*</label></label>
                        <input type="file" class="form-control filelain_edit" id="filelain_edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="submit_edit_lain">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
