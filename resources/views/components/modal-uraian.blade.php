<!-- Modal Tambah Uraian -->
<div class="modal fade" id="modal-add-uraian" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Uraian Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_uraian"></div>
                <form method="POST" id="form-tambah-uraian" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_pegawai_uraian" value="{{ $pegawai->id }}" name="id_pegawai">
                    <div class="form-group">
                        <label for="dep-uraian">Unit Kerja <label class="text-danger">*</label></label>
                        <select class="form-select select2 select-departemen" id="dep-uraian"
                            data-placeholder="Pilih Unit Kerja" name="dep_uraian">
                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="col-form-label">Jabatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan">
                    </div>
                    <div class="form-group">
                        <label for="file-uraian" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-uraian" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-uraian">Simpan</button>
                        <button type="submit" class="btn btn-success d-none" id="add-uraian-disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Uraian -->
<div class="modal fade" id="modal-edit-uraian" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Uraian Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_uraian_edit"></div>
                <form method="POST" id="form-edit-uraian" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_uraian" name="id">
                    <input type="hidden" id="id_pegawai_uraian_edit" name="id_pegawai">
                    <div class="form-group">
                        <label for="dep-uraian-edit">Unit Kerja <label class="text-danger">*</label></label>
                        <select class="form-select select2 select-departemen-edit" id="dep-uraian-edit"
                            data-placeholder="Pilih Unit Kerja" name="dep_uraian">
                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan-edit" class="col-form-label">Jabatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="jabatan-edit" name="jabatan">
                    </div>
                    <div class="form-group">
                        <label for="file-uraian-edit" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-uraian-edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-uraian">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
