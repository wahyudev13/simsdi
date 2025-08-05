<!-- Modal Tambah Sertifikat -->
<div class="modal fade" id="modaladd_sertif" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list"></div>
                <form id="form-add-sertif">
                    @csrf
                    <input type="hidden" id="id_pegawai" value="{{ $pegawai->id }}" name="id_pegawai">

                    <div class="form-group">
                        <label for="berkas_id">Sertifikat <label class="text-danger">*</label></label>
                        <select class="form-control" id="berkas_id" name="berkas_id">
                            <option value="" selected>Pilih Jenis Pelatihan</option>
                            @foreach ($master_berkas_kompetensi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nm_kegiatan" class="col-form-label">Nama Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="nm_kegiatan" name="nm_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="tgl_kegiatan" class="col-form-label">Tanggal Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl_kegiatan" name="tgl_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="tmp_kegiatan" class="col-form-label">Tempat Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="tmp_kegiatan" name="tmp_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="penye_kegiatan" class="col-form-label">Penyelenggara Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="penye_kegiatan" name="penye_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File Sertifikat <span
                                class="badge badge-secondary">.pdf
                            </span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-login" id="add">Simpan</button>
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
<!-- ./ end Modal  -->

<!-- Modal Tambah Sertifikat -->
<div class="modal fade" id="editmodal_sertif" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sertifikat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_edit"></div>
                <form id="form-edit-sertif">
                    @csrf
                    <input type="hidden" id="id-pegawai-edit" name="id_pegawai">
                    <input type="hidden" id="id_sertif" name="id">

                    <div class="form-group">
                        <label for="berkas_id_edit">Sertifikat <label class="text-danger">*</label></label>
                        <select class="form-control" id="berkas_id_edit" name="berkas_id">
                            <option value="" selected>Pilih Jenis Pelatihan</option>
                            @foreach ($master_berkas_kompetensi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nm_kegiatan_edit" class="col-form-label">Nama Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="nm_kegiatan_edit" name="nm_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="tgl_kegiatan_edit" class="col-form-label">Tanggal Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl_kegiatan_edit" name="tgl_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="tmp_kegiatan_edit" class="col-form-label">Tempat Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="tmp_kegiatan_edit" name="tmp_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="penye_kegiatan_edit" class="col-form-label">Penyelenggara Kegiatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="penye_kegiatan_edit" name="penye_kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="file_edit" class="col-form-label">File Sertifikat <span
                                class="badge badge-secondary">.pdf
                            </span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file_edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-update"
                            id="edit_sertifikat">Update</button>
                        <button class="btn btn-primary btn-update-disabled d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- ./ end Modal -->
