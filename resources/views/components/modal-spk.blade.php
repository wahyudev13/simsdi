<!-- Modal Tambah SPK RKK -->
<div class="modal fade" id="modal-add-spk" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah SPK & RKK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_spk"></div>
                <form method="POST" id="form-tambah-spk" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_pegawai_spk" value="{{ $pegawai->id }}" name="id_pegawai">
                    <div class="form-group">
                        <label for="no-spk" class="col-form-label">Nomor SPK <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="no-spk" name="no_spk">
                    </div>
                    <div class="form-group">
                        <label for="dep-spk" class="col-form-label">Unit Kerja <label
                                class="text-danger">*</label></label>
                        <select class="form-select select2 select-unit-kerja" id="dep-spk" name="dep_spk"
                            data-placeholder="Pilih Unit Kerja">
                            <option value="">-- Pilih --</option>
                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kualifikasi" class="col-form-label">Kualifikasi <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="kualifikasi" name="kualifikasi">
                    </div>
                    <div class="form-group">
                        <label for="file-spk" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-spk" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-spk">Simpan</button>
                        <button type="submit" class="btn btn-success d-none" id="add-spk-disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit SPK RKK -->
<div class="modal fade" id="modal-edit-spk" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit SPK & RKK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_spk_edit"></div>
                <form method="POST" id="form-edit-spk" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_pegawai_spk_edit" name="id_pegawai">
                    <input type="hidden" id="id_spk_edit" name="id">
                    <div class="form-group">
                        <label for="no-spk-edit" class="col-form-label">Nomor SPK <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="no-spk-edit" name="no_spk">
                    </div>
                    <div class="form-group">
                        <label for="dep-spk-edit" class="col-form-label">Unit Kerja <label
                                class="text-danger">*</label></label>
                        <select class="form-select select2 select-unit-kerja-edit" id="dep-spk-edit" name="dep_spk"
                            data-placeholder="Pilih Unit Kerja">
                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kualifikasi-edit" class="col-form-label">Kualifikasi <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="kualifikasi-edit" name="kualifikasi">
                    </div>
                    <div class="form-group">
                        <label for="file-spk-edit" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-spk-edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-spk-edit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
