<!-- Modal Tambah Ijazah -->
<div class="modal fade" id="modalUpload" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Ijazah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list"></div>
                <form method="POST" id="form-tambah-berkas" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-primary btn-login" id="add_file">Simpan</button>
                        <button class="btn btn-primary btn-login-disabled d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Ijazah -->
<div class="modal fade" id="editmodalUpload" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Ijazah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_edit"></div>
                <form method="POST" id="form-update-berkas" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" id="id-ijazah-edit" name="id">
                    <input type="hidden" class="form-control" id="id-pegawai-edit" name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_id" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_id" id="nama-file-edit" name="nama_file_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_pendidikan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor" class="col-form-label">Nomor<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control nomor" id="nomor-edit" name="nomor">
                    </div>
                    <div class="form-group">
                        <label for="asal" class="col-form-label">Asal<label class="text-danger">*</label></label>
                        <input type="text" class="form-control asal" id="asal_edit" name="asal">
                    </div>
                    <div class="form-group">
                        <label for="thn_lulus" class="col-form-label">Tahun Lulus<label
                                class="text-danger">*</label></label>
                        <input type="number" class="form-control thn_lulus" id="lulus-edit" name="thn_lulus">
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
                        <button type="submit" class="btn btn-primary" id="update_file">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
